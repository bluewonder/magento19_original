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
require_once 'Mage/Adminhtml/controllers/CustomerController.php';


class Wishlattedesk_Customerrelationship_Adminhtml_CustomerController extends Mage_Adminhtml_CustomerController {

    /**
     * Customer relationship grid
     *
     */
    public function relationshipAction()
    {
        $this->_initCustomer();
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Customer relationship grid
     *
     */
    public function customerAction()
    {
        $this->_initCustomer();
        $this->loadLayout();
        $this->renderLayout();
    }

    public function massDeleteRelationShipAction()
    {
        $customerIds = $this->getRequest()->getParam('customerrelationship');
        if (!is_array($customerIds)) {
            $this->_getSession()->addError($this->__('Please select'));
        } else {
            if (!empty($customerIds)) {
                try {
                    foreach ($customerIds as $customerId) {
                        $customer = Mage::getSingleton('customerrelationship/customer_relation')->load($customerId);
                        $collection = Mage::getModel('customerrelationship/customer_relation')->getCollection();
                        $collection->addFieldToFilter('relative', array('eq' => $customer->getCustomerId()));
                        $collection->addFieldToFilter('customer_id', array('eq' => $customer->getRelative()));
                        foreach($collection as $item) {
                            $item->delete();
                        }

                        $customer->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($customerIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
    }

    public function addNewRelationshipAction()
    {
        $customer = $this->getRequest()->getParam('customer');
        $relative = $this->getRequest()->getParam('relatives');
        $relationship = $this->getRequest()->getParam('relationship');
        $remark = $this->getRequest()->getParam('remark');
        $relative = explode(',', $relative);

        $result = Mage::helper('customerrelationship')->addCustomerRelation($customer, $relative, $relationship, $remark);
        if ($result['error'] == false) {
            $this->_getSession()->addSuccess(
                $result['message']
            );
        }
        $this->getResponse()->setBody(json_encode($result));
    }

    public function editCustomerRelationshipAction()
    {
        $params = $this->getRequest()->getParams();
        $result = Mage::helper('customerrelationship')->editCustomerRelation($params);
        if ($result['error'] == false) {
            $this->_getSession()->addSuccess(
                $result['message']
            );
        }
        $this->getResponse()->setBody(json_encode($result));
    }

    public function loadCustomerRelationshipAction()
    {
        $collection = Mage::getModel('customerrelationship/customer_relation')->getCollection();
        $result = array();
        foreach($collection as $item) {
            $result[$item->getId()] = array(
                'id' => $item->getId(),
                'customer_id' => $item->getCustomerId(),
                'remark' => $item->getRemark(),
                'relationship_id' => $item->getRelationshipId(),
                'relative' => $item->getRelative()
            );
        }

        $this->getResponse()->setBody(json_encode($result));
    }
}