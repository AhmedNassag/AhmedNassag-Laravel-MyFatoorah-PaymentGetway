<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FatoorahServices;

class FatoorahController extends Controller
{
    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }



    public function payOrder()
    {
        //this data should be the data come from request from user in front
        $data = [
            'CustomerName'       => 'Ahmed Nabil',
            'NotificationOption' => 'LNK',
            'InvoiceValue'       => 100,
            'CustomerEmail'      => 'ahmednassag@gmail.com',
            'CallBackUrl'        => /*env('FATOORAH_SUCCESS_URL')*/ route('paymentCallBack'),
            'ErrorUrl'           => /*env('FATOORAH_ERROR_URL')*/ route('paymentError'),
            'language'           => 'en',
            'DisplayCurrencyIso' => 'KWD',
        ];

        return $this->fatoorahServices->sendPayment($data);
    }





    public function paymentCallBack(Request $request)
    {
        $data = [];
        $data['key']     = $request->paymentId;
        $data['keyType'] = 'paymentId';
        $paymentData     = $this->fatoorahServices->getPaymentStatus($data);



        // you can here use a returned data to (create in transactions table && update status of invoice in invoices table) in database
    }





    public function paymentError(Request $request)
    {
        return redirect('/')->withErrors(['error' => 'Sorry, Payment was cancelled or failed. Please try again...']);
    }
}
