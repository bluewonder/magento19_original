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
class Wishlattedesk_Customerrelationship_Model_Relationship extends Mage_Core_Model_Abstract
{
    protected $_eventPrefix = 'customerrelationship_relationship';

    protected $_eventObject = 'relationship';

    protected $_isNew = false;

    public function _construct()
    {
        parent::_construct();
        $this->_init('customerrelationship/relationship');
    }

    /**
     * Save object data
     *
     * @return Mage_Core_Model_Abstract
     */
    public function save()
    {
        /**
         * Direct deleted items to delete method
         */
        if ($this->isDeleted()) {
            return $this->delete();
        }
        if (!$this->_hasModelChanged()) {
            return $this;
        }
        $this->_getResource()->beginTransaction();
        $dataCommited = false;
        try {
            $this->_beforeSave();
            if ($this->_dataSaveAllowed) {
                $this->_getResource()->save($this);
                $this->_afterSave();
            }
            $this->_getResource()->addCommitCallback(array($this, 'afterCommitCallback'))
                ->commit();
            $this->_hasDataChanges = false;
            $dataCommited = true;
        } catch (Exception $e) {
            $this->_getResource()->rollBack();
            $this->_hasDataChanges = true;
            if (!empty($e->getPrevious()->errorInfo) && !empty($e->getPrevious()->errorInfo[1]) && $e->getPrevious()->errorInfo[1] == 1062) {
                throw new Exception(Mage::helper('customerrelationship')->__('This title was used by another relationship, pick other title'));
            } else {
                throw $e;
            }

        }
        if ($dataCommited) {
            $this->_afterSaveCommit();
        }
        return $this;
    }
}