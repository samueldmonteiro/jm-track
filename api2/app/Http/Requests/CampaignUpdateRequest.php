<?php

namespace App\Http\Requests;

class CampaignUpdateRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' =>  'required|string',
        ];
    }
}
