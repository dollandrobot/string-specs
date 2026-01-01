<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

final class UpdateStringSetRequest extends FormRequest
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
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'uuid', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'product_code' => ['nullable', 'string', 'max:255'],
            'winding_length' => ['nullable', 'integer', 'min:100', 'max:6000'],
            'number_of_strings' => ['nullable', 'integer', 'min:1', 'max:18'],
            'highest_string_gauge' => ['nullable', 'integer', 'min:1', 'max:200'],
            'lowest_string_gauge' => ['nullable', 'integer', 'min:1', 'max:200', 'gt:highest_string_gauge'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'lowest_string_gauge.gt' => 'The low string gauge must be greater than the high string gauge.',
        ];
    }
}
