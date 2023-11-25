<?php

namespace App\Models;

use App\Traits\HasOTPVerification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use SaliBhdr\TyphoonIranCities\Models\IranCity;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasOTPVerification;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'ssn',
        'city_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'ssn',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // protected function phone(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => Crypt::decrypt($value),
    //         set: fn(string $value) => Crypt::encrypt($value),
    //     );
    // }

    public function isRegistered(): bool
    {
        return $this->firstname && $this->lastname && $this->phone;
    }

    public function squad(): BelongsToMany
    {
        return $this->belongsToMany(Squad::class, 'squad_members', 'member_id', 'squad_id')->withPivot('role')->withTimestamps();
    }

    public function city()
    {
        return $this->belongsTo(IranCity::class, 'city_id');
    }

    /**
     * return user id 
     * @param string $name the name of user
     * @param string $phone the phone of user
     */
    public function returnUserID(string $fname, string $lname, string $phone)
    {   
        $result = User::where('firstname',$fname)->where('lastname',$lname)->first();
        return $result->id;
    }

    /**
     * create a new user if it doesn't exists
     * @param string $name the name of user
     * @param string $owner the owner of user 
     * @param int $phone the phone of user
     */
    public function checkToCreate(string $fname, string $lname, int $phone)
    {
        $result = User::where('firstname', $fname)->where('phone', $phone)->where('lastname', $lname)->exists();
        if(!$result)
        {
            User::create([
                'firstname'=>$fname,
                'lastname'=>$lname,
                'phone'=>$phone
            ]);
        }
    }
}
