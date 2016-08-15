<?php
namespace Omnipay\LiqPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * LiqPay Purchase and Complete Purchase Response
 *
 * This is the response class for PurchaseRequest and CompletePurchaseRequest
 *
 * @link https://www.liqpay.com/en/doc/pay
 * @link https://www.liqpay.com/en/doc/callback
 * @see Omnipay\LiqPay\Gateway
 * @see Omnipay\LiqPay\Message\PurchaseRequest
 * @see Omnipay\LiqPay\Message\CompletePurchaseRequest
 */
class PurchaseResponse
    extends AbstractResponse
    implements RedirectResponseInterface
{
    // Final payment statuses
    const STATUS_SUCCESS         = 'success';
    const STATUS_FAILURE         = 'failure';
    const STATUS_ERROR           = 'error';
    const STATUS_SUBSCRIBED      = 'subscribed';
    const STATUS_UNSUBSCRIBED    = 'unsubscribed';
    const STATUS_REVERSED        = 'reversed';
    const STATUS_SANDBOX         = 'sandbox';

    // Statuses requires confirmation of payment
    const STATUS_OTP_VERIFY      = 'otp_verify';
    const STATUS_3DS_VERIFY      = '3ds_verify';
    const STATUS_CVV_VERIFY      = 'cvv_verify';
    const STATUS_SENDER_VERIFY   = 'sender_verify';
    const STATUS_RECEIVER_VERIFY = 'receiver_verify';

    // Pending statuses
    const STATUS_WAIT_BITCOIN    = 'wait_bitcoin';
    const STATUS_WAIT_SECURE     = 'wait_secure';
    const STATUS_WAIT_ACCEPT     = 'wait_accept';
    const STATUS_WAIT_LC         = 'wait_lc';
    const STATUS_HOLD_WAIT       = 'hold_wait';
    const STATUS_CASH_WAIT       = 'cash_wait';
    const STATUS_WAIT_QR         = 'wait_qr';
    const STATUS_WAIT_SENDER     = 'wait_sender';
    const STATUS_PROCESSING      = 'processing';

    /**
     * Defined on signature verification
     *
     * @var bool
     */
    protected $isValid;

    /**
     * @var bool
     */
    protected $testMode;

    /**
     * @return mixed
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param bool $isValid
     *
     * @return $this
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        if ($this->isTestMode()) {
            return static::STATUS_SANDBOX === $this->getStatus();
        }

        return static::STATUS_SUCCESS === $this->getStatus();
    }

    /**
     * @inheritDoc
     */
    public function isRedirect()
    {
        return static::STATUS_3DS_VERIFY === $this->getStatus();
    }

    /**
     * Is payment pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return in_array($this->getStatus(), array(
            static::STATUS_WAIT_BITCOIN,
            static::STATUS_WAIT_SECURE,
            static::STATUS_WAIT_ACCEPT,
            static::STATUS_WAIT_LC,
            static::STATUS_HOLD_WAIT,
            static::STATUS_CASH_WAIT,
            static::STATUS_WAIT_QR,
            static::STATUS_WAIT_SENDER,
            static::STATUS_PROCESSING
        ), true);
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        return $this->data['redirect_to'];
    }

    /**
     * @inheritDoc
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @inheritDoc
     */
    public function getRedirectData()
    {
        return array();
    }

    /**
     * @inheritDoc
     */
    public function getTransactionId()
    {
        return $this->data['payment_id'];
    }

    /**
     * Get payment status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->data['status'];
    }
}
