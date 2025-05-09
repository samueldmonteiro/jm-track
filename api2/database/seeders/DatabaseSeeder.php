<?php

namespace Database\Seeders;

use App\Infra\EloquentModel\AdminModel;
use App\Infra\EloquentModel\CompanyModel;
use App\Infra\EloquentModel\TrafficSourceModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        AdminModel::create([
            'username' => 'erick',
            'email' => 'erick@email.com',
            'password'=> Hash::make('111')
        ]);

        CompanyModel::create([
            'name' => 'auto pecas carlos',
            'email' => 'auto@email.com',
            'document'=> '231121212122',
            'phone'=> '12213232',
            'password'=> Hash::make('111')
        ]);

        TrafficSourceModel::create([
            'name' => 'OLX',
            'image' => 'images/traffic_sources/olx.png',
        ]);

        TrafficSourceModel::create([
            'name' => 'Facebook',
            'image' => 'images/traffic_sources/facebook.png',
        ]);

        TrafficSourceModel::create([
            'name' => 'Instagram',
            'image' => 'images/traffic_sources/instagram.png',
        ]);

        TrafficSourceModel::create([
            'name' => 'Instagram',
            'image' => 'images/traffic_sources/instagram.png',
        ]);
    }
}
