<?php
class Wage_Amazonsync_Model_Observer
{
    /**
     * @param Varien_Event_Observer $event
     */
    public function controllerFrontInitBefore(Varien_Event_Observer $event)
    {
        self::init();
    }

    static function init()
    {
        // Add our vendor folder to our include path
        //set_include_path(get_include_path() . PATH_SEPARATOR . Mage::getBaseDir('lib') . '/Wage');

        require_once(Mage::getBaseDir('lib') . '/Wage/aws-autoloader.php');

    }

}