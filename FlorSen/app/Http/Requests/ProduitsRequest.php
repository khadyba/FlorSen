<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProduitsRequest extends FormRequest
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
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'required',
            'user_id',
            'categories_id'=>'required|exists:categories,id'
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
                'nom.required' =>'Veuillez renseigner le champ nom!',
                'image.required'=> 'Le champ image n\'es pas remplie !',
                'description.required' =>'Le champ description n\'es pas remplie!',
                'categories_id.required'=> 'veuillez mettre un categories'
        ];

    }
}
