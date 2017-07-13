<?php

require_once 'Zend/Http/Client.php';
require_once 'Currency/ICurrencyApi.php';
require_once 'Currency/Api/CBRApi.php';

class Currency_CurrencyApi {

    private $api_list = array(
        'Currency_Api_CBRApi'
    );

    public function updateCurrency($force=false)
    {
        if ($force === false) {
            $currencydata_mapper = new Api_Model_CurrencydataMapper();
            $max_time = $currencydata_mapper->max('create_date');
            $current_time = new DateTime();

            $delta = $current_time->getTimestamp() - (new DateTime($max_time))->getTimestamp();

            if (!is_null($max_time) && $delta < 86400) {
                return;
            }
        }

        foreach ($this->api_list as $class) {
            if ((new $class())->updateCurrency()) {
                break;
            }
        }
    }
}