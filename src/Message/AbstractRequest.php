<?php
namespace Omnipay\LiqPay\Message;

use LiqPay;

/**
 * LiqPay Abstract Request
 * This is the parent class for all LiqPay requests
 *
 * @link https://www.liqpay.com/en/doc/checkout
 * @link https://github.com/liqpay/sdk-php
 * @see Omnipay\LiqPay\Gateway
 */
abstract class AbstractRequest
    extends \Omnipay\Common\Message\AbstractRequest
{
    const LIQPAY_TRANSACTION_TYPE_PAY = 'pay';
    const LIQPAY_TRANSACTION_TYPE_HOLD = 'hold';
    const LIQPAY_TRANSACTION_TYPE_SUBSCRIBE = 'subscribe';
    const LIQPAY_TRANSACTION_TYPE_PAYDONATE = 'paydonate';

    /**
     * @var LiqPay
     */
    private $liqPay;

    /**
     * Get the gateway API version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->getParameter('version');
    }

    /**
     * Set the gateway API version
     *
     * @param int $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        return $this->setParameter('version', $version);
    }

    /**
     * Get the gateway publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    /**
     * Set the gateway publicKey
     *
     * @param string $publicKey
     *
     * @return $this
     */
    public function setPublicKey($publicKey)
    {
        return $this->setParameter('publicKey', $publicKey);
    }

    /**
     * Get the gateway privateKey
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    /**
     * Set the gateway privateKey
     *
     * @param string $privateKey
     *
     * @return $this
     */
    public function setPrivateKey($privateKey)
    {
        return $this->setParameter('privateKey', $privateKey);
    }

    /**
     * @return LiqPay
     */
    public function getLiqPay()
    {
        if (null === $this->liqPay) {
            return $this->liqPay = new LiqPay($this->getPublicKey(), $this->getPrivateKey());
        } else {
            return $this->liqPay;
        }
    }
}