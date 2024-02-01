<?php

namespace App\Http\Controllers;

use App\Models\ResultResponse;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UsuarioController extends Controller
{
    public function create(Request $request) {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse = new ResultResponse();
    
        try {
            $this->validateUsuario($request, $requestContent);

            $newUsuario = new Usuario([
                'nif' => $requestContent['nif'],
                'nombre' => $requestContent['nombre'],
                'apellidos' => $requestContent['apellidos'],
                'correo_electronico' => $requestContent['correo_electronico'],
                'direccion' => $requestContent['direccion'],
                'codigo_postal' => $requestContent['codigo_postal'],
                'poblacion' => $requestContent['poblacion'],
                'provincia' => $requestContent['provincia'],
                'pais' => $requestContent['pais'],
                'contrasenya' => Hash::make($requestContent['contrasenya'])
            ]);

            $newUsuario->createUsuario();

            $resultResponse->setData($newUsuario);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (Exception $e) {
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }

    public function login(Request $request) {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse = new ResultResponse();
    
        try {
            $usuario = Usuario::getUsuarioById($requestContent['nif']);

            if(Hash::check($requestContent['contrasenya'], $usuario->contrasenya)) {
                $resultResponse->setData($usuario);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
            }
            else {
                $resultResponse->setData('Error en credenciales');
                $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
            }
        } catch (Exception $e) {
            $resultResponse->setData($usuario);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }

    private function validateUsuario($request, $content) {
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
            'contrasenya' => 'required'
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
