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
    const STATUS_OTP_VERIFY       = 'otp_verify';
    const STATUS_3DS_VERIFY       = '3ds_verify';
    const STATUS_CVV_VERIFY       = 'cvv_verify';
    const STATUS_SENDER_VERIFY    = 'sender_verify';
    const STATUS_RECEIVER_VERIFY  = 'receiver_verify';
    const STATUS_PHONE_VERIFY     = 'phone_verify';
    const STATUS_IVR_VERIFY       = 'ivr_verify';
    const STATUS_PIN_VERIFY       = 'pin_verify';
    const STATUS_CAPTCHA_VERIFY   = 'captcha_verify';
    const STATUS_PASSWORD_VERIFY  = 'password_verify';
    const STATUS_SENDERAPP_VERIFY = 'senderapp_verify';

    // Under review statuses
    const STATUS_PROCESSING        = 'processing';
    const STATUS_PREPARED          = 'prepared';
    const STATUS_WAIT_BITCOIN      = 'wait_bitcoin';
    const STATUS_WAIT_SECURE       = 'wait_secure';
    const STATUS_WAIT_ACCEPT       = 'wait_accept';
    const STATUS_WAIT_LC           = 'wait_lc';
    const STATUS_HOLD_WAIT         = 'hold_wait';
    const STATUS_CASH_WAIT         = 'cash_wait';
    const STATUS_WAIT_QR           = 'wait_qr';
    const STATUS_WAIT_SENDER       = 'wait_sender';
    const STATUS_WAIT_CARD         = 'wait_card';
    const STATUS_WAIT_COMPENSATION = 'wait_compensation';
    const STATUS_INVOICE_WAIT      = 'invoice_wait';
    const STATUS_WAIT_RESERVE      = 'wait_reserve';

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
     * @inheritDoc
     */
    public function isCancelled()
    {
        return in_array($this->getStatus(), array(
            static::STATUS_FAILURE,
            static::STATUS_ERROR,
            static::STATUS_REVERSED,
        ), true);
    }

    /**
     * Is payment pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return in_array($this->getStatus(), array(
            static::STATUS_OTP_VERIFY,
            static::STATUS_3DS_VERIFY,
            static::STATUS_CVV_VERIFY,
            static::STATUS_SENDER_VERIFY,
            static::STATUS_RECEIVER_VERIFY,
            static::STATUS_PHONE_VERIFY,
            static::STATUS_IVR_VERIFY,
            static::STATUS_PIN_VERIFY,
            static::STATUS_CAPTCHA_VERIFY,
            static::STATUS_PASSWORD_VERIFY,
            static::STATUS_SENDERAPP_VERIFY,
        ), true);
    }

    /**
     * Get under review status.
     *
     * @return bool
     */
    public function isUnderReview()
    {
        return in_array($this->getStatus(), array(
            static::STATUS_PROCESSING,
            static::STATUS_PREPARED,
            static::STATUS_WAIT_BITCOIN,
            static::STATUS_WAIT_SECURE,
            static::STATUS_WAIT_ACCEPT,
            static::STATUS_WAIT_LC,
            static::STATUS_HOLD_WAIT,
            static::STATUS_CASH_WAIT,
            static::STATUS_WAIT_QR,
            static::STATUS_WAIT_SENDER,
            static::STATUS_WAIT_CARD,
            static::STATUS_WAIT_COMPENSATION,
            static::STATUS_INVOICE_WAIT,
            static::STATUS_WAIT_RESERVE,
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
