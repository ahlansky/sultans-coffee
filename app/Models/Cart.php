<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'qty',
        'sugar',
        'ice'
    ];

    // Relasi: Cart ini punya siapa? (Menu apa?)
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}