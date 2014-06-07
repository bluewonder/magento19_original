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

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Customer_Edit_Tab_Relationship extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('customerrelationship/customer/tab/relationship.phtml');
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Relationship');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Relationship');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        if (Mage::app()->getRequest()->getParam('id')) return true;
        return false;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    protected function _prepareLayout()
    {
        $this->setChild('relationship_grid',
            $this->getLayout()->createBlock('customerrelationship/adminhtml_customer_edit_tab_relationship_grid','relationship.grid')
        );

        $this->setChild('customer_grid',
            $this->getLayout()->createBlock('customerrelationship/adminhtml_customer_edit_tab_customer_grid','customer.grid')
        );
        return parent::_prepareLayout();
    }

    public function getAddRelationButton()
    {
        return $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label' => Mage::helper('customerrelationship')->__('Add Relation'),
                    'onclick' => "addItem()",
                    'class'  => 'task'
                ))->toHtml();
    }

    /**
     * Get all customer relationship information
     * @return Wishlattedesk_Customerrelationship_Model_Resource_Customer_Relation_Collection
    */
    public function getAllCustomerRelation()
    {
        return Mage::getModel('customerrelationship/customer_relation')->getCollection();
    }

    public function getAllRelationship()
    {
        return Mage::getModel('customerrelationship/relationship')->getCollection();
    }

    /**
     * This show up a button, toggle the block adding relation
    */
    public function toggleBlockAddRelation()
    {
        return $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('customerrelationship')->__('New Relation'),
                'onclick' => '(function(){$(\'add-new-relation\').toggle()})()',
                'class'  => 'task'
            ))->toHtml();
    }
}
