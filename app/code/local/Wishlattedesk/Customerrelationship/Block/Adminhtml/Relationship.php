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
class Wishlattedesk_Customerrelationship_Block_Adminhtml_Relationship extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_relationship';
        $this->_blockGroup = 'customerrelationship';
        $this->_headerText = Mage::helper('customerrelationship')->__('Relationship Manager');
        $this->_updateButton('add', 'label', Mage::helper('customerrelationship')->__('Add Relationship'));
    }
}