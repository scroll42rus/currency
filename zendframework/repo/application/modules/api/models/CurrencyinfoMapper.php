<?php

class Api_Model_CurrencyinfoMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (is_null($this->_dbTable)) {
            $this->setDbTable('Api_Model_DbTable_Currencyinfo');
        }
        return $this->_dbTable;
    }
 
    public function save(Api_Model_Currencyinfo $currencyinfo)
    {
        $data = array(
            'name'   => $currencyinfo->getName(),
            'code' => $currencyinfo->getCode()
        );
 
        if (is_null($id = $currencyinfo->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Api_Model_Currencyinfo $currencyinfo)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        $currencyinfo->setId($row->id)
                  ->setName($row->name)
                  ->setCode($row->code);
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Api_Model_Currencyinfo();
            $entry->setId($row->id)
                  ->setName($row->name)
                  ->setCode($row->code);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function get($params)
    {
        $result = $this->getDbTable()->fetchRow($params);
        if (is_null($result)) {
            return;
        }

        $currencyinfo = new Api_Model_Currencyinfo();
        $currencyinfo->setId($result->id)
                     ->setName($result->name)
                     ->setCode($result->code);

        return $currencyinfo;
    }

    public function filter($params)
    {
        $resultSet = $this->getDbTable()->fetchAll($params);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Api_Model_Currencyinfo();
            $entry->setId($row->id)
                  ->setName($row->name)
                  ->setCode($row->code);

            $entries[] = $entry;
        }

        return $entries;
    }
}