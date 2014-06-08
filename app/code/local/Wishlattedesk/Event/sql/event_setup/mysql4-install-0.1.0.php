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
DROP TABLE IF EXISTS {$this->getTable('event/event')};
CREATE TABLE {$this->getTable('event/event')} (
  `id` INT(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `date_held` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('event/event_image')};
CREATE TABLE {$this->getTable('event/event_image')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `event_id` INT(11) unsigned  NOT NULL,
  `type` INT(1) NOT NULL,
  `uri` VARCHAR(99) NOT NULL,
  PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('event/participate')};
CREATE TABLE {$this->getTable('event/participate')} (
  `id` INT(11) unsigned NOT NULL auto_increment,
  `event_id` INT(10) NOT NULL,
  `customer_id` INT(10) NOT NULL,
  `status_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");



$installer->endSetup();