<?php

namespace App\Http\Controllers;

use App\Models\Recordatorio;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;

class RecordatorioController extends Controller
{
    public function getAllByIdUsuario($id_usuario) {
        $recordatorios = Recordatorio::getAllRecordatoriosUsuario($id_usuario);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($recordatorios);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getById(string $id) {
        $resultResponse = new ResultResponse();

        try {
            $recordatorio = Recordatorio::getRecordatorioById($id);

            $resultResponse->setData($recordatorio);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (Exception $e) {

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
            $this->validateRecordatorio($request, $requestContent);

            $newRecordatorio = new Recordatorio([
                'mensaje' => $requestContent['mensaje'],
                'fecha_creacion' => $requestContent['fecha_creacion'],
                'periodo_recordatorio' => $requestContent['periodo_recordatorio'],
                'id_usuario' => $requestContent['id_usuario']
            ]);

            $newRecordatorio->createRecordatorio();

            $resultResponse->setData($newRecordatorio);
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

    public function delete($id) {
        $resultResponse = new ResultResponse();

        try {
            $recordatorio = Recordatorio::getRecordatorioById($id);
            $recordatorio->deleteRecordatorio();

            $resultResponse->setData($recordatorio);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }
        catch (Exception $e) {
            $resultResponse->setData($e);
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }

    private function validateRecordatorio($request, $content) {
        $rules = [];

        $validationRules = [
            'mensaje'=> 'required',
            'fecha_creacion'=> 'required',
            'periodo_recordatorio'=> 'required',
            'id_usuario'=> 'required'
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
