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

class Wishlattedesk_Event_Block_Adminhtml_Event_Edit_Tabs_Fieldsets extends VladimirPopov_WebForms_Block_Adminhtml_Webforms_Edit_Tab_Fieldsets
{
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

        $this->addColumn('fieldset_name', array(
            'header'    => Mage::helper('webforms')->__('Name'),
            'index'     => 'name'
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

        Mage::dispatchEvent('webforms_adminhtml_webforms_tab_fieldsets_prepare_columns',array('grid'=>$this));

        return parent::_prepareColumns();
    }
}