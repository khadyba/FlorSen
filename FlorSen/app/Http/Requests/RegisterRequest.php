<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
                    'prenom'=>'required',
                    'nom'=>'required',
                    'adresse'=>'required',  
                    'telephone' => [
                          'required',
                         'regex:/^\d{2}-\d{3}-\d{2}-\d{2}$/',
                     ],
                    'email'=>'required|unique:users,email',
                    'password'=>'required|max:8'
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


        // fonction pour traduire les message d'ereur en francais
        public function messages()
        {
                    return [
                            'telephone.required'=> 'Veuiller mettre un numéro de telephone valide',   
                            'prenom.required' =>'Veuillez renseignée votre prenom',  
                            'nom.required' =>'Veillez renseignée votre nom',
                            'email.required' =>'une adresse  email doit etre fournie',
                            'email.unique' =>'l\adresse email existe déjat',
                            'password.required' =>'Le mot de passe est requis et doit avoir au minimum 7 caractères',
                    ];
        }

}