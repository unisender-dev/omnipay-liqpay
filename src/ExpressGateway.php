<?php
namespace Omnipay\LiqPay;

use Omnipay\Common\AbstractGateway;

/**
 * Omnipay is a framework agnostic, multi-gateway payment processing library for PHP 5.3+
 * This package implements LiqPay support for Omnipay.
 *
 * LiqPay its a payment service, which allows you to make instant payments via mobile phone,
 * internet and payment cards Visa, MasterCard worldwide. Instant payments service LiqPay designed by
 * PrivatBank andassured by certificates GoDaddy Secure Web Site, Verified by Visa and MasterCard SecureCode.
 *
 * This uses the LiqPay library at https://github.com/liqpay/sdk-php
 *
 * @link https://github.com/thephpleague/omnipay
 * @link https://www.liqpay.com/en/
 * @link https://www.liqpay.com/en/doc
 */
class ExpressGateway
    extends AbstractGateway
{
    const API_VERSION = 3;

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'LiqPay_Express';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultParameters()
    {
        return array(
            'version'    => static::API_VERSION,
            'publicKey'  => '',
            'privateKey' => '',
            'testMode'   => false
        );
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

    /**
     * @inheritDoc
     */
    public function authorize(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function completeAuthorize(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function capture(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\LiqPay\Message\ExpressPurchaseRequest', $options);
    }

    /**
     * @inheritDoc
     */
    public function completePurchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\LiqPay\Message\CompletePurchaseRequest', $options);
    }

    /**
     * @inheritDoc
     */
    public function refund(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function void(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function createCard(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function updateCard(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }

    /**
     * @inheritDoc
     */
    public function deleteCard(array $options = array())
    {
        throw new \BadMethodCallException('Method "'.__METHOD__.'" not supported by gateway or not implemented yet');
    }
}
