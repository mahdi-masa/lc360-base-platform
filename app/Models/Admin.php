<?php

namespace App\Models;

use App\Traits\HasOTPVerification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    use HasOTPVerification;
}
