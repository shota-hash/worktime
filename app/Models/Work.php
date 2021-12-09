<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    public $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'work_start',
        'work_end',
        'date',
    ];
    //public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rest()
    {
        return $this->hasMany(Rest::class);
    }
}
