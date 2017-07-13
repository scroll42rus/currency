<?php

class Api_Model_Currencydata
{
    protected $_id;
    protected $_info;
    protected $_value;
    protected $_create_date;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid currencydata property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid currencydata property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }

    public function setInfo($info)
    {
        $this->_info = $info;
        return $this;
    }

    public function getInfo()
    {
        return $this->_info;
    }

    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setCreateDate($create_date)
    {
        $this->_create_date = $create_date->format('Y-m-d H:i:s');
        return $this;
    }

    public function getCreateDate()
    {
        return $this->_create_date;
    }

    public function toJSON()
    {
        return array(
            'id' => $this->_id,
            'info' => $this->_info->toJSON(),
            'value' => $this->_value,
            'create_date' => $this->_create_date
        );
    }
}