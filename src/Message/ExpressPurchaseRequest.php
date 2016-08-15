<?php
namespace Omnipay\LiqPay\Message;

/**
 * LiqPay Purchase Request
 *
 * This request does not send any data to liq pay servers. It's just helper to get data
 * for checkout form https://www.liqpay.com/en/doc/checkout
 *
 * __________________________________________________________________________________________
 *
 * Examples
 * __________________________________________________________________________________________
 *
 * Set Up and Initialise Gateway
 * __________________________________________________________________________________________
 *
 * <code>
 *     // Create a gateway for the LiqPay
 *     $gateway = Omnipay::create('LiqPay_Express');
 *
 *     // Initialise the gateway
 *     $gateway->initialize(array(
 *         'publicKey'  => 'YOUR_PUBLIC_KEY',
 *         'privateKey' => 'YOUR_PRIVATE_KEY'
 *     ));
 * </code>
 * __________________________________________________________________________________________
 *
 * Payments
 * __________________________________________________________________________________________
 *
 * <code>
 *     // Create purchase request to get POST data
 *     $transaction = $gateway->purchase(array(
 *         'amount'        => '10.00',
 *         'currency'      => 'USD', // USD | EUR | RUB | UAH'
 *         'description'   => 'Payment description',
 *         'transactionId' => '123456',
 *         'lang'          => 'ru', // ru | en
 *         'returnUrl'     => '[URL to redirect on success action]',
 *         'notifyUrl'     => '[URL for notifications of payment status change]'
 *
 *     $response = $transaction->send();
 *
 *     $data      = $response->getEncodedData();
 *     $signature = $response->getSignature();
 *     $url       = $response->getCheckoutUrl();
 * </code>
 * __________________________________________________________________________________________
 *
 * Test Payments
 * __________________________________________________________________________________________
 *
 * Test payments can be performed by setting a testMode parameter
 * to any value that PHP evaluates as true
 * __________________________________________________________________________________________
 */
class ExpressPurchaseRequest
    extends AbstractRequest
{
    /**
     * @return string
     */
    public function getLang()
    {
        return $this->getParameter('lang');
    }

    /**
     * @param string $value
     *
     * @return ExpressPurchaseRequest
     */
    public function setLang($value)
    {
        return $this->setParameter('lang', $value);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'currency',
            'description',
            'transactionId',
            'lang',
            'returnUrl',
            'notifyUrl'
        );

        $data = [
            'version'     => $this->getVersion(),
            'public_key'  => $this->getPublicKey(),
            'action'      => static::LIQPAY_TRANSACTION_TYPE_PAY,
            'amount'      => $this->getAmount(),
            'currency'    => strtoupper($this->getCurrency()),
            'description' => $this->getDescription(),
            'order_id'    => $this->getTransactionId(),
            'language'    => $this->getLang(),
            'result_url'  => $this->getReturnUrl(),
            'server_url'  => $this->getNotifyUrl(),
            'sandbox'     => (int) $this->getTestMode(),
        ];

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $data = base64_encode(json_encode($data));
        $signature = base64_encode(sha1($this->getPrivateKey() . $data . $this->getPrivateKey(), 1));
        
        return new ExpressPurchaseResponse($this, array(
            'encodedData' => $data,
            'signature' => $signature
        ));
    }
}