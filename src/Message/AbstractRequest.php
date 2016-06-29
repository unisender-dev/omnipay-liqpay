<?php
namespace Omnipay\LiqPay\Message;

use Guzzle\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use LiqPay;

/**
 * LiqPay Abstract Request
 * This is the parent class for all LiqPay requests
 *
 * @link https://www.liqpay.com/en/doc/checkout
 * @link https://github.com/liqpay/sdk-php
 * @see Omnipay\LiqPay\LiqPayGateway
 */
abstract class AbstractRequest
    extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var LiqPay
     */
    protected $liqPay;

    /**
     * @param ClientInterface $httpClient
     * @param HttpRequest $httpRequest
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);

        $this->liqPay = new LiqPay($this->getPublicKey(), $this->getPrivateKey());
    }

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
}