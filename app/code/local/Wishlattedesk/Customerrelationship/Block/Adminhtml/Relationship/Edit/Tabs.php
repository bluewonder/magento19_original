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

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Relationship_Edit_Tabs extends  Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct() {
        parent::__construct();
        $this->setId('relationship_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('customerrelationship')->__('Relationship'));
    }

    protected function _beforeToHtml() {
        $this->addTab('general_section', array(
            'label' => $this->__('General Information'),
            'title' => $this->__('General Information'),
            'content' => $this->getLayout()->createBlock('customerrelationship/adminhtml_relationship_edit_tabs_form')->toHtml(),
        ));

        $this->addTab('relate_relationship_section', array(
            'label' => $this->__('Relate Relationship'),
            'title' => $this->__('Relate Relationship'),
            'content' => $this->getLayout()->createBlock('customerrelationship/adminhtml_relationship_edit_tabs_relate')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}