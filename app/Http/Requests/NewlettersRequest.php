<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NewlettersRequest extends FormRequest
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
            'email'=>'required|unique:users,email'
        ];
    }


    public function failedValidation(Validator $validator){
        throw new HttpResponseException( response()->json([
           'success'=>false,
           'status_code'=>422,
           'error'=>true,
           'message'=>'Erreur de validation',
           'errorsList' =>$validator->errors()
        ]));
    }

    public function messages()
    {
                return [
                        'email.required' =>'une adresse  email doit etre fournie',
                        'email.unique' =>'l\adresse email existe déjat',
                ];
    }

}