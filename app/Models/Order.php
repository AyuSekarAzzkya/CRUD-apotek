<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicine',
        'name_costumer',
        'total_price'
    ];

    protected $cats = [
        'medicine' => 'array',
    ];

    
}
