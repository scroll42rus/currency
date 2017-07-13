<?php

class Api_Model_CurrencydataMapper
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
            $this->setDbTable('Api_Model_DbTable_Currencydata');
        }
        return $this->_dbTable;
    }
 
    public function save(Api_Model_Currencydata $currencydata)
    {
        $data = array(
            'info' => $currencydata->getInfo()->getId(),
            'value' => $currencydata->getValue(),
            'create_date' => $currencydata->getCreateDate(),
        );
 
        if (is_null($id = $currencydata->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Application_Model_Currencydata $currencydata)
    {
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();

        $info = (new Api_Model_CurrencyinfoMapper())->get(array('id = ?' => $row->info));
        $currencydata->setId($row->id)
                  ->setInfo($info)
                  ->setValue($row->value)
                  ->setCreateDate(new DateTime($row->create_date));
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $info = (new Api_Model_CurrencyinfoMapper())->get(array('id = ?' => $row->info));
            $entry = new Api_Model_Currencydata();
            $entry->setId($row->id)
                  ->setInfo($info)
                  ->setValue($row->value)
                  ->setCreateDate(new DateTime($row->create_date));
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

        $info = (new Api_Model_CurrencyinfoMapper())->get(array('id = ?' => $result->info));
        $currencydata = new Api_Model_Currencydata();
        $currencydata->setId($result->id)
                  ->setInfo($info)
                  ->setValue($result->value)
                  ->setChange_By($result->change_by)
                  ->setCreateDate(new DateTime($result->create_date));

        return $currencydata;
    }

    public function filter($params)
    {
        $resultSet = $this->getDbTable()->fetchAll($params);
        $entries = array();
        foreach ($resultSet as $row) {
            $info = (new Api_Model_CurrencyinfoMapper())->get(array('id = ?' => $row->info));
            $entry = new Api_Model_Currencydata();
            $entry->setId($row->id)
                  ->setInfo($info)
                  ->setValue($row->value)
                  ->setCreateDate(new DateTime($row->create_date));

            $entries[] = $entry;
        }

        return $entries;
    }

    public function max($column)
    {
        $table = $this->getDbTable();
        $result = $table->fetchAll(
            $table->select()
                  ->from($table, array(new Zend_Db_Expr('max(' . $column . ') as ' . $column)))
        );

        if (count($result) == 0) {
            return null;
        }

        return $result[0][$column];
    }

    public function filterLast()
    {
        return $this->filter(array('create_date = ?' => $this->max('create_date')));
    }
}