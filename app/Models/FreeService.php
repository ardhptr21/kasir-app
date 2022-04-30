<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeService extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'max_point'];

    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function free_service_cart()
    {
        return $this->hasOne(FreeServiceCart::class);
    }
}
