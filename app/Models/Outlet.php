<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'name',
        'address'
    ];

    // =====================
    // RELATIONSHIPS
    // =====================

    // Satu outlet punya banyak order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
