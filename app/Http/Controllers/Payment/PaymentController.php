<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\models\Payment;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Zarinpal\zarinPalVerification;

class PaymentController extends Controller
{


    public function paymentVerification(Payment $payment, zarinPalVerification $verify){

        // get information from url
        $authority = request()->query('Authority');
        

        //get info from database
        $transactionData = Payment::where('authority', $authority)->first();
        $amount = $transactionData->amount;
        $paymentId = $transactionData->id;

        // zarinpal verification
        $info = $verify->zarinPalVerify($authority, $amount, new Payment());

        // update payment record in table
        $payment->updatePayment($info, $authority);
        
        
        
    }
}
