<?php
/**
 * Wishlattedesk_Event
 *
 * @category    Wishlattedesk
 * @package     Wishlattedesk_Event
 * @copyright   Copyright (c) 2014 Wishlattedesk Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Hieu Nguyen (Wishlattedesk's team)
 * @email       bzaikia@gmail.com
 */ 
require_once 'VladimirPopov/WebForms/controllers/Adminhtml/FieldsController.php';


class Wishlattedesk_Event_Webforms_Adminhtml_FieldsController extends VladimirPopov_WebForms_Adminhtml_FieldsController {

    public function editAction(){
        die('sdsd');
        if((float)substr(Mage::getVersion(),0,3) > 1.3)
            $this->_title($this->__('Web-forms'))->_title($this->__('Edit Field'));
        $fieldsId = $this->getRequest()->getParam('id');
        $webformsId = $this->getRequest()->getParam('webform_id');

        $store = $this->getRequest()->getParam('store');
        $field = Mage::getModel('webforms/fields')->setStoreId($store)->load($fieldsId);
        if($field->getWebformId()){
            $webformsId = $field->getWebformId();
        }
        $webformsModel = Mage::getModel('webforms/webforms')->setStoreId($store)->load($webformsId);

        if($field->getId() || $fieldsId == 0){
            Mage::register('webforms_data',$webformsModel);
            Mage::register('field',$field);

            $this->loadLayout();
            $this->_setActiveMenu('webforms/webforms');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('WebForms'),Mage::helper('adminhtml')->__('Web-forms'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('webforms/adminhtml_fields_edit'))
                ->_addLeft($this->getLayout()->createBlock('webforms/adminhtml_fields_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('webforms')->__('Field does not exist'));
            $this->_redirect('*/adminhtml_webforms/edit',array('id' => $webformsId));
        }
    }


    public function indexAction(){
        $this->_initAction();
        $this->renderLayout();
    }

    public function saveAction()
    {
        if( $this->getRequest()->getPost()){
            try{
                $id = $this->getRequest()->getParam('id');
                $postData = $this->getRequest()->getPost('field');
                $webform_id = $postData["webform_id"];
                $saveandcontinue = $this->getRequest()->getParam('back');

                unset($postData["saveandcontinue"]);

                $field = Mage::getModel('webforms/fields');

                $field->setId($id);

                $store = Mage::app()->getRequest()->getParam('store');
                if($store){
                    unset($postData["webform_id"]);
                    $field->saveStoreData($store,$postData);
                } else
                    $field->setData($postData)->setId($id)->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())->save();

                if( $this->getRequest()->getParam('id') <= 0 )
                    $field->setCreatedTime(Mage::getSingleton('core/date')->gmtDate())->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Field was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setWebFormsData(false);

                if($saveandcontinue){
                    $this->_redirect('*/adminhtml_fields/edit',array('id' => $field->getId(),'webform_id' => $webform_id,'store'=>$store,'active_tab'=>$this->getRequest()->getParam('active_tab')));
                } else {
                    $this->_redirect('*/adminhtml_webforms/edit',array('id' => $webform_id,'tab' => 'form_fields','store'=>$store));
                }

                return;
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setWebFormsData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit',array('id' => $this->getRequest()->getParam('id'),'store'=>$store));
                return;
            }

        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('webforms')->__('Unexpected error'));
        $this->_redirect('*/adminhtml_webforms/index');
    }
}