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

class Wishlattedesk_Event_Block_Adminhtml_Event_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct() {
        parent::__construct();
        $this->setId('event_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('event')->__('Event'));
    }

    protected function _beforeToHtml() {
        $this->addTab('general_section', array(
            'label' => $this->__('General Information'),
            'title' => $this->__('General Information'),
            'content' => $this->getLayout()->createBlock('event/adminhtml_event_edit_tabs_form')->toHtml(),
        ));

        $this->addTab('form_fieldsets',array(
            'label' => Mage::helper('webforms')->__('Field Sets'),
            'title' => Mage::helper('webforms')->__('Field Sets'),
            'content' => $this->getLayout()->createBlock('event/adminhtml_event_edit_tabs_fieldsets')->toHtml(),
        ));

        $this->addTab('form_fields',array(
            'label' => Mage::helper('webforms')->__('Fields'),
            'title' => Mage::helper('webforms')->__('Fields'),
            'content' => $this->getLayout()->createBlock('event/adminhtml_event_edit_tabs_fields')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}