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

class Wishlattedesk_Customerrelationship_Model_Resource_Relationship extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('customerrelationship/relationship', 'id');
    }
}