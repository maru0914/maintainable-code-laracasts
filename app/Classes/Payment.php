<?php

namespace App\Classes;

use App\Models\User;
use App\Services\PaymentProcessors\{PaypalProcessor, WireProcessor, PayoneerProcessor, WiseProcessor};

class Payment
{
    public function __construct()
    {
        $this->paymentProcessors = [
            'wire' => new WireProcessor(),
            'paypal' => new PaypalProcessor(),
            'payoneer' => new PayoneerProcessor(),
        ];
    }

    public function schedulePayment($start, $end, $user_id)
    {
        $user = new User($user_id);
        $timeSheets = $user->getTimeSheets($start, $end);
        $total = 0;
        foreach ($timeSheets as $timeSheet) {
            $total += $timeSheet->hours * $user->rate;
        }
        $query = \DB::raw("INSERT INTO
            scheduled_payments (user_id, amount)
            VALUES ({$user_id}, {$total})");
        return \DB::insert($query);
    }

    public function getScheduledPayments($start, $end)
    {
        $query = \DB::raw("SELECT *
        FROM scheduled_payments
        AND date >= '{$start}'
        AND date <= '{$end}'
        ORDER BY date ASC");
        $result = \DB::select($query);
        return $result;
    }

    public function processPayments($startDate, $endDate)
    {
        $payments = $this->getScheduledPayments($startDate, $endDate);
        foreach ($payments as $payment) {
            $this->processPayment($payment);
        }
    }

    public function processPayment($payment)
    {
        $user = new User($payment->user_id);
        $paymentDetails = $user->getPaymentDetails();
        $amount = $payment->amount;
        $paymentType = $user->getPaymentType();

        if(!isset($this->paymentProcessors[$paymentType])) {
            return "Invalid payment type";
        } else {
            return $this->paymentProcessors[$paymentType]->processPayment($paymentDetails, $amount);
        }
    }
}
