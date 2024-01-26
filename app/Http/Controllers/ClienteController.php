<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ResultResponse;

class ClienteController extends Controller
{
    public function getAllByIdUsuario($id_usuario) {
        $clientes = Cliente::getAllClientesUsuario($id_usuario);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($clientes);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getById($id) {
        $resultResponse = new ResultResponse();

        try {
            $cliente = Cliente::getClienteById($id);

            $resultResponse->setData($cliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (\Exception $e) {

            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
         }

         $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
         return response($json)->header('Content-Type', 'application/json');
    }

    public function create(Request $request) {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse = new ResultResponse();

        try {
            $this->validateCliente($request, $requestContent);

            $newCliente = new Cliente([
                'nif' => $requestContent['nif'],
                'nombre' => $requestContent['nombre'],
                'apellidos' => $requestContent['apellidos'],
                'correo_electronico' => $requestContent['correo_electronico'],
                'direccion' => $requestContent['direccion'],
                'codigo_postal' => $requestContent['codigo_postal'],
                'poblacion' => $requestContent['poblacion'],
                'provincia' => $requestContent['provincia'],
                'pais' => $requestContent['pais'],
                'id_usuario' => $requestContent['id_usuario']
            ]);

            $newCliente->createCliente();

            $resultResponse->setData($newCliente);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (Exception $e) {
            $resultResponse->setData($newCliente);
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }


    private function validateCliente($request, $content) {
        $rules = [];

        $validationRules = [
            'nif' => 'required|size:9',
            'nombre'=> 'required',
            'apellidos'=> 'required',
            'correo_electronico'=> 'required|email',
            'direccion'=> 'required',
            'codigo_postal'=> 'required',
            'provincia'=> 'required',
            'pais'=> 'required',
            'poblacion'=> 'required',
            'id_usuario' => 'required|size:9'
        ];

        foreach ($validationRules as $field => $validationRule) {
            if($content[$field]) {
                $rules[$field] = $validationRule;
            }
        }

        $validateData = $request->validate($rules);

        return $validateData;
    }
}
