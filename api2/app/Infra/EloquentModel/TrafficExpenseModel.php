<?php

namespace App\Infra\EloquentModel;

use Illuminate\Database\Eloquent\Model;

class TrafficExpenseModel extends Model
{
    protected $table = 'traffic_expenses';
    protected $fillable = ['company_id', 'traffic_source_id', 'campaign_id', 'date', 'amount'];

    public function trafficSource()
    {
        return $this->belongsTo(TrafficSourceModel::class, 'traffic_source_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo(CampaignModel::class, 'campaign_id', 'id');
    }

    protected $casts = [
        'date' => 'immutable_datetime',
    ];
}
