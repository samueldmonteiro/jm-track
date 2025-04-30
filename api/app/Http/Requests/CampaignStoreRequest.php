<?php

namespace App\Http\Requests;

class CampaignStoreRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' =>  'required|string',
            'startDate' =>  'required|date',
        ];
    }
}
