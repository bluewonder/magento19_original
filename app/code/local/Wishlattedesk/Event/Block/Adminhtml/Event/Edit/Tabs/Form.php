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

class Wishlattedesk_Event_Block_Adminhtml_Event_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // initial form
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('ocm_form', array('legend' => Mage::helper('event')->__('Event information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('event')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));

        if (Mage::getSingleton('adminhtml/session')->getEventData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getEventData());
            Mage::getSingleton('adminhtml/session')->setEventData(null);
        } elseif (Mage::registry('event_data')) {
            $form->setValues(Mage::registry('event_data')->getData());
        }
    }
}