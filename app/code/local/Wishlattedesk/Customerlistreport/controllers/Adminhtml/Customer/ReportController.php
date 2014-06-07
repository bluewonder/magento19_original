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
class Wishlattedesk_Customerlistreport_Adminhtml_Customer_ReportController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Customer report dashboard
    */
    public function indexAction()
    {
        $this->_getSession()->unsetData('customer_report_filter');
        $this->_title($this->__('Customer'))
            ->_title($this->__('Report'));

        $this->loadLayout();
        $this->renderLayout();
    }

    public function productgridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Export customer grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'customers.csv';
        $content    = $this->getLayout()->createBlock('customerlistreport/adminhtml_report_customer')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export customer grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'customers.xml';
        $content    = $this->getLayout()->createBlock('customerlistreport/adminhtml_report_customer')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     *
    */

    public function exportExcelAction()
    {

        $fileName   = 'customerreport.zip';
        $filepath   = Mage::getBaseDir("var") . DS .'customerreport';
        Mage::register('do_exporting', true);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $this->getLayout()->createBlock('customerlistreport/adminhtml_report_customer')
            ->getXlsFile();
        @readfile($filepath . DS .$fileName);
        $this->deleteDir($filepath);
    }

    public function exportPdfAction()
    {
        $fileName   = 'customer.pdf';
        $filepath   = Mage::getBaseDir("var") . DS .'customerreport';
        Mage::register('do_exporting', true);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $this->getLayout()->createBlock('customerlistreport/adminhtml_report_customer')
            ->getPdfFile();
        @readfile($filepath . DS .$fileName);
        $this->deleteDir($filepath);
    }
    public function customergridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function setfilterAction()
    {
        $params = $this->getRequest()->getParams();
        $this->_getSession()->setData('customer_report_filter',$params);
    }

    /**
     * @return Mage_Adminhtml_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    protected function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}