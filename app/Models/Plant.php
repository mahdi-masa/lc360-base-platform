<?php

namespace App\Models;

use App\Enum\PlantStageEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'stage' => PlantStageEnum::class
    ];
    
    protected $fillable = [
        'stage',
        'area',
        'latitude',
        'longitude',
        'type',
        'count',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}
