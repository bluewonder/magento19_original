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
class Wishlattedesk_Customerrelationship_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Add customer relationship
     *
     * @param $customerId int
     * @param $relatives array
     * @param $relations int
     * @return array
    */
    public function addCustomerRelation($customerId, $relatives, $relations, $remark) {
        $relations = Mage::getModel('customerrelationship/relationship')->load($relations);
        if (!$relations->getId()) {
            return array('error' => true, 'message' => $this->__('Relationship is not available'));
        }
        $relateRelation = $relations->getRelateRelation();

        foreach($relatives as $relative) {
            // Adding data to table customer relation for current customer
            $item = Mage::getModel('customerrelationship/customer_relation')->loadByCustomerAndRelative($customerId, $relative);
            if ($item->getId()) {
                $customer = Mage::getModel('customer/customer')->load($customerId);
                $relative = Mage::getModel('customer/customer')->load($relative);
                $relationship = Mage::getModel('customerrelationship/relationship')->load($item->getRelationshipId());
                return array('error' => true, 'message' => $this->__(sprintf('%s and %s has linked by relationship %s', $customer->getName(), $relative->getName(), $relationship->getTitle())));
            } else {
                $item = Mage::getModel('customerrelationship/customer_relation')->load(null);
                $item->setCustomerId($customerId);
                $item->setRelationshipId($relations->getId());
                $item->setRelative($relative);
                if (!empty($remark)) {
                    $item->setRemark($remark);
                }

                $item->save();
            }

            // relation has relate relationship then add that relate relationship too
            if (!empty($relateRelation)) {
                // Adding data to table customer relation for relate customer
                $item = Mage::getModel('customerrelationship/customer_relation')->loadByCustomerAndRelative($relative, $customerId);
                if ($item->getId()) {
                    $item->setRelationshipId($relateRelation);
                    $item->save();
                } else {
                    $item = Mage::getModel('customerrelationship/customer_relation')->load(null);
                    $item->setCustomerId($relative);
                    $item->setRelationshipId($relateRelation);
                    $item->setRelative($customerId);
                    $item->save();
                }
            }
        }

        return array('error' => false, 'message' => $this->__('Adding relations successful'));
    }

    /**
     * @param $params array
     * @return array
    */
    public function editCustomerRelation($params)
    {
        if (!empty($params['id'])) {
            $item = Mage::getModel('customerrelationship/customer_relation')->load($params['id']);
            if (!$item->getId()) {
                return array('error' => true, 'message' => $this->__('Relationship is not available'));
            }
            unset($params['id']);
            $item->setRemark($params['remark']);

            if (!empty($params['relationship']) && $params['relationship'] !=  $item->getRelationshipId()) {
                // Delete the reverse way of this relationship
                $relative = Mage::getModel('customerrelationship/customer_relation')->loadByCustomerAndRelative($item->getRelative(), $item->getCustomerId());
                if ($item->getId()) $relative->delete();

                $relationship = Mage::getModel('customerrelationship/relationship')->load($params['relationship']);
                if ($relationship->getId()) {
                    $relateRelation = $relationship->getRelateRelation();

                    // Check if this is 2 way relationship or not
                    $item->setRelationshipId($relationship->getId());
                    if (!empty($relateRelation)) {
                        $relative = Mage::getModel('customerrelationship/customer_relation')->load(null);
                        $relative->setRelationshipId($relateRelation);
                        $relative->setCustomerId($item->getRelative());
                        $relative->setRelative($item->getCustomerId());
                        $relative->save();
                    }
                }
            }

            $item->save();
            return array('error' => false, 'message' => $this->__('Edit relations successful'));
        }
        return array('error' => true, 'message' => $this->__('Relationship is not available'));
    }
}