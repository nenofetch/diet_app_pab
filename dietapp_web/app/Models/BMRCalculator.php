<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BMRCalculator extends Model
{
    use HasFactory;

    protected $table = 'b_m_r_calculators';
    protected $guarded = [];
}
