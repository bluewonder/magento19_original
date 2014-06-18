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


$installer->run("
DROP TABLE IF EXISTS {$this->getTable('event/fields')};
CREATE TABLE IF NOT EXISTS {$this->getTable('event/fields')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  `fieldset_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `result_label` text NOT NULL,
  `result_display` varchar(10) NOT NULL DEFAULT 'on',
  `code` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` varchar(20) NOT NULL,
  `value` text NOT NULL,
  `email_subject` tinyint(1) NOT NULL,
  `css_class` varchar(255) NOT NULL,
  `css_style` varchar(255) NOT NULL,
  `validate_message` text NOT NULL,
  `validate_regex` varchar(255) NOT NULL,
  `validate_length_max` int(11) NOT NULL DEFAULT '0',
  `validate_length_min` int(11) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `hint` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('event/fieldsets')};
CREATE TABLE IF NOT EXISTS {$this->getTable('event/fieldsets')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webform_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `result_display` varchar(10) NOT NULL DEFAULT 'on',
  `position` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");


$installer->endSetup();