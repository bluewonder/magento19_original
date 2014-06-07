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

class Wishlattedesk_Customerrelationship_Model_Observer
{
    /**
     * Make a connection between 2 relationship, for example: if wife relate with husband then husband will relate with wife.
    */
    public function customerrelationshipRelationshipSaveAfter($observer)
    {
        static $run = false;
        if (!$run) {
            $run = true;
            $relationship = $observer->getRelationship();
            if ($relateRelation = $relationship->getRelateRelation()) {
                $relateRelation = Mage::getModel('customerrelationship/relationship')->load($relateRelation);
                if ($relateRelation->getId()) {
                    $relateRelation->setRelateRelation($relationship->getId());
                    $relateRelation->save();
                }
            }
            $this->_reasf();
        }

    }

    /**
     * Switch relate relation will remove connect with old relation
    */
    protected function _reasf()
    {
        $relationshipCollection = Mage::getModel('customerrelationship/relationship')->getCollection();
        $relationshipCollection->addFieldToFilter('relate_relation', array('gt' => 0));
        foreach($relationshipCollection as $relationship) {
            $relate = Mage::getModel('customerrelationship/relationship')->load($relationship->getRelateRelation());
            if ($relate->getRelateRelation() != $relationship->getId()) {
                $relationship->setRelateRelation(null);
                $relationship->save();
            }
        }
    }
}