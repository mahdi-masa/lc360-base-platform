<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'description',
        'status',
        'authority',
        'amount',
        'ref_id',
        'card_hash',
        'payable_id',
        'payable_type',
    ];

    protected $table = 'payments';

    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * set a payment as a failed payment
     *
     * @param  string $authority a payment unique code
     * @return void  just upadate a new record in payment table 
     */
    public function failedPayment(string $authority)
    {
        // insertion and update in database
        Payment::where('authority', $authority)
            ->update([
                'status' => 'failed',
            ]);
    }

    /**
     * update a payment record as successfull payment
     *
     * @param string $authority unique code for payment  
     * @return void  just upadate a new record in payment table 
     */
    public function successPayment(string $authority)
    {
        // insertion and update in database
        Payment::where('authority', $authority)
            ->update([
                'status' => 'success',
            ]);
    }


    /**
     * create a paymetn record
     *
     * @param  int  $amount  amount of cash that user wants to pay
     * @param string $description description about payment  
     * @param resposerequest $response an object of zarinpal reponse
     * @param string $payable_type type of payment 
     * @param int $payable_id payable id 
     * @return void  just create a new record in payment table 
     */
    public function paymentCreation($amount, ?string $description, $response, string $payable_type, int $payable_id)
    {
        //save info in database 
        Payment::create([
            'amount'=>$amount,
            'description'=>$description,
            'status'=> 'pending',
            'authority'=> $response->authority(),
            'payable_type'=>$payable_type,
            'payable_id'=>$payable_id
        ]);
    }
}


