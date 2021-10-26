<?php

namespace App\Http\Requests\V1\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return $this->method() == 'POST' ? $this->storeValidation() : $this->updateValidation();
    }

    private function storeValidation()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'comment_is_allowed' => 'in:' . implode(',', Product::REVIEW_ALLOWED_TYPES),
            'vote_is_allowed' => 'in:' . implode(',', Product::REVIEW_ALLOWED_TYPES),
            'active' => 'boolean',
        ];
    }

    private function updateValidation()
    {
        return [
            'comment_is_allowed' => 'in:' . implode(',', Product::REVIEW_ALLOWED_TYPES),
            'vote_is_allowed' => 'in:' . implode(',', Product::REVIEW_ALLOWED_TYPES),
            'active' => 'boolean',
        ];
    }


}
