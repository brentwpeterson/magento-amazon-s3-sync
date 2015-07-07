<?php

class Wage_Amazonsync_Model_Syncfile extends Mage_Core_Model_Abstract
{
    public function syncDirectory()
    {
        $accessKey = Mage::getStoreConfig('amazonsync/general/access_key_id');
        $secretKey = Mage::getStoreConfig('amazonsync/general/secret_access_key');
        $bucket = Mage::getStoreConfig('amazonsync/general/s3_bucket_path');
        $prefix = Mage::getStoreConfig('amazonsync/general/prefix');
        $magentoDir = Mage::getStoreConfig('amazonsync/general/magento_directory');
        $magentoDir = Mage::getBaseDir()."/".$magentoDir;

        //Return if S3 settings are empty
        if (!($accessKey && $secretKey && $bucket)) {
            return;
        }

        //Prepare meta data for uploading. All uploaded images are public
        $meta = array(Zend_Service_Amazon_S3::S3_ACL_HEADER
        => Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ);

        $s3 = new Zend_Service_Amazon_S3($accessKey, $secretKey);

        //Build prefix for all files on S3
        if ($prefix) {
            $cdnPrefix = $bucket . '/' . $prefix;
        } else {
            $cdnPrefix = $bucket;
        }
        $allFiles = array();

        if (is_dir($magentoDir)) {
            $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($magentoDir), RecursiveIteratorIterator::SELF_FIRST);
            $dir = null;

            foreach ($objects as $name => $object) {
                //Get name of the file and create its key on S3
                if (!($object->getFileName() == '.' || $object->getFileName() == '..')) {
                    if (is_dir($object)) {
                        continue;
                    }

                    $fileName = str_replace($magentoDir, '', $name);
                    $cdnPath = $cdnPrefix . $fileName;

                    //Full path to uploaded file
                    $file = $name;

                    //Upload original file
                    $allFiles[] = $cdnPath;
                    if (!$s3->putFile($file, $cdnPath, $meta)) {
                        $msg = 'Can\'t upload original image (' . $file . ') to S3 with '
                            . $cdnPath . ' key';

                        throw new Mage_Core_Exception($msg);
                    }
                }
            }

            //Remove Not Matched Files
            foreach ($s3->getObjectsByBucket($bucket) as $object) {
                $object = $bucket.'/'.$object;
                if (!in_array($object, $allFiles)) {
                    $s3->removeObject($object);
                }
            }

            return 'All files uploaded to S3 with '. $bucket . ' bucket';
        } else {
            $msg = $magentoDir . ' directory does not exist';
            throw new Mage_Core_Exception($msg);
        }
    }
}
