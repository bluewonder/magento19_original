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
class Wishlattedesk_Event_Block_Adminhtml_Event_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('eventGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('event/event')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('event')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('label', array(
            'header' => Mage::helper('event')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));
    }

    public function getRowUrl($row) {

        return $this->getUrl('*/*/edit', array('id' => $row->getId()));

    }
}