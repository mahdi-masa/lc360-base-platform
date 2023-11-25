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
        

        // zarinpal verification
        $info = $verify->zarinPalVerify($authority, $amount, new Payment());
        if(!$info)
        {
            return response()->json([
                'message'=>'تراکنش با مشکل مواجه شده است در صورت کسر از حساب مبلغ تا 48 آینده به حساب شما بازمیگردد'
            ], 422);
        }else{
            return response()->json([
                "message" => "تراکنش با موفقیت انجام شد از حمایت  شما متشکریم"
            ],200);
        }
    
        
    }
}
