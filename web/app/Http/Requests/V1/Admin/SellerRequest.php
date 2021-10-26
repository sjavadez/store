<?php

namespace App\Http\Requests\V1\Admin;

use App\Models\Seller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SellerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'company' => 'required',
            'status' => 'in:' . implode(',' , Seller::STATUES)
        ];
    }
}
