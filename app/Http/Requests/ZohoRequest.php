<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use App\Rules\ZohoStage;
use Illuminate\Foundation\Http\FormRequest;

class ZohoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'account.Account_Name' => 'required|string|max:255',
            'account.Website' => 'required|active_url',
            'account.Phone' => ['required', new Phone, 'max:255',],
            'deal.Deal_Name' => 'required|string|max:255',
            'deal.Stage' => ['required', new ZohoStage,],
        ];
    }
}
