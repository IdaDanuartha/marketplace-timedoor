<?php

namespace App\Http\Requests\Product;

use App\Enum\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => ['required', 'exists:vendors,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image_path' => ['nullable', 'file', 'image', 'max:5000', 'mimes:jpg,jpeg,png,webp,svg,gif'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(ProductStatus::values())],
        ];
    }
}