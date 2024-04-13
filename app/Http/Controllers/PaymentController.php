<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentOption;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;
use App\Services\PaymentOptions\Payoneer;
use App\Services\PaymentOptions\Wire;

class PaymentController extends Controller
{

    public function __construct(protected PaymentOption $paymentOption)
    {
    }

    public function show(Request $request)
    {
        $type = $request->payment_type;
        $fields = $this->paymentOption->getFields();
        $data = $this->paymentOption->getValues(auth()->id());
        return view('payment_details', compact('fields', 'data', 'type'));
    }


    public function store(PaymentStoreRequest $request)
    {
        try {
            $this->paymentOption->store(auth()->id(), $request->all());
            return redirect()->route('payment.show', $request->payment_type)->with('success', 'Payment details saved successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
