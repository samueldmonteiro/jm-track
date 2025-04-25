<?php

namespace App\Infra\EloquentModel;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CampaignModel extends Model
{
    protected $table = 'campaigns';
    protected $fillable = ['company_id', 'name', 'start_date', 'end_date'];

    public function company()
    {
        return $this->belongsTo(CompanyModel::class);
    }

    protected $casts = [
        'start_date' => 'immutable_datetime',
        'end_date' => 'immutable_datetime',
    ];
}
