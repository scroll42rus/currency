<?php
/**
 *  Sample Foo Resource
 */
require_once 'Currency/CurrencyApi.php';

class Api_CurrencyController extends Zend_REST_Controller
{
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */
    public function indexAction()
    {
        (new Currency_CurrencyApi)->updateCurrency();
        
        $resultSet = (new Api_Model_CurrencydataMapper())->filterLast();
        $entries = array();

        foreach ($resultSet as $item) {
            $entries[] = $item->toJSON();
        }
        $this->_helper->json($entries);
        $this->_response->ok();
    }

    public function headAction()
    {
    }

    public function getAction()
    {
    }

    /**
     * The post action handles POST requests; it should accept and digest a
     * POSTed resource representation and persist the resource state.
     */
    public function postAction()
    {
        (new Currency_CurrencyApi)->updateCurrency(true);
        
        $resultSet = (new Api_Model_CurrencydataMapper())->filterLast();
        $entries = array();

        foreach ($resultSet as $item) {
            $entries[] = $item->toJSON();
        }
        $this->_helper->json($entries);
        $this->_response->ok();

        // $this->_response->created();
    }

    public function putAction()
    {
    }

    public function deleteAction()
    {
    }
}
