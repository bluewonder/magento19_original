<?php

/**
 * Wishlattedesk_Customerrelationship
 *
 * @category    Wishlattedesk
 * @package     Wishlattedesk_Customerrelationship
 * @copyright   Copyright (c) 2014 Wishlattedesk Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Hieu Nguyen (Wishlattedesk's team)
 * @email       bzaikia@gmail.com
 */
class Wishlattedesk_Customerrelationship_Adminhtml_RelationshipController extends Mage_Adminhtml_Controller_Action
{
    // init action
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customerrelationship/relationship')
            ->_addBreadcrumb(Mage::helper('customerrelationship')->__('Relationship Manager'), Mage::helper('customerrelationship')->__('Relationship Manager'));

        return $this;
    }

    /**
     * Relationship manager page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/relationship');
        $this->renderLayout();
    }

    // new action: foward to edit
    public function newAction()
    {
        $this->_forward('edit');
    }

    // edit action
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('customerrelationship/relationship')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('relationship_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('customer/relationship');

            $this->_addBreadcrumb(Mage::helper('customerrelationship')->__('Relationship Manager'), Mage::helper('customerrelationship')->__('Relationship Manager'));

            $this->_addContent($this->getLayout()->createBlock('customerrelationship/adminhtml_relationship_edit'))
                ->_addLeft($this->getLayout()->createBlock('customerrelationship/adminhtml_relationship_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerrelationship')->__('Relationship does not exist'));
            $this->_redirect('*/*/');
        }
    }

    // save action
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            /**
             * Unset address information if user input address information then choose address type virtual
             */

            $model = Mage::getModel('customerrelationship/relationship');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));
            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customerrelationship')->__('Relationship was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerrelationship')->__('Unable to find relationship to save'));
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $customerRelationshipIds = $this->getRequest()->getParam('customerrelationship');
        if (!is_array($customerRelationshipIds)) {
            $this->_getSession()->addError($this->__('Please select Relationship(s).'));
        } else {
            if (!empty($customerRelationshipIds)) {
                try {
                    foreach ($customerRelationshipIds as $relationId) {
                        $relationship = Mage::getSingleton('customerrelationship/relationship')->load($relationId);
                        $relationship->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($customerRelationshipIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }
}