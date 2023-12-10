<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Payment;
use GuzzleHttp\Client;

class PhonePePaymentGateWay implements PaymentGatewayInterface
{
    public function pay($data)
    {
        $client = new Client();

        $paymentData = array(
            "merchantId" => env('MERCHANT_ID'),
            "merchantTransactionId" => $data['transactionId'],
            "merchantUserId" => $data['merchantUserId'],
            "merchantOrderId"=> 'test',
            "amount" => $data['amount'],
            "redirectUrl" => route('payment.response'),
            "redirectMode" => "POST",
            "callbackUrl" => route('payment.callback'),
            "mobileNumber" => $data['mobile'],
            "message"=>'description',
            "email"=> $data['email'],
            "shortName"=> 'name',
            "paymentInstrument" => array( "type" => "PAY_PAGE")
        );

        $saltKey = env('SALT_KEY');
        $saltIndex = env('SALT_INDEX');
        $encodeData = base64_encode(json_encode($paymentData));
        $string = $encodeData.'pg/v1/pay'.$saltKey;
        $hashcode = hash('sha256', $string);
        $xHeaders = $hashcode.'###'.$saltIndex;
        $xHeaders = hash('sha256', $encodeData."/pg/v1/pay".$saltKey).'###'.$saltIndex;

        $url = env('PHONE_PE_URL');
        $response = $client->request('POST', $url, [
            'headers' => [
              'Content-Type' => 'application/json',
              'accept' => 'application/json',
              'X-VERIFY' => $xHeaders
            ],
            'body' => json_encode(['request' => $encodeData])
        ]);
        $response = json_decode($response->getBody()->getContents());
        return $response;
    }

    public function store($data) {
        $payment = new Payment();
        $payment->batch_id = $data['batch'];
        $payment->user_id = $data['user_id'];
        $payment->transaction_id = $data['transaction_id'];
        $payment->status = $data['status'];
        $payment->amount = $data['amount'];
        $payment->phone_status = $data['phone_status'];
        $payment->phone_response = $data['phone_response'];
        $payment->save();

        return $payment;
    }

    public function getStatus($transactionId) {
        $saltKey = env('SALT_KEY');
        $saltIndex = env('SALT_INDEX');
        $merchantID = env('MERCHANT_ID');
        $xHeaders = hash('sha256','/pg/v1/status/'.$merchantID.'/'.$transactionId.$saltKey).'###'.$saltIndex;

        $url = env('PHONE_PE_GET_STATUS_URL');
        $client = new Client();
        $response = $client->request('get', $url.'/'.$merchantID.'/'.$transactionId, [
            'headers' => [
              'Content-Type' => 'application/json',
              'accept' => 'application/json',
              'X-VERIFY' => $xHeaders,
              'X-MERCHANT-ID' => $merchantID,
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }

    public function refund($transactionId, $amount)
    {
        
    }
}