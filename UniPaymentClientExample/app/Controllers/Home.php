<?php

namespace App\Controllers;

use UniPayment\Client\Model\CreateInvoiceRequest;
use UniPayment\Client\Model\QueryInvoiceRequest;
use UniPayment\Client\UniPaymentClient;
use Config\App;

class Home extends BaseController
{
    private $config;
    private $uniPaymentClient;

    public function __construct()
    {
        $this->config = new App();
    }

    public function index()
    {
        $data['apiKey'] = $this->config->uniPaymentApiKey;
        $data['appId'] = $this->config->uniPaymentAppId;
        $data['apiHost'] = $this->config->uniPaymentAppHost;
        return view('create_invoice', $data);
    }

    public function createInvoice()
    {
        $data['apiKey'] = $this->config->uniPaymentApiKey;
        $data['appId'] = $this->config->uniPaymentAppId;
        $data['apiHost'] = $this->config->uniPaymentAppHost;
        return view('create_invoice', $data);
    }

    public function postCreateInvoice()
    {
        $this->uniPaymentClient = new UniPaymentClient();

        $this->uniPaymentClient->getConfig()->setAppId($_POST['appId']);
        $this->uniPaymentClient->getConfig()->setApiKey($_POST['apiKey']);
        $this->uniPaymentClient->getConfig()->setApiHost($_POST['apiHost']);

        $createInvoiceRequest = new  CreateInvoiceRequest();
        $createInvoiceRequest->setPriceAmount($_POST['priceAmount']);
        $createInvoiceRequest->setPriceCurrency($_POST['priceCurrency']);
        $createInvoiceRequest->setPayCurrency($_POST['payCurrency']);
        $createInvoiceRequest->setNotifyUrl($_POST['notifyUrl']);
        $createInvoiceRequest->setRedirectUrl($_POST['redirectUrl']);
        $createInvoiceRequest->setOrderId($_POST['orderId']);
        $createInvoiceRequest->setTitle($_POST['title']);
        $createInvoiceRequest->setDescription($_POST['description']);
        $createInvoiceRequest->setLang($_POST['lang']);
        $createInvoiceRequest->setExtArgs($_POST['extArgs']);
        $createInvoiceRequest->setConfirmSpeed($_POST['confirmSpeed']);

        $response = $this->uniPaymentClient->createInvoice($createInvoiceRequest);
        header('Location: ' . $response->getData()->getInvoiceUrl());
        exit(0);
    }

    public function queryInvoice()
    {
        $data['apiKey'] = $this->config->uniPaymentApiKey;
        $data['appId'] = $this->config->uniPaymentAppId;
        $data['apiHost'] = $this->config->uniPaymentAppHost;
        return view('query_invoice', $data);
    }

    public function postQueryInvoice()
    {
        $this->uniPaymentClient = new UniPaymentClient();

        $this->uniPaymentClient->getConfig()->setAppId($_POST['appId']);
        $this->uniPaymentClient->getConfig()->setApiKey($_POST['apiKey']);
        $this->uniPaymentClient->getConfig()->setApiHost($_POST['apiHost']);

        $queryRequest = new QueryInvoiceRequest();
        $queryRequest->setOrderId($_POST['orderId']);
        $queryRequest->setInvoiceId($_POST['invoiceId']);
        $queryRequest->setPageNo($_POST['pageNo']);
        $queryRequest->setPageSize($_POST['pageSize']);
        $queryRequest->setStart($_POST['start']);
        $queryRequest->setEnd($_POST['end']);
        $queryRequest->setIsAsc($_POST['isAsc']);
        $queryRequest->setStatus($_POST['status']);

        $response = $this->uniPaymentClient->queryInvoices($queryRequest);
        echo $response;
    }

    public function privacy()
    {
        return view('privacy');
    }
}
