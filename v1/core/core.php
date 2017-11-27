<?php
/**
 *
 * @About     Interface básica API Rest con Slim Framework (http://docs.slimframework.com)
 * @File      index.php
 * @Date      Nov-2017
 * @Version   1.0
 * @Developer César Cancino (yo@cesarcancino.com)
 * 
 **/
getCors();
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/**
 * funciones helpers
 * */
 function getCors()
 {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
    header("Access-Control-Allow-Headers: X-Requested-With");
    header('Content-Type: text/html; charset=utf-8');
    header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
 }
function getResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
          $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
         $response["message"] = 'Los campos ' . substr($error_fields, 0, -2) . ' son requeridos';
        getResponse(400, $response);
        
        $app->stop();
    }
}
function authenticate(\Slim\Route $route) {
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
      if (isset($headers['token'])) {
        $token = $headers['token'];
        if (!($token == '123456')) { 
            $response["error"] = 1;
            $response["message"] = "Acceso denegado. Token inválido";
            getResponse(401, $response);
            
            $app->stop(); 
            
        } else {
           
        }
    } else {
        
        $response["error"] = 1;
        $response["message"] = "Falta token de autorización";
        getResponse(400, $response);
        
        $app->stop();
    }
}