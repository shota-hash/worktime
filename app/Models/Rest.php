<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    public $primaryKey = 'id';

    protected $fillable = [
        'work_id',
        'rest_start',
        'rest_end',
        'rest_time',
    ];
    //public $timestamps = false;
    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
