<?php

class Wage_Amazonsync_Block_Adminhtml_Runsync extends Mage_Adminhtml_Block_System_Config_Form_Field
{


    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $buttonHtml = $this->_getAddRowButtonHtml($this->__('Run Synchronization'));
        return $buttonHtml;
    }

    protected function _getAddRowButtonHtml($title)
    {
        $buttonBlock = $this->getElement()->getForm()->getParent()->getLayout()->createBlock('adminhtml/widget_button');
        $_websiteCode = $buttonBlock->getRequest()->getParam('website', null);
        $params = array();

        if(!empty($_websiteCode)) {
            $params['website'] = $_websiteCode;
        }

        $url = Mage::helper('adminhtml')->getUrl("*/adminhtml_runsync/index", $params);
        $buttonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setLabel($this->__($title))
            ->setOnClick("window.location.href='".$url."'")
            ->toHtml();

        return $buttonHtml;
    }
}