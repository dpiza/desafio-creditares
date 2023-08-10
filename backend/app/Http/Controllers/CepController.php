<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cep;
use App\Services\CepService;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PutUpdateRequest;
use Illuminate\Http\JsonResponse;

class CepController extends Controller
{
  public function findAll()
  {
    try {
      $cepList = Cep::all();
    } catch (Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
        'data' => [],
      ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return response()->json([
      'message' => 'Succeed',
      'data' => $cepList,
    ], JsonResponse::HTTP_OK);
  }

  public function findByCep($cep, CepService $cepService)
  {
    try {
      $dbCep = $cepService->findByCep($cep);
    } catch (Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
        'data' => [],
      ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return response()->json([
      'message' => ($dbCep) ? 'Succeed' : 'Invalid CEP: ' . $cep,
      'data' => $dbCep,
    ], JsonResponse::HTTP_OK);
  }

  public function findByStreetName($streetName, CepService $cepService)
  {
    try {
      $cep = $cepService->findByStreetName($streetName);
    } catch (Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
        'data' => [],
      ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    return response()->json([
      'message' => ($cep) ? 'Succeed' : 'Invalid Street Name: ' . $streetName,
      'data' => $cep,
    ], JsonResponse::HTTP_OK);
  }

  public function store(PostStoreRequest $request, $cep, CepService $cepService)
  {
    try {
      $cepService->addCep($request, $cep);
    } catch (Exception $e) {
      if (
        $e->getMessage() == "Cep already in database" ||
        $e->getMessage() == "Subject cep differs from object cep"
      ) {
        $responseStatus = JsonResponse::HTTP_BAD_REQUEST;
      } else {
        $responseStatus = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
      }

      return response()->json([
        'message' => $e->getMessage(),
        'data' => [],
      ], $responseStatus);
    }

    return response()->json([
      'message' => 'Succeed',
      'data' => [],
    ], JsonResponse::HTTP_CREATED);
  }

  public function update(PutUpdateRequest $request, $cep, CepService $cepService)
  {
    try {
      $cepService->updateCep($request, $cep);
    } catch (Exception $e) {
      if ($e->getMessage() == "Subject cep differs from object cep") {
        $responseStatus = JsonResponse::HTTP_BAD_REQUEST;
      } else {
        $responseStatus = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
      }
      return response()->json([
        'message' => $e->getMessage(),
        'data' => [],
      ], $responseStatus);
    }

    return response()->json([
      'message' => 'Succeed',
      'data' => [],
    ], JsonResponse::HTTP_OK);
  }
}
