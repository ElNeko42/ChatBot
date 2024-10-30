<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajusta según tus necesidades de autorización
    }

    public function rules()
    {
        $rules = [];

        if ($this->route('id')) {
            // Si hay un ID, estás actualizando un chat: requiere 'promt'
            $rules['promt'] = 'required|string';
        } else {
            // Si no hay ID, estás creando un nuevo chat: requiere 'role'
            $rules['role'] = 'required|string|in:Recepcionista de Hotel,Asistente General,Soporte Técnico';
        }

        return $rules;
    }
}
