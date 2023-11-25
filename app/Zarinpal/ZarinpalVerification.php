<?php 

namespace App\Zarinpal;

use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class zarinPalVerification
{


    /**
     * connect to zarinpal to verify transaction  
     *
     * @param  string  $authority  an authority code 
     * @param int $amount cash amount 
     * @return void  just create a new record in payment table 
     */
    public function zarinPalVerify($authority, $amount, Payment $payment)
    {
        //zarin pal communication
        $response = zarinpal()
            ->amount($amount)
            ->verification()
            ->authority($authority)
            ->send();

        if (!$response->success()) {
            $payment->failedPayment($authority);
            return false;
        }else{
            $payment->successPayment($authority,$response->referenceId(), $response->cardPan());
            return true;
        }


    }
}