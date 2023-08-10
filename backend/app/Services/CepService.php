<?php

namespace App\Services;

use Exception;
use App\Models\Cep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CepService
{
  public function validateCep($cep)
  {
    $validator = Validator::make((array)$cep, [
      'cep' => 'required|unique:ceps|max:8',
      'logradouro' => 'required',
      'bairro' => 'required',
      'cidade' => 'required',
      'uf' => 'required',
    ]);
    if ($validator->fails()) {
      throw new Exception('Data validation error');
    }
  }

  public function addNewCep($cepObject)
  {
    $this->validateCep($cepObject);

    return Cep::create([
      'cep'        => $cepObject->cep,
      'logradouro' => $cepObject->logradouro,
      'bairro'     => $cepObject->bairro,
      'cidade'     => $cepObject->cidade,
      'uf'         => $cepObject->uf,
    ]);
  }

  public function findByCep($cep)
  {
    $dbCep = DB::table('ceps')->where('cep', $cep)->first();

    if (is_null($dbCep)) {
      $fetchCep = $this->fetchCep($cep);

      if (!empty($fetchCep)) {
        $dbCep = $this->addNewCep($fetchCep);
      }
    }

    return $dbCep;
  }

  public function findByStreetName($streetName)
  {
    $dbCep = DB::table('ceps')->where('logradouro', 'LIKE', "%{$streetName}%")->first();

    if (is_null($dbCep)) {
      $fetchCep =  $this->fetchCep($streetName);

      if (!empty($fetchCep)) {
        return $fetchCep;
      }
    }

    return $dbCep;
  }

  public function addCep($request, $cep)
  {
    $cepObject = json_decode($request->getContent(), false);
    if ($cepObject->cep != $cep) {
      throw new Exception('Subject cep differs from object cep');
    }

    $dbCep = DB::table('ceps')->where('cep', $cep)->first();
    if (isset($dbCep)) {
      throw new Exception('Cep already in database');
    }

    $newCep = $this->addNewCep($cepObject);

    return $newCep;
  }

  public function fetchCep($query)
  {
    $fetchCep = Http::acceptJson()->get("http://cep.la/{$query}");
    $cepObject = json_decode($fetchCep, false);

    return $cepObject;
  }
}
