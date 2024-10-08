<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Método para retornar uma resposta de sucesso.
     *
     * @param mixed  $result O resultado a ser retornado.
     * @param string $message A mensagem de sucesso.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON.
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * Método para retornar uma resposta de erro.
     *
     * @param string $error A mensagem de erro.
     * @param array  $errorMessages Mensagens de erro adicionais.
     * @param int    $code Código de status HTTP.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON.
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Método para retornar uma resposta de erro não autorizado (403 Forbidden).
     *
     * @param string $message A mensagem de erro.
     * @return \Illuminate\Http\JsonResponse Resposta em formato JSON.
     */
    public function sendForbidden($message = 'Ação não autorizada'): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, 403);
    }
}
