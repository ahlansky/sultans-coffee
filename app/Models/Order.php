<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status', 'outlet_id'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item (Kopi yang dibeli)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke Outlet (Toko) - INI YANG SERING HILANG
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}