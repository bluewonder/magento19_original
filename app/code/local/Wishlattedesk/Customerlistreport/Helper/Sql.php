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

class Wishlattedesk_Customerlistreport_Helper_Sql extends Mage_Core_Helper_Abstract
{
    public function getZendDB()
    {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $resource->getConnection('core_write');
        $zendDb = Zend_Db::factory('Pdo_Mysql', $writeAdapter->getConfig());

        return $zendDb;
    }
}