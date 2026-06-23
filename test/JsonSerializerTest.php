<?php

namespace UniPayment\SDK;

require_once(__DIR__ . '/../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use UniPayment\SDK\Model\BankAccount;
use UniPayment\SDK\Model\GetWalletAccountsResponse;
use UniPayment\SDK\Utils\JsonSerializer;

class JsonSerializerTest extends TestCase
{
    public function testBankAccountUsesSerializedNames(): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = JsonSerializer::fromJSON(
            '{"bank_name":"Example Bank","bank_account":"123456","bank_bic":"EXAMPLEBIC"}',
            BankAccount::class
        );

        $this->assertSame('Example Bank', $bankAccount->getBankName());
        $this->assertSame('123456', $bankAccount->getBankAccount());
        $this->assertSame('EXAMPLEBIC', $bankAccount->getBankBic());
    }

    public function testEmptyBankAccountKeepsNullableDefaults(): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = JsonSerializer::fromJSON('{}', BankAccount::class);

        $this->assertNull($bankAccount->getBankName());
        $this->assertNull($bankAccount->getBankAccount());
        $this->assertNull($bankAccount->getBankBic());
    }

    public function testWalletAccountCanContainEmptyBankAccount(): void
    {
        /** @var GetWalletAccountsResponse $response */
        $response = JsonSerializer::fromJSON(
            '{"code":"OK","msg":"","data":[{"bank_account":{}}]}',
            GetWalletAccountsResponse::class
        );

        $walletAccount = $response->getData()[0];

        $this->assertNotNull($walletAccount->getBankAccount());
        $this->assertNull($walletAccount->getBankAccount()->getBankName());
    }

    public function testApiClientExtractsErrorMessageFromCommonResponseShapes(): void
    {
        $configuration = new Configuration();
        $apiClient = new ApiClient($configuration);

        $method = (new ReflectionClass(ApiClient::class))->getMethod('extractErrorMessage');
        $method->setAccessible(true);

        $this->assertSame('Message value', $method->invoke($apiClient, '{"msg":"Message value"}', ['msg' => 'Message value'], 'Fallback'));
        $this->assertSame('Error value', $method->invoke($apiClient, '{"error":"Error value"}', ['error' => 'Error value'], 'Fallback'));
        $this->assertSame('invalid_client', $method->invoke($apiClient, 'invalid_client', null, 'Fallback'));

    }
}

