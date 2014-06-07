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
class Wishlattedesk_Customerrelationship_Block_Adminhtml_Customer_Edit_Tab_Customer_Render_Check extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html = '<input type="checkbox" name="customer[' . $row->getId() . ']"  value="' . $row->getId() . '" class="massaction-checkbox" onclick="updateSelectCustomer()">';
        return $html;
    }
}