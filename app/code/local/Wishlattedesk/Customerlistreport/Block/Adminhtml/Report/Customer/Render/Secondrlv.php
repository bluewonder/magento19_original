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

class Wishlattedesk_Customerlistreport_Block_Adminhtml_Report_Customer_Render_Secondrlv extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $relationshipData = Mage::registry('relationship_data');
        $html = '';
        if (!empty($relationshipData[$row->getId()]) && !empty($relationshipData[$row->getId()][1])) {
            $html = '<span>'.$relationshipData[$row->getId()][1]['rlv'].'</span>';
        }
        return $html;
    }
}