<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Squad extends Model
{
    use HasFactory;
    const ROLE_OWNER = 'owner';
    const ROLE_MEMBER = 'member';

    protected $fillable = [
        'name',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'squad_members', 'squad_id', 'member_id')
            ->withPivot('role');
    }

    public function owner() : BelongsToMany
    {
        return $this->members()->wherePivot('role', self::ROLE_OWNER);
    }

    /**
     * return squad id 
     * @param string $name the name of squad
     * @param string $phone the phone of squad
     */
    public function returnSquadID(string $name, string $phone)
    {   
        $result = Squad::where('name',$name)->where('phone',$phone)->first();
        return $result->id;
    }


    /**
     * create a new squad if it doesn't exists
     * @param string $name the name of squad
     * @param string $owner the owner of squad 
     * @param int $phone the phone of squad
     */
    public function checkToCreate(string $name, string $owner, int $phone)
    {
        $result = Squad::where('name', $name)->where('phone', $phone)->exists();
        if(!$result)
        {
            Squad::create([
                'name'=>$name,
                'phone'=>$phone,
                'owner'=>$owner
            ]);
        }
    }
}