<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    public $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public $timestamps = false;
}
