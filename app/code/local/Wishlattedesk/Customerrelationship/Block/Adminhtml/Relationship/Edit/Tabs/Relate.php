<?php
/**
 * Module_Name
 * 
 * @category   Mage
 * @package    Mage_Admin
 * @author     HieuNT
 */

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Relationship_Edit_Tabs_Relate extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {
        // initial form
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('ocm_form', array('legend' => Mage::helper('customerrelationship')->__('Relate relationship')));

        $relationship = Mage::getModel('customerrelationship/relationship')->getCollection();
        $choice = array();
        //blank options
        $choice[] = "";
        foreach($relationship as $relation) {
            $choice[$relation->getId()] = $relation->getTitle();
        }
        $fieldset->addField('relate_relation', 'select', array(
            'label' => Mage::helper('customerrelationship')->__('Relate Relation'),
            'options' => $choice,
            'name' => 'relate_relation',
        ));

        if (Mage::getSingleton('adminhtml/session')->getRelationshipData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getRelationshipData());
            Mage::getSingleton('adminhtml/session')->setRelationshipData(null);
        } elseif (Mage::registry('relationship_data')) {
            $form->setValues(Mage::registry('relationship_data')->getData());
        }

        return parent::_prepareForm();
    }
}