<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameOTP extends Model
{
    use HasFactory;
    
    protected $fillable = ['date', 'date_valid_to', 'otp'];
}
