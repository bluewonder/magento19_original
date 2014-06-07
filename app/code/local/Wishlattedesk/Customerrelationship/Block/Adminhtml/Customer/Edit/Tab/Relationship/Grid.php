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

class Wishlattedesk_Customerrelationship_Block_Adminhtml_Customer_Edit_Tab_Relationship_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_relationship_grid');
        $this->setDefaultSort('id', 'desc');
        $this->setUseAjax(true);
    }

    /**
     * Generate data for grid
    */
    protected function _prepareCollection()
    {
        $customerCollection = Mage::getModel('customer/customer')->getCollection();
        $customerCollection->addNameToSelect();

        $collection = Mage::getResourceModel('customerrelationship/customer_relation_collection');
        $collection->addFieldToFilter('customer_id', array('eq' => $this->getRequest()->getParam('id')));
        $resource = Mage::getSingleton('core/resource');
        $collection->getSelect()
            ->joinLeft(array('r' => $resource->getTableName('customerrelationship/relationship')), 'main_table.relationship_id = r.id', array('relationship' => 'r.title'))
            ->joinLeft(array('cu' => new Zend_Db_Expr(sprintf('(%s)', $customerCollection->getSelect()))),'main_table.relative = cu.entity_id', array('relative_name' => 'cu.name'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('customerrelationship')->__('Id'),
            'width'     => '50',
            'align'     => 'center',
            'index'     => 'id',
        ));

        $this->addColumn('relative_name', array(
            'header'    => Mage::helper('customerrelationship')->__('Relative'),
            'width'     => '200',
            'index'     => 'relative_name',
            'renderer'=>'customerrelationship/adminhtml_customer_edit_tab_relationship_render_name',
        ));

        $this->addColumn('relationship', array(
            'header'    => Mage::helper('customerrelationship')->__('Relationship'),
            'width'     => '',
            'index'     => 'relationship',
        ));

        $this->addColumn('remark', array(
            'header'    => Mage::helper('customerrelationship')->__('Remark'),
            'width'     => '',
            'index'     => 'remark',
        ));

        $this->addColumn('editing', array(
            'header'    => Mage::helper('customerrelationship')->__('Action'),
            'width'     => '50',
            'index'     => 'remark',
            'align'     => 'center',
            'filter'    => false,
            'sortable'  => false,
            'renderer'=>'customerrelationship/adminhtml_customer_edit_tab_relationship_render_action',
        ));
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/relationship', array('_current' => true));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('customerrelationship');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('customerrelationship')->__('Delete'),
            'url' => $this->getUrl('*/*/massDeleteRelationShip'),
            'confirm' => Mage::helper('customerrelationship')->__('Are you sure?'),
            'complete' => 'customer_relationship_gridJsObject.reload(); jQuery(\'#edit-field\').hide();'

        ));
        return $this;
    }
}