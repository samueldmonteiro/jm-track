<?php

namespace App\Infra\EloquentModel;


use Illuminate\Database\Eloquent\Model;

class CampaignModel extends Model
{
    protected $table = 'campaigns';
    protected $fillable = ['company_id', 'name', 'start_date', 'end_date'];

    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id');
    }

    public function trafficExpenses()
    {
        return $this->hasMany(TrafficExpenseModel::class, 'campaign_id', 'id');
    }

    public function trafficReturns()
    {
        return $this->hasMany(TrafficReturnModel::class, 'campaign_id', 'id');
    }

    public function campaignMetrics()
    {
        return $this->hasMany(CampaignMetricModel::class, 'campaign_id', 'id');
    }
    protected $casts = [
        'start_date' => 'immutable_datetime',
        'end_date' => 'immutable_datetime',
    ];
}
