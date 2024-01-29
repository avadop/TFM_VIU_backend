<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function getAllByIdReceptor($id_receptor) {
        $facturas = Factura::getAllFacturasReceptor($id_receptor);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($facturas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getAllByIdEmisor($id_emisor) {
        $facturas = Factura::getAllFacturasEmisor($id_emisor);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($facturas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getById(string $id) {
        $resultResponse = new ResultResponse();

        try {
            $factura = Factura::getFacturaById($id);

            $resultResponse->setData($factura);
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
            $this->validateFactura($request, $requestContent);

            $newFactura = new Factura([
                'fecha_emision' => $requestContent['fecha_emision'],
                'fecha_vencimiento' => $requestContent['fecha_vencimiento'],
                'precio_total' => $requestContent['precio_total'],
                'estado_pago' => $requestContent['estado_pago'],
                'id_emisor' => $requestContent['id_emisor'],
                'id_receptor' => $requestContent['id_receptor']
            ]);

            $newFactura->createFactura();

            $resultResponse->setData($newFactura);
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
            $factura = Factura::getFacturaById($id);
            $factura->deleteFactura();

            $resultResponse->setData($factura);
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

    private function validateFactura($request, $content) {
        $rules = [];

        $validationRules = [
            'fecha_emision'=> 'required|date',
            'fecha_vencimiento'=> 'required|date',
            'precio_total' => 'required',
            'estado_pago'=> 'required',
            'id_emisor' => 'required',
            'id_receptor' => 'required'
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
