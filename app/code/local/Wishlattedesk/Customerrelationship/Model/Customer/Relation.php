<?php
/**
 * @category    Wishlattedesk
 * @package     Wishlattedesk_Customerrelationship
 * @copyright   Copyright (c) 2014 Wishlattedesk Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Hieu Nguyen (Wishlattedesk's team)
 * @email       bzaikia@gmail.com
 */

class Wishlattedesk_Customerrelationship_Model_Customer_Relation extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'customerrelationship_customer_relation';

    protected $_eventObject = 'customer_relation';

    protected $_isNew = false;

    public function _construct()
    {
        parent::_construct();
        $this->_init('customerrelationship/customer_relation');
    }

    /**
     * There is only one relationship between 2 customer
    */
    public function loadByCustomerAndRelative($customerId, $relative)
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('customer_id', array('eq' => $customerId))
                   ->addFieldToFilter('relative', array('eq' => $relative));
        $item = $collection->getFirstItem();
        return $item;
    }
}