<?php
namespace Omnipay\LiqPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * LiqPay Express Purchase Response
 *
 * This is the response class for ExpressPurchaseRequest
 *
 * @link https://www.liqpay.com/en/doc/checkout
 * @see Omnipay\LiqPay\ExpressGateway
 * @see Omnipay\LiqPay\Message\ExpressPurchaseRequest
 */
class ExpressPurchaseResponse
    extends AbstractResponse
{
    const LIQPAY_CHECKOUT_URL = 'https://www.liqpay.ua/api/3/checkout';

    /**
     * Get encoded data
     *
     * @return string
     */
    public function getEncodedData()
    {
        return $this->data['encodedData'];
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->data['signature'];
    }

    /**
     * Get checkout URL
     * @return string
     */
    public function getCheckoutUrl()
    {
        return static::LIQPAY_CHECKOUT_URL;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return true;
    }
}