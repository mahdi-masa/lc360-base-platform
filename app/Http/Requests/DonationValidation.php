<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\DonationTypeEnum;

class DonationValidation extends FormRequest
{
    public $donationType = DonationTypeEnum::CASH->value;

    public function __construct()
    {
        parent::__construct();

        // Access the 'id' parameter from the route
        $this->donationType = $this->route('type');
    }
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
        
        switch ($this->donationType) {
            case DonationTypeEnum::CASH:
                return [
                    'fname'=>'different:lname|max:20|required|string',
                    'lname'=>'different:fname|max:20|required|string',
                    'phone'=>'required|max_digits:11|integer',
                    'amount'=>'required|bail|integer'
                ];
                break;
            case DonationTypeEnum::PLANT:
                return [
                    'fname'=>'different:lname|max:20|required|string',
                    'lname'=>'different:fname|max:20|required|string',
                    'phone'=>'required|max_digits:11|integer',
                    'group' => 'required|boolean|bail',
                    'donated_group_name'=> 'string|max:50|required|missing_if:group,false',
                    'donated_group_owner'=> 'string|max:30|required|missing_if:group,false',
                    'donated_group_phone'=> 'integer|max_digits:11|required|missing_if:group,false',
                    'person' => 'required|boolean|bail',
                    'donated_person_fname'=> 'string|max:10|required|missing_if:person,false',
                    'donated_person_lname'=> 'string|max:10|required|missing_if:person,false',
                    'donated_person_phone'=> 'integer|max_digits:11|required|missing_if:person,false',
                    'amount'=>'required|bail|integer',

                ];
                break;
        }

       
    }
}
