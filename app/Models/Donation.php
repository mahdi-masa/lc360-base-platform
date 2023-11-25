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
     * create a donation record and return ID of created record
     *
     * @param  int  $donatable_type The ID of the payment.
     * @param int $donatable_id the id value from users table 
     * @param string $type type of donation
     * @return int   return id of created donate 
     */
    public function createDonation(?string $donatable_Type, ?int $donatable_id, string $type):int 
    {
        // Create the donation record
        $donation = Donation::create([
            'donatable_type' => $donatable_Type,
            'donatable_id' => $donatable_id,
            'type' => $type,
        ]);
        return $donation;
        // Retrieve and return the ID of the created record
        return $donation->id;

    }

   

    
}
