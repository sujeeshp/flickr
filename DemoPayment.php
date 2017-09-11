<?php

namespace XLite\Module\Tony\PaymentDemo\Model\Payment\Processor;

class DemoPayment extends \XLite\Model\Payment\Base\WebBased
{
    protected function getFormURL()
    {
        return \XLite::getInstance()->getShopURL() . 'payment.php';
    }

    protected function getFormFields()
    {
        return array(
            'transactionID' => $this->transaction->getPublicTxnId(),
            'returnURL' => $this->getReturnURL('transactionID'),
            );
    }

    public function processReturn(\XLite\Model\Payment\Transaction $transaction)
    {
        parent::processReturn($transaction);

        $result = \XLite\Core\Request::getInstance()->status;

        $status = ('Paid' == $result)
            ? $transaction::STATUS_SUCCESS
            : $transaction::STATUS_FAILED;

        $this->transaction->setStatus($status);
    }
}
