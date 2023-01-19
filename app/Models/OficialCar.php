<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OficialCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate'
    ];

    public $timestamps = false;
}
