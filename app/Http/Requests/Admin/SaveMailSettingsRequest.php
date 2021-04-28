<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveMailSettingsRequest extends FormRequest
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
            'settings' => 'array',
            'settings.name_from' => 'required|string',
            'settings.address_from' => 'required|string',
            'settings.send_method' => 'required|string',
            'settings.smtp_port' => 'required|numeric',
            'settings.encrypt_protocol' => 'required|string',
            'settings.server_name' => 'required|string',
            'settings.server_login' => 'required|string',
            'settings.server_password' => 'required|string',
        ];
    }
}
