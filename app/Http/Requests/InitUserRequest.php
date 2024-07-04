<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


/**
 * @property string $email
 * @property string $phone
 * @property string $name
 */
class InitUserRequest extends FormRequest
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
        return [
            'email' => 'nullable|email|max:255',
            'phone' => 'required',
            'name' => 'max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Email không hợp lệ!',
            'email.max' => 'Email chỉ được tối đa 255 kí tự',
            'name.max' => 'Tên chỉ được tối đa 255 kí tự',
            'phone.required' => 'Số điện thoại là bắt buộc',
        ];
    }

}
