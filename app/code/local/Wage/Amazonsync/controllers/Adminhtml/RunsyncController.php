<?php

class Wage_Amazonsync_Adminhtml_RunsyncController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $session = Mage::getSingleton('adminhtml/session');
        try {
            $sync = Mage::getModel('amazonsync/syncfile')->syncDirectory();
            $session->addSuccess(Mage::helper('amazonsync')->__($sync));
        } catch (Mage_Core_Exception $e) {
            $session->addError($e->getMessage());
        }

        $this->_redirectReferer();
    }
}