<?php

namespace App\Http\Controllers;

use App\Models\ProductosFactura;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;

class ProductosFacturaController extends Controller
{
    public function getAllByIdFactura($id_factura) {
        $productosFacturas = ProductosFactura::getAllProductosFatura($id_factura);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($productosFacturas);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getById(string $id) {
        $resultResponse = new ResultResponse();

        try {
            $productosFactura = ProductosFactura::getProductosFacturaById($id);

            $resultResponse->setData($productosFactura);
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
            $this->validateProductosFactura($request, $requestContent);

            $newProductosFactura = new ProductosFactura([
                'cantidad' => $requestContent['cantidad'],
                'id_factura' => $requestContent['id_factura'],
                'id_producto' => $requestContent['id_producto'],
            ]);

            $newProductosFactura->createProductosFactura();

            $resultResponse->setData($newProductosFactura);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        } catch (Exception $e) {
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }

    public function delete($id) {
        $resultResponse = new ResultResponse();

        try {
            $productosFactura = ProductosFactura::getProductosFacturaById($id);
            $productosFactura->deleteProductosFactura();

            $resultResponse->setData($productosFactura);
            $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);
        }
        catch (Exception $e) {
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }


    public function update(Request $request) {
        $requestContent = json_decode($request->getContent(), true);
        $resultResponse = new ResultResponse();
    
        try {
            $this->validateProductosFactura($request, $requestContent);
    
            try {
                $productos_factura = ProductosFactura::getProductosFacturaById($requestContent['id_productos_factura']);

                $productos_factura->cantidad = $requestContent['cantidad'];
                $productos_factura->id_producto = $requestContent['id_producto'];
                $productos_factura->id_factura = $requestContent['id_factura'];

                $productos_factura->updateProductosFactura();

                $resultResponse->setData($productos_factura);
                $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

            }catch (Exception $e) {
                $resultResponse->setData($e->getMessage());
                $resultResponse->setStatusCode(ResultResponse::ERROR_ELEMENT_NOT_FOUND_CODE);
                $resultResponse->setMessage(ResultResponse::TXT_ERROR_ELEMENT_NOT_FOUND_CODE);
            }
        } catch (Exception $e) {
            $resultResponse->setData($e->getMessage());
            $resultResponse->setStatusCode(ResultResponse::ERROR_CODE);
            $resultResponse->setMessage(ResultResponse::TXT_ERROR_CODE);
        }

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);
        return response($json)->header('Content-Type','application/json');
    }

    private function validateProductosFactura($request, $content) {
        $rules = [];

        $validationRules = [
            'cantidad'=> 'required|min:1',
            'id_factura'=> 'required',
            'id_producto'=> 'required'
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
