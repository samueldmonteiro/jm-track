<?php

namespace App\Infra\EloquentModel;

use Illuminate\Database\Eloquent\Model;

class TrafficSourceModel extends Model
{
    protected $table = 'traffic_sources';
    protected $fillable = ['name', 'image'];
}
