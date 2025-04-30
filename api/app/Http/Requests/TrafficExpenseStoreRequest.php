<?php

namespace App\Http\Requests;

class TrafficExpenseStoreRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campaignId' =>  'required|integer',
            'trafficSourceId' =>  'required|integer',
            'date' =>  'required|date',
            'amount' =>  'required|numeric',
        ];
    }
}
