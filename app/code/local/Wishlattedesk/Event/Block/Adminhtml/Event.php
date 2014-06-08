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

class Wishlattedesk_Event_Block_Adminhtml_Event extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_event';
        $this->_blockGroup = 'event';
        $this->_headerText = Mage::helper('event')->__('Event Manager');

//        if ($this->_isAllowedAction('new')) {
//            $this->_updateButton('add', 'label', Mage::helper('event')->__('Add Event'));
//        } else {
//            $this->_removeButton('add');
//        }
    }
}