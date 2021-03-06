<?php
/**
 * UniPaymentClientTest
 */

namespace UniPayment\Client;

require_once(__DIR__ . '/../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use UniPayment\Client\Model\CreateInvoiceRequest;
use UniPayment\Client\Model\QueryInvoiceRequest;

/**
 * UniPaymentClientTest Class
 */
class UniPaymentClientTest extends TestCase
{
    private $uniPaymentClient;

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
        $this->uniPaymentClient = new UniPaymentClient();

        $this->uniPaymentClient->getConfig()->setAppId("cee1b9e2-d90c-4b63-9824-d621edb38012");
        $this->uniPaymentClient->getConfig()->setApiKey("9G62Fd7fCQGyznVvatk4SAfGsHDEt819E");
        $this->uniPaymentClient->getConfig()->setApiHost("https://sandbox.unipayment.io");
        $this->uniPaymentClient->getConfig()->setDebug(true);
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
    }

    /**
     * Test case for createInvoice
     */
    public function testCreateInvoice()
    {
        $createInvoiceRequest = new CreateInvoiceRequest();
        $createInvoiceRequest->setPriceAmount("100");
        $createInvoiceRequest->setPriceCurrency("USD");
        $createInvoiceRequest->setPayCurrency("USDT");
        $createInvoiceRequest->setOrderId(uniqid());
        $createInvoiceRequest->setConfirmSpeed("low");
        $createInvoiceRequest->setRedirectUrl("https://google.com");
        $createInvoiceRequest->setNotifyUrl("https://google.com");
        $createInvoiceRequest->setTitle("Test Invoice");
        $createInvoiceRequest->setDescription("Test Desc");
        $createInvoiceRequest->setLang("en-US");
        $response = $this->uniPaymentClient->createInvoice($createInvoiceRequest);
        $this->assertEquals('OK', $response->getCode());
        $this->assertNotNull($response->getData()->getInvoiceUrl());
    }

    /**
     * Test case for queryInvoices
     * @throws ApiException
     */
    public function testQueryInvoices()
    {
        $queryInvoiceRequest = new QueryInvoiceRequest();
        $queryInvoiceRequest->setOrderId("ORDER_123456");

        $response = $this->uniPaymentClient->queryInvoices($queryInvoiceRequest);
        $this->assertEquals('OK', $response->getCode());
    }

    /**
     * Test case for getInvoiceById
     * @throws ApiException
     */
    public function testGetInvoiceById()
    {
        $response = $this->uniPaymentClient->getInvoiceById('9EfHVGLDjQssJv7xnBsDSM');
        $this->assertEquals('OK', $response->getCode());
    }

    /**
     * Test case for getInvoiceById
     * @throws ApiException
     */
    public function testQueryIps()
    {
        $response = $this->uniPaymentClient->queryIps();
        $this->assertEquals('OK', $response->getCode());
    }

    /**
     * Test case for getCurrencies
     * @throws ApiException
     */
    public function testGetCurrencies()
    {
        $response = $this->uniPaymentClient->getCurrencies();
        $this->assertEquals('OK', $response->getCode());
    }

    /**
     * Test case for getExchangeRateByFiatCurrency
     * @throws ApiException
     */
    public function testGetExchangeRateByFiatCurrency()
    {
        $response = $this->uniPaymentClient->getExchangeRateByFiatCurrency('USD');
        $this->assertEquals('OK', $response->getCode());
    }

    /**
     * Test case for getExchangeRateByCurrencyPair
     * @throws ApiException
     */
    public function testGetExchangeRateByCurrencyPair()
    {
        $response = $this->uniPaymentClient->getExchangeRateByCurrencyPair('USD', 'BTC');
        $this->assertEquals('OK', $response->getCode());
    }
}
