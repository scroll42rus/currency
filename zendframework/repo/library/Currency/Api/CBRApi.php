<?php

class Currency_Api_CBRApi implements Currency_ICurrencyApi {

    private function getCurrencyInfo($data, $mapper)
    {
        $currencyinfo = $mapper->get(array('code = ?' => $data['CharCode']));
        if (is_null($currencyinfo))
        {
            $currencyinfo = new Api_Model_Currencyinfo();
            $currencyinfo->setName($data['Name'])->setCode($data['CharCode']);
            $mapper->save($currencyinfo);

            $currencyinfo = $mapper->get(array('code = ?' => $data['CharCode']));
        }

        return $currencyinfo;
    }

    public function updateCurrency()
    {
        $currencydata_mapper = new Api_Model_CurrencydataMapper();
        $currencyinfo_mapper = new Api_Model_CurrencyinfoMapper();

        $current_time = new DateTime();
        $data = $this->retrieveData();

        if (is_null($data)) {
            return false;
        }

        foreach ($data['Valute'] as $record)
        {
            $currencyinfo = $this->getCurrencyInfo($record, $currencyinfo_mapper);

            $value = floatval(str_replace(',', '.', $record['Value']));

            $currencydata = new Api_Model_Currencydata();
            $currencydata->setInfo($currencyinfo)
                         ->setValue($value / intval($record['Nominal']))
                         ->setCreateDate($current_time);

            $currencydata_mapper->save($currencydata);
        }

        return true;
    }

    protected function retrieveData()
    {
        $response = new Zend_Http_Client('http://www.cbr.ru/scripts/XML_daily.asp');

        try {
            $response = $response->request()->getBody();
        } catch (Exception $e) {
            return null;
        }
        
        return json_decode(json_encode(simplexml_load_string($response)), true);
    }
}