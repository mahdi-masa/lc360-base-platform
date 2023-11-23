<?php 

namespace App\Zarinpal;

use App\Models\Payment;
use GuzzleHttp\Psr7\Response;
use Pishran\Zarinpal\RequestResponse;


class zarinpalTransaction 
{


    /**
     * connect to zarinpal server to create a new transaction 
     *
     * @param  Payment  $payment  payment object table
     * @param int $amount cash amount 
     * @param string $description a description for payment 
     * @param string $phone phone user who want to pay
     * @param string $callbackURL url that zaripal redirec after proccessing 
     * @return  RequestResponse return a RequestResponse 
     */
    public function zarinpalTransaction(int $amount, string $description, int $phone, string $callbackURL):RequestResponse
    {
        $response = zarinpal()
            ->amount($amount) // مبلغ تراکنش
            ->request()
            ->description($description) // توضیحات تراکنش
            ->callbackUrl($callbackURL) // آدرس برگشت پس از پرداخت
            ->mobile($phone) // شماره موبایل مشتری - اختیاری
            ->send();

        if (!$response->success()) {
            return response()->json([
                'message'=>'تراکنش با مشکل روبه رو شده است'
            ], 422);
        }

        return $response;
    }


    public function zarinpalRedirect(RequestResponse $response)
    {
        return $response->redirect();
    }
}