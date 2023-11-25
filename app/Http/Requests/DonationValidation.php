<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\DonationTypeEnum;

class DonationValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $commonRules = [
            'fname' => 'different:lname|max:20|required|string',
            'lname' => 'different:fname|max:20|required|string',
            'phone' => 'required|phone:IR,mobile',
            'amount' => 'required|integer',
        ];

        switch ($this->route('type')) {
            case DonationTypeEnum::CASH->value:
                return $commonRules;
            case DonationTypeEnum::PLANT->value:
                return array_merge($commonRules, [
                    'group' => 'required|boolean',
                    'donated_group_name' => 'string|max:50|required_if:group,true|missing_if:person,true',
                    'donated_group_owner' => 'string|max:30|required_if:group,true|missing_if:person,true',
                    'donated_group_phone' => 'phone:IR,mobile|required_if:group,true|missing_if:person,true',
                    'person' => 'required|boolean',
                    'donated_person_fname' => 'string|max:10|required_if:person,true|missing_if:group,true',
                    'donated_person_lname' => 'string|max:10|required_if:person,true|missing_if:group,true',
                    'donated_person_phone' => 'phone:IR,mobile|required_if:person,true|missing_if:group,true',
                ]);
        
        }

    }
}
