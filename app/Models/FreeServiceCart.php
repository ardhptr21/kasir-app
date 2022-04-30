<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeServiceCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'free_service_id',
    ];

    public $timestamps = false;

    public function free_service()
    {
        return $this->belongsTo(FreeService::class);
    }
}
