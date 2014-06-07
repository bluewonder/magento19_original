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

class Wishlattedesk_Customerlistreport_Block_Adminhtml_Report_Customer_Render_Firstrlt extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    static  $i = 0;
    public function render(Varien_Object $row)
    {
        $relationshipData = Mage::registry('relationship_data');
        $html = '';
        if (!empty($relationshipData[$row->getId()]) && !empty($relationshipData[$row->getId()][0])) {
            $html = '<span>'.$relationshipData[$row->getId()][0]['rlv'].'</span>';
        }
        self::$i++;
        return $html;
    }
}