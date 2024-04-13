<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;
use App\Services\PaymentOptions\Payoneer;
use App\Services\PaymentOptions\Wire;

class PaymentController extends Controller
{
    public function show(Request $request)
    {
        $type = 'payoneer';
        $payoneer = app()->make(Payoneer::class);
        $fields = $payoneer->getFields();
        $data = $payoneer->getValues(auth()->id());
        return view('payment_details', compact('fields', 'data', 'type'));
    }


    public function store(PaymentStoreRequest $request)
    {
        try {
            if ($request->payment_type == 'wire') {
                $payment = app()->make(Wire::class);
            } else {
                $payment = app()->make(Payoneer::class);
            }
            $payment->store(auth()->id(), $request->all());
            return redirect()->route('payment.show', $request->payment_type)->with('success', 'Payment details saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
