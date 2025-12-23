<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Tambahkan baris ini
    protected $fillable = ['order_id', 'menu_id', 'qty', 'price', 'sugar', 'ice'];

    public function menu() {
        return $this->belongsTo(Menu::class);
    }
}