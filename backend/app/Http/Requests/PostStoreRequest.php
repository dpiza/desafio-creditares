<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class PostStoreRequest extends FormRequest
{
  public function rules()
  {
    return [
      'cep' => 'required|unique:ceps|max:8',
      'logradouro' => 'required',
      'bairro' => 'required',
      'cidade' => 'required',
      'uf' => 'required',
    ];
  }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'message'   => 'Validation errors',
      'data'      => $validator->errors()
    ], JsonResponse::HTTP_BAD_REQUEST));
  }

  public function messages()
  {
    return [
      'cep.required' => 'Field cep is required.',
      'cep.unique' => 'Field cep is not unique.',
      'logradouro.required' => 'Field logradouro is required.',
      'bairro.required' => 'Field bairro is required.',
      'cidade.required' => 'Field cidade is required.',
      'uf.required' => 'Field uf is required.',
    ];
  }
}
