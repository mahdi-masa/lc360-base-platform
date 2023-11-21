<?php 

namespace App\Zarinpal;

use App\Models\Payment;


class zarinPalVerification 
{


    /**
     * connect to zarinpal to verify transaction  
     *
     * @param  string  $authority  an authority code 
     * @param int $amount cash amount 
     * @return void  just create a new record in payment table 
     */
    public function zarinPalVerify($authority, $amount)
    {
        //zarin pal communication
        $response = zarinpal()
            ->amount($amount)
            ->verification()
            ->authority($authority)
            ->send();

        if (!$response->success()) {
            Payment::where('authority', $authority)->update([
                'status'=>'failed'
            ]);
            return response()->json([
                'message'=>'تراکنش با مشکل مواجه شده است در صورت کسر از حساب مبلغ تا 48 آینده به حساب شما بازمیگردد'
            ], 422);
        }

        return $response;

    }
}