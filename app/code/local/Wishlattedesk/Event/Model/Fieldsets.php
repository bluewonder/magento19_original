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

class Wishlattedesk_Event_Model_Fieldsets extends VladimirPopov_WebForms_Model_Fieldsets
{
    public function _construct()
    {
        $grandParent = get_parent_class(get_parent_class($this));
        $grandParent::_init('event/fieldsets');
        $this->_init('event/fieldsets');
    }

    public function duplicate(){
        // duplicate fieldset
        $fieldset = Mage::getModel('event/fieldsets')
            ->setData($this->getData())
            ->setId(null)
            ->setName($this->getName().' '.Mage::helper('webforms')->__('(new copy)'))
            ->setIsActive(false)
            ->setCreatedTime(Mage::getSingleton('core/date')->gmtDate())
            ->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
            ->save();

        // duplicate store data
        $stores = Mage::getModel('webforms/store')
            ->getCollection()
            ->addFilter('entity_id',$this->getId())
            ->addFilter('entity_type',$this->getEntityType());

        foreach($stores as $store){
            $duplicate = Mage::getModel('webforms/store')
                ->setData($store->getData())
                ->setId(null)
                ->setEntityId($fieldset->getId())
                ->save();
        }

        // duplicate fields
        $fields = Mage::getModel('webforms/fields')->getCollection()->addFilter('fieldset_id',$this->getId());
        foreach($fields as $field){
            $field->duplicate()
                ->setFieldsetId($fieldset->getId())
                ->save();
        }

        return $fieldset;
    }
}