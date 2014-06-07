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
class Wishlattedesk_Customerlistreport_Helper_Data extends Mage_Core_Helper_Abstract {
    /**
     * Check the existence of column in specific table
     * @param $tableName string
     * @param $columnName string
     * @return boolean
     */
    public function columnExist($tableName,$columnName) {
        $resource = Mage::getSingleton('core/resource');
        $writeAdapter = $resource->getConnection('core_write');

        Zend_Db_Table::setDefaultAdapter($writeAdapter);
        $table = new Zend_Db_Table($tableName);
        if (!in_array($columnName,$table->info('cols'))) {
            return false;
        } return true;
    }
}