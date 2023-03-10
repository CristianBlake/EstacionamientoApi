<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'category_id',
        'entry',
        'exit',
        'amount'
    ];

    public $timestamps = false;

    protected $table = 'parking';

    protected $dates = [
        'entry',
        'exit'
    ];
}
