<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    public function pay($data);
    public function refund($transactionId, $amount);
}