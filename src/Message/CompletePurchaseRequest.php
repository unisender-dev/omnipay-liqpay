<?php
namespace Omnipay\LiqPay\Message;

/**
 * LiqPay Complete Purchase Request
 *
 * After changing the status of the payment if parameter notifyUrl was specified
 *
 * This uses the LiqPay library at https://github.com/liqpay/sdk-php
 * and the Callback 3.0 API https://www.liqpay.com/en/doc/callback to communicate to LiqPay.
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
 * Getting status info
 * __________________________________________________________________________________________
 *
 * <code>
 *     // Do a purchase transaction on the gateway
 *     $transaction = $gateway->completePurchase();
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
 */
class CompletePurchaseRequest
    extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data      = $this->httpRequest->request->get('data');
        $signature = $this->httpRequest->request->get('signature');

        $controllingSignature = $this->getLiqPay()->str_to_sign($this->getPrivateKey() . $data . $this->getPrivateKey());

        return array(
            'data'    => json_decode(base64_decode($data), true),
            'isValid' => $signature === $controllingSignature
        );
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $response = new PurchaseResponse($this, $data['data']);
        $response->setIsValid($data['data']);
        $response->setTestMode($this->getTestMode());

        return $response;
    }
}