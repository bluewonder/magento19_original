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
class Wishlattedesk_Customerrelationship_Block_Adminhtml_Customer_Edit_Tab_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_grid');
        $this->setDefaultSort('id', 'desc');
        $this->setUseAjax(true);
    }

    /**
     * Generate data for grid
     */
    protected function _prepareCollection()
    {
        $customerCollection = Mage::getModel('customer/customer')->getCollection();
        if ($this->getRequest()->getParam('id')) {
            $customerCollection->addFieldToFilter('entity_id', array('neq' => $this->getRequest()->getParam('id')));
        }
        $customerCollection->addNameToSelect();
        $customerCollection->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left');
        $this->setCollection($customerCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('check', array(
            'header' => Mage::helper('customerrelationship')->__('Assign'),
            'index' => 'check',
            'align' => 'center',
            'width' => '50',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'customerrelationship/adminhtml_customer_edit_tab_customer_render_check',
        ));

        $this->addColumn('entity_id', array(
            'header' => Mage::helper('customerrelationship')->__('ID'),
            'width' => '50',
            'index' => 'entity_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('customerrelationship')->__('Name'),
            'index' => 'name',
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('customerrelationship')->__('Email'),
            'index' => 'email',
        ));

        $this->addColumn('Telephone', array(
            'header' => Mage::helper('customer')->__('Telephone'),
            'width' => '100',
            'index' => 'billing_telephone'
        ));
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/customer', array('_current' => true));
    }
}