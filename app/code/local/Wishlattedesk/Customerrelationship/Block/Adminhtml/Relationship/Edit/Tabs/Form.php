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

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Relationship_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {
        // initial form
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('ocm_form', array('legend' => Mage::helper('customerrelationship')->__('Relationship information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('customerrelationship')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
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