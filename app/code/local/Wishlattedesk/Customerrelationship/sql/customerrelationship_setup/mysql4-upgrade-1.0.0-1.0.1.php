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
ALTER TABLE {$this->getTable('customerrelationship/relationship')}
	ADD UNIQUE INDEX `title` (`title`);
");

$installer->endSetup();