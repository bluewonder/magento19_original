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

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Relationship_Edit_Tabs_Relation extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {
        // initial form
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('ocm_form', array('legend' => Mage::helper('customerrelationship')->__('Relation Relationship information')));

        $relationShipCollection = Mage::getModel('customerrelationship/relationship')->getCollection();
        if ($id = $this->getRequest()->getParam('id')) {
            $relationShipCollection->addFieldToFilter('id', array('neq' => $id));
        }

        $choices = array();

        $fieldset->addField('relate_relationship', 'select', array(
            'label' => Mage::helper('customerrelationship')->__('Relation Relationship'),
            'options' => array(
                1 => 'Husband',
            ),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'relate_relationship',
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