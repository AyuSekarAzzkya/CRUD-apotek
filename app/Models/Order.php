<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_customor',
        'total_price'
    ];

    protected $casts = [
        'medicines' => 'array',
    ];

    public function user()
    {
        //menghubungkan ke primary key nya 
        //dalam kurung merupakan nama model tempat penyimpanan dari PK nya si FK yang ada di model ini
        return $this->belongsTo(User::class);
    }
     public function order()
    {
        // mebuat rekasi ke table lain dengan tipe one to many
        //dalam kurung merupakan nama model yg akan disambungkan (tempat FK)
        return $this->hasMany(Order::class);
    }
}
