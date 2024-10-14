<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            "idCategoria" => "required|integer",
            "titolo" => "required|string",
            "descrizione" => "required|string",
            "durata" => "required|integer",
            "regista" => "required|string",
            "attori" => "required|string",
            "anno" => "required|integer"
        ];
    }
}
