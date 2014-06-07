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

class Wishlattedesk_Customerlistreport_Block_Adminhtml_Report_Customer extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('customerGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $session = $this->_getSession();
        $filterData = $session->getData('customer_report_filter');
        if (!empty($filterData) && is_array($filterData)) {
            $collection = Mage::getResourceModel('customer/customer_collection')
                ->addNameToSelect()
                ->addAttributeToSelect('email')
                ->addAttributeToSelect('created_at')
                ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left');

            if (!empty($filterData['joinDateFrom'])) {
                $collection->addFieldToFilter('created_at', array('gt' => $filterData['joinDateFrom']));
            }

            if (!empty($filterData['joinDateTo'])) {
                $collection->addFieldToFilter('created_at', array('lt' => $filterData['joinDateTo']));
            }

            if (!empty($filterData['customerGroup'])) {
                $collection->addFieldToFilter('group_id', array('eq' => $filterData['customerGroup']));
            }

            if (!empty($filterData['productIds']) && $filterData['productFilter'] == 1 ) {
                $ids = $filterData['productIds'];
                if (strpos($ids, ',') !== false) {
                    $ids = explode(',', $ids);
                } else {
                    $ids = array($ids);
                }

                $helper = Mage::helper('customerlistreport/sql');
                $resource = Mage::getSingleton('core/resource');
                $zendDb = $helper->getZendDB();
                /** @var $select Zend_Db_Select*/
                $select = $zendDb->select();
                $select->from(
                        array('items' => $resource->getTableName('sales/order_item')), // table name
                        array('item_id', 'order_id', 'product_id') //  selected columns
                    )->where('product_id IN (?) ',$ids);

                $select->joinLeft(array('order' => $resource->getTableName('sales/order')), 'order.entity_id = items.order_id', 'order.customer_id');

                $collection->getSelect()->join(array('o' => new Zend_Db_Expr(sprintf('(%s)', $select))), 'e.entity_id = o.customer_id');
            }

        } else {
            $collection = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('entity_id', array('eq' => 0));
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customerlistreport')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('customerlistreport')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('Telephone', array(
            'header'    => Mage::helper('customerlistreport')->__('Telephone'),
            'width'     => '100',
            'index'     => 'billing_telephone'
        ));

        $this->addColumn('Rlt1_Name', array(
            'header'    => Mage::helper('customerlistreport')->__('Rlt1_Name'),
            'width'     => '100',
            'renderer'  => 'customerlistreport/adminhtml_report_customer_render_firstrlt',
            'filter'    => false,
            'sortable'  => false
        ));

        $this->addColumn('Rlt1_Type', array(
            'header'    => Mage::helper('customerlistreport')->__('Rlt1_Type'),
            'width'     => '100',
            'renderer'  => 'customerlistreport/adminhtml_report_customer_render_firstrls',
            'filter'    => false,
            'sortable'  => false
        ));

        $this->addColumn('Rlt2_Name', array(
            'header'    => Mage::helper('customerlistreport')->__('Rlt2_Name'),
            'width'     => '100',
            'renderer'  => 'customerlistreport/adminhtml_report_customer_render_secondrlv',
            'filter'    => false,
            'sortable'  => false
        ));

        $this->addColumn('Rlt2_Type', array(
            'header'    => Mage::helper('customerlistreport')->__('Rlt2_Type'),
            'width'     => '100',
            'renderer'  => 'customerlistreport/adminhtml_report_customer_render_secondrls',
            'filter'    => false,
            'sortable'  => false
        ));

        $this->addExportType('*/*/exportExcel', Mage::helper('customer')->__('Excel'));
        $this->addExportType('*/*/exportPdf', Mage::helper('customer')->__('Pdf'));
    }

    protected function _prepareGrid() {

        $result = array();

        $relativeCollection = Mage::getModel('customerrelationship/customer_relation')->getCollection();
        foreach( $relativeCollection as $rel) {
            if (empty($result[$rel->getCustomerId()])) {
                $result[$rel->getCustomerId()] = array();
            }
            $relative = Mage::getModel('customer/customer')->load($rel->getRelative());
            $relationship = Mage::getModel('customerrelationship/relationship')->load($rel->getRelationshipId());
            $result[$rel->getCustomerId()][] = array(
                'rlv' => $relative->getName(),
                'relationship' => $relationship->getTitle()
            );
        }


        Mage::register('relationship_data', $result);
        return parent::_prepareGrid();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/customergrid', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function getPdfFile()
    {
        $this->_prepareGrid();
        $itemPerPage = (int) $this->getParam($this->getVarNameLimit(), $this->_defaultLimit);
        $count = 1;

        $i = 2;
        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
        $objPHPExcel = new PHPExcel();

        if (!file_exists(Mage::getBaseDir("var") . DS .'customerreport')) {
            mkdir(Mage::getBaseDir("var") . DS .'customerreport');
        }
        $zip = new ZipArchive();
        $filename = "customerreport.zip";
        $rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
        $rendererLibrary = 'tcpdf';
        PHPExcel_Settings::setPdfRenderer($rendererName, Mage::getBaseDir('lib').DS.$rendererLibrary);
        if ($zip->open(Mage::getBaseDir("var") . DS .'customerreport'.DS .$filename, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filename>\n");
        }
        foreach ($this->getCollection() as $_item) {
            if (($count % $itemPerPage) == 1) {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                    ->setTitle($this->__('Customer Report'));

                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                    ->setSize(10);
                // Column title
                $objPHPExcel->getActiveSheet()->setCellValue('A1', Mage::helper('customerlistreport')->__('ID'))
                    ->setCellValue('B1', Mage::helper('customerlistreport')->__('Name'))
                    ->setCellValue('C1', Mage::helper('customerlistreport')->__('Telephone'))
                    ->setCellValue('D1', Mage::helper('customerlistreport')->__('Relations'));

                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $i = 2; // data will be filled from row 2
            }

            $customer = Mage::getModel('customer/customer');
            $j = 1; // start write data to col 1
            foreach ($this->getColumns() as $_column) {
                if ($_column->getIndex() == 'entity_id') {
                    $customer->load($_column->getRowField($_item));
                }
                if ($this->shouldRenderCell($_item, $_column)) {
                    $_html = $_column->getRowField($_item);
                    if (!empty($arr[$j])) {
                        if ($j == 4) { // col 4
                            // Customer relationship data
                            $relativeCollection = Mage::getModel('customerrelationship/customer_relation')->getCollection();
                            $relativeCollection->addFieldToFilter('customer_id', array('eq' => $customer->getId()));
                            $html = '';
                            foreach($relativeCollection as $relative) {
                                $relativeCustomer = Mage::getModel('customer/customer')->load($relative->getRelative());
                                $relationship = Mage::getModel('customerrelationship/relationship')->load($relative->getRelationshipId());
                                if ($relative->getRemark()) {
                                    $html .= $relativeCustomer->getName() . ' - ' . $relationship->getTitle() . '(' . $relative->getRemark() . ')'."\n";
                                } else {
                                    $html .= $relativeCustomer->getName() . ' - ' . $relationship->getTitle() ."\r\n";
                                }
                            }
                            if (!empty($arr[$j])) {
                                $objPHPExcel->getActiveSheet()->setCellValue($arr[$j].$i, $html);
                            }
                        }else {
                            $objPHPExcel->getActiveSheet()->setCellValue($arr[$j].$i, $_html);
                        }
                    }
                    $j++;
                }
            }
            if (($count % $itemPerPage) == 0 || $count == $this->getCollection()->getSize()) {
//                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
                $objWriter->setSheetIndex(0);
//                $objWriter->save(str_replace('.php', '_'.$rendererName.'.pdf', __FILE__));

                $dir = Mage::getBaseDir("var") . DS .'customerreport' . DS . $count.'.pdf';
                $objWriter->save($dir);
                $zip->addFile($dir, $count.'.pdf');
            }
            $i++;
            $count++;
        }
        return $zip;
    }

    public function getXlsFile()
    {
        $this->_prepareGrid();
        $itemPerPage = (int) $this->getParam($this->getVarNameLimit(), $this->_defaultLimit);
        $count = 1;

        $i = 2;
        $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D');
        $objPHPExcel = new PHPExcel();

        if (!file_exists(Mage::getBaseDir("var") . DS .'customerreport')) {
            mkdir(Mage::getBaseDir("var") . DS .'customerreport');
        }
        $zip = new ZipArchive();
        $filename = "customerreport.zip";
        if ($zip->open(Mage::getBaseDir("var") . DS .'customerreport'.DS .$filename, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filename>\n");
        }
        foreach ($this->getCollection() as $_item) {
            if (($count % $itemPerPage) == 1) {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                    ->setTitle($this->__('Customer Report'));

                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                    ->setSize(10);
                // Column title
                $objPHPExcel->getActiveSheet()->setCellValue('A1', Mage::helper('customerlistreport')->__('ID'))
                    ->setCellValue('B1', Mage::helper('customerlistreport')->__('Name'))
                    ->setCellValue('C1', Mage::helper('customerlistreport')->__('Telephone'))
                    ->setCellValue('D1', Mage::helper('customerlistreport')->__('Relations'));
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

                $i = 2; // data will be filled from row 2
            }

            $customer = Mage::getModel('customer/customer');
            $j = 1; // start write data to col 1
            foreach ($this->getColumns() as $_column) {
                if ($_column->getIndex() == 'entity_id') {
                    $customer->load($_column->getRowField($_item));
                }
                if ($this->shouldRenderCell($_item, $_column)) {
                    $_html = $_column->getRowField($_item);
                    if (!empty($arr[$j])) {
                        if ($j == 4) { // col 4
                            // Customer relationship data
                            $relativeCollection = Mage::getModel('customerrelationship/customer_relation')->getCollection();
                            $relativeCollection->addFieldToFilter('customer_id', array('eq' => $customer->getId()));
                            $html = '';
                            foreach($relativeCollection as $relative) {
                                $relativeCustomer = Mage::getModel('customer/customer')->load($relative->getRelative());
                                $relationship = Mage::getModel('customerrelationship/relationship')->load($relative->getRelationshipId());
                                if ($relative->getRemark()) {
                                    $html .= $relativeCustomer->getName() . ' - ' . $relationship->getTitle() . '(' . $relative->getRemark() . ')'."\n";
                                } else {
                                    $html .= $relativeCustomer->getName() . ' - ' . $relationship->getTitle() ."\r\n";
                                }
                            }
                            if (!empty($arr[$j])) {
                                $objPHPExcel->getActiveSheet()->setCellValue($arr[$j].$i, $html);
                            }
                        }else {
                            $objPHPExcel->getActiveSheet()->setCellValue($arr[$j].$i, $_html);
                        }
                    }
                    $j++;
                }
            }
            if (($count % $itemPerPage) == 0 || $count == $this->getCollection()->getSize()) {
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

                $dir = Mage::getBaseDir("var") . DS .'customerreport' . DS . $count.'.xls';
                $objWriter->save($dir);
                $zip->addFile($dir, $count.'.xls');
            }
            $i++;
            $count++;
        }
        return $zip;
    }

    /**
     * @return Mage_Adminhtml_Model_Session
    */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    protected function _preparePage()
    {
        $doExporting = Mage::registry('do_exporting');
        if (is_null($doExporting)) {
            $this->getCollection()->setPageSize((int) $this->getParam($this->getVarNameLimit(), $this->_defaultLimit));
            $this->getCollection()->setCurPage((int) $this->getParam($this->getVarNamePage(), $this->_defaultPage));
        }
    }
}