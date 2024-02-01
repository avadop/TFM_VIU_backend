<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ResultResponse;
use Exception;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function getAllByIdUsuario($id_usuario) {
        $productos = Producto::getAllProductosUsuario($id_usuario);

        $resultResponse = new ResultResponse();
        $resultResponse->setData($productos);
        $resultResponse->setStatusCode(ResultResponse::SUCCESS_CODE);
        $resultResponse->setMessage(ResultResponse::TXT_SUCCESS_CODE);

        $json = json_encode($resultResponse, JSON_PRETTY_PRINT);

        return response($json)->header('Content-Type', 'application/json');
    }

    public function getById(string $id) {
        $resultResponse = new ResultResponse();

        try {
            $producto = Producto::getProductoById($id);

            $resultResponse->setData($producto);
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
            $this->validateProducto($request, $requestContent);

            $newProducto = new Producto([
                'nombre' => $requestContent['nombre'],
                'descripcion' => $requestContent['descripcion'],
                'impuesto' => $requestContent['impuesto'],
                'precio_unidad' => $requestContent['precio_unidad'],
                'stock' => $requestContent['stock'],
                'id_usuario' => $requestContent['id_usuario']
            ]);

            $newProducto->createProducto();

            $resultResponse->setData($newProducto);
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
            $producto = Producto::getProductoById($id);
            $producto->deleteProducto();

            $resultResponse->setData($producto);
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

    private function validateProducto($request, $content) {
        $rules = [];

        $validationRules = [
            'nombre'=> 'required',
            'precio_unidad'=> 'required',
            'impuesto'=> 'required',
            'stock'=> 'required',
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
