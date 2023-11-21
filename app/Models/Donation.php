<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    protected $fillable = [
        'id',
        'user_id',
        'type',
        'payment_id',
    ];



    public function payment()
    {
        return $this->morphOne(payment::class, 'payable');
    }

    /**
     * create a donation record after user paid
     *
     * @param  int  $paymentId  The ID of the payment.
     * @param int $user_id the id value from users table 
     * @return void  just create a new record in donation table 
     */
    public function createDonation(?string $donatable_Type, ?int $donatable_id, string $type)
    {
        Donation::create([
            'donatable_type'=> $donatable_Type,
            'donatable_id'=> $donatable_id,
            'type'=> $type
            ]);

    }

    
}
