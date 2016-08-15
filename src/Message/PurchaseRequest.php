<?php
namespace Omnipay\LiqPay\Message;

/**
 * LiqPay Purchase Request
 *
 * The result of the query is a transfer of funds from the payer's card to the store account.
 * Query parameters initialization three-stage scheme for the cards enabled for 3D Secure
 * or two-stage scheme for the cards that are not enabled for 3-D Secure.
 * https://www.liqpay.com/en/doc/info
 *
 * This uses the LiqPay library at https://github.com/liqpay/sdk-php
 * and the Pay API https://www.liqpay.com/en/doc/pay to communicate to LiqPay.
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
 *     $gateway = Omnipay::create('LiqPay');
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
 *     // Create a credit card object
 *     $card = new CreditCard(array(
 *         'number'      => 'CARD_NUMBER',
 *         'expiryMonth' => '01',
 *         'expiryYear'  => '2020',
 *         'cvv'         => '123'
 *     ));
 *
 *     // Do a purchase transaction on the gateway
 *     $transaction = $gateway->purchase(array(
 *         'amount'        => '10.00',
 *         'currency'      => 'USD', // USD | EUR | RUB | UAH'
 *         'transactionId' => '123456',
 *         'description'   => 'Payment description',
 *         'clientIp'      => '127.0.0.1',
 *         'notifyUrl'     => '[URL for notifications of payment status change]',
 *         'card'          => $card
 *     ));
 *
 *     $response = $transaction->send();
 *
 *     if ($response->isSuccessful()) {
 *         echo "Purchase transaction was successful!\n";
 *         $orderId = $response->getTransactionId();
 *         echo "Transaction reference = {$orderId}\n";
 *     } else if ($response->isRedirect()) {
 *         $response->redirect();
 *     }
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
class PurchaseRequest
    extends AbstractRequest
{
    const API_METHOD = 'payment/pay';

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validateRequiredParams();
        
        $data = array(
            'purchase'  => array(
                'version'               => $this->getVersion(),
                'phone'                 => $this->getCard()->getPhone(),
                'amount'                => (double) $this->getAmount(),
                'currency'              => $this->getCurrency(),
                'description'           => $this->getDescription(),
                'order_id'              => $this->getTransactionId(),
                'card'                  => $this->getCard()->getNumber(),
                'card_exp_month'        => $this->getCard()->getExpiryMonth(),
                'card_exp_year'         => $this->getCard()->getExpiryYear(),
                'card_cvv'              => $this->getCard()->getCvv(),
                'browser_ip'            => $this->getClientIp()
            )
        );

        if ($this->getNotifyUrl()) {
            $data['purchase']['server_url'] = $this->getNotifyUrl();
        }

        if ($this->getTestMode()) {
            $data['purchase']['sandbox'] = (int) $this->getTestMode();
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $response = $this->getLiqPay()->api(static::API_METHOD, $data);

        $response = new PurchaseResponse($this, json_decode($response, true));
        $response->setIsValid(true);
        $response->setTestMode($this->getTestMode());

        return $response;
    }

    /**
     * Validate request parameters
     */
    protected function validateRequiredParams()
    {
        $this->validate(array('card', 'amount', 'currency', 'description', 'transactionId', 'clientIp'));
        $this->getCard()->validate();
    }
}