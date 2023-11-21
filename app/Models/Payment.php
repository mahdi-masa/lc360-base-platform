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
     * update a paymetn record
     *
     * @param  object  $response  zaripal object
     * @param string $authority unique code for payment  
     * @return void  just upadate a new record in payment table 
     */
    public function updatePayment($response, string $authority)
    {
        // insertion and update in database
        Payment::where('authority', $authority)
            ->update([
                'ref_id' =>$response->referenceId(),
                'status' => 'success',
                'card_hash'=>$response->cardHash(),
            ]);
    }


    /**
     * create a paymetn record
     *
     * @param  int  $amount  amount of cash that user wants to pay
     * @param string $description description about payment  
     * @return void  just create a new record in payment table 
     */
    public function paymentCreation($amount, ?string $description, $response, string $payable_type)
    {
        //save info in database 
        Payment::create([
            'amount'=>$amount,
            'description'=>$description,
            'status'=> 'pending',
            'authority'=> $response->authority(),
            'payable_type'=>$payable_type,
            
        ]);
    }
}


