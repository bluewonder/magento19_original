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

class Wishlattedesk_Event_Block_Adminhtml_Event_Edit_Tabs_Fields extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_fields_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection(){
        $collection = Mage::getModel('webforms/fields')->setStoreId($this->getRequest()->getParam('store'))->getCollection()->addFilter('webform_id', $this->getRequest()->getParam('id'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('webforms')->__('ID'),
            'width'     => 60,
            'index'     => 'id'
        ));

        $this->addColumn('field_name', array(
            'header'    => Mage::helper('webforms')->__('Name'),
            'index'     => 'name',
        ));

        $fieldsetsOptions  = Mage::registry('event_data')->getFieldsetsOptionsArray();

        $this->addColumn('fieldset_id', array(
            'header'    => Mage::helper('webforms')->__('Field Set'),
            'index'     => 'fieldset_id',
            'type'      => 'options',
            'options'   => $fieldsetsOptions,
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('webforms')->__('Type'),
            'width'     => 150,
            'index'     => 'type',
            'type'      => 'options',
            'options'   => Mage::getModel('webforms/fields')->getFieldTypes(),
        ));

        $this->addColumn('required', array(
            'header'    => Mage::helper('webforms')->__('Required'),
            'width'     => 100,
            'index'     => 'required',
            'type'      => 'options',
            'options'   => array("1"=>$this->__("Yes"),"0"=>$this->__("No")),
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('webforms')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => Mage::getModel('webforms/webforms')->getAvailableStatuses(),
        ));

        $this->addColumn('position', array(
            'header'            => Mage::helper('webforms')->__('Position'),
            'name'              => 'position',
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'width'             => 60,
        ));

        Mage::dispatchEvent('webforms_adminhtml_webforms_tab_fields_prepare_columns',array('grid'=>$this));

        return parent::_prepareColumns();
    }
}