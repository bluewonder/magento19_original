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

class Wishlattedesk_Event_Model_Event extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('event/event');
    }
}