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

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('customerrelationship/relationship')};
CREATE TABLE {$this->getTable('customerrelationship/relationship')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(99) NOT NULL,
  `enable` int(1) unsigned NOT NULL default 1,
  `relate_relation` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");



$installer->run("
DROP TABLE IF EXISTS {$this->getTable('customerrelationship/customer_relation')};
CREATE TABLE {$this->getTable('customerrelationship/customer_relation')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(99) NOT NULL,
  `relationship_id` int(99) NOT NULL,
  `relative` int(99) NOT NULL,
  `remark` varchar (999) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();