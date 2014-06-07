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

class Wishlattedesk_Customerlistreport_Block_Adminhtml_Report_Filter_Render_Check extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $html ='<input type="checkbox" data-product-id="'.$row->getId().'" name="product['.$row->getId().']"  value="'.$row->getId().'" class="massaction-checkbox">';
        return $html;
    }
}