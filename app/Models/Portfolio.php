<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $collection = 'portfolio';
    protected $fillable = [
        'name', 'description', 'category', 'image', 'date','url'
    ];
    protected $casts = ['date' => 'datetime'];
}
