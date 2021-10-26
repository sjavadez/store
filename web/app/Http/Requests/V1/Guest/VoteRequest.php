<?php

namespace App\Http\Requests\V1\Guest;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rate' => 'required|numeric|min:0|max:10'
        ];
    }

    public function validateResolved()
    {
        parent::validateResolved();

        $this->merge(['user_id'=> $this->user()->id]);
    }
}
