<?php

namespace App\Infra\EloquentModel;

use Illuminate\Database\Eloquent\Model;

class CampaignMetricModel extends Model
{
    protected $table = 'campaign_metrics';
    protected $fillable = ['company_id', 'campaign_id', 'traffic_source_id', 'returning_customers'];

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
}
