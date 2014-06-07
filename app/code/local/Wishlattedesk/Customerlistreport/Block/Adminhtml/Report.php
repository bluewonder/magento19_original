<?php
/**
 * Wishlattedesk_Customerlistreport
 *
 * @category    Wishlattedesk
 * @package     Wishlattedesk_Customerlistreport
 * @copyright   Copyright (c) 2014 Wishlattedesk Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Hieu Nguyen (Wishlattedesk's team)
 * @email       bzaikia@gmail.com
 */

class Wishlattedesk_Customerlistreport_Block_Adminhtml_Report extends Mage_Adminhtml_Block_Template
{
    /**
     * Return customer group collection
     *
     * @return Mage_Customer_Model_Resource_Group_Collection
    */
    public function getCustomerGroup()
    {
        $collection = Mage::getModel('customer/group')->getCollection();
        $collection->addFieldToFilter('customer_group_id', array('neq' => 0));
        return $collection;
    }

    public function getShowReportBt()
    {
        return $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('backup')->__('Show Report'),
                'onclick' => "showReport()",
                'class'  => 'task'
            ))->toHtml();
    }
}