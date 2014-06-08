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

class Wishlattedesk_Event_Adminhtml_EventController extends Mage_Adminhtml_Controller_Action
{
    // init action
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('customer/event')
            ->_addBreadcrumb(Mage::helper('event')->__('Event Manager'), Mage::helper('event')->__('Event Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->_initAction();
        $this->renderLayout();
    }

    // new action: foward to edit
    public function newAction() {
        $this->_forward('edit');
    }

    // edit action
    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('event/event')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('event_data', $model);

            $this->loadLayout();
            $this->_initAction();

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Event Manager'), Mage::helper('adminhtml')->__('Event Manager'));

            $this->_addContent($this->getLayout()->createBlock('event/adminhtml_event_edit'))
                ->_addLeft($this->getLayout()->createBlock('event/adminhtml_event_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('event')->__('Event does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('event/event');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('event')->__('Event was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('event')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Delete warehouse then delete product item warehouse also
     */
    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('event/event');
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('event')->__('Event was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
}