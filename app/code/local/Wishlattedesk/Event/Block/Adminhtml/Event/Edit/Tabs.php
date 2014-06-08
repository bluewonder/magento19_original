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

//        $this->addTab('address_section', array(
//            'label' => $this->__('Address'),
//            'title' => $this->__('Address'),
//            'content' => $this->getLayout()->createBlock('xwarehouse/adminhtml_warehouse_edit_tabs_address')->toHtml(),
//        ));
//
//        $this->addTab('contact_section', array(
//            'label' => $this->__('Contact Person'),
//            'title' => $this->__('Contact Person'),
//            'content' => $this->getLayout()->createBlock('xwarehouse/adminhtml_warehouse_edit_tabs_contact')->toHtml(),
//        ));

        return parent::_beforeToHtml();
    }
}