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
require_once('core/core.php');
$app->get('/dato/:id','authenticate', function ($id) use ($app)  {
    if(filter_var( trim($id),FILTER_VALIDATE_INT )==false)
    {
        
        $response=array
        (
            array
            (
                'error'=>'1',
                'mensaje'=>'Recurso no disponible'
            )
        );
        getResponse(401,$response);
    }else
    {
       $response=array
        (
            array
            (
                'error'=>'0',
                'mensaje'=>'Recurso disponible',
                "id"=>$id,
            )
        );
         getResponse(200,$response);
    }
});
/**
 * petición post
 * */
 $app->post('/dato','authenticate', function() use ($app)  {
    verifyRequiredParams(array('nombre', 'correo', 'rut'));

    //capturamos los parametros recibidos y los almacxenamos como un nuevo array
    $param['nombre']  = $app->request->post('nombre');
    $param['correo'] = $app->request->post('correo');
    $param['rut']  = $app->request->post('rut');
    if ( is_array($param) ) {
         $response=array
        (
            array
            (
                'error'=>'0',
                'mensaje'=>'Recurso disponible',
                "param"=>$param,
            )
        );
        getResponse(200, $response);
    } else {
        $response=array
        (
            array
            (
                'error'=>'1',
                'mensaje'=>'Recurso no disponible'
            )
        );
        getResponse(401,$response);
    }
    
});

/**
 * petición PUT
 * */
 $app->put('/dato/:id','authenticate', function($id) use ($app)  {
    if(filter_var( trim($id),FILTER_VALIDATE_INT )==false)
    {
        
        $response=array
        (
            array
            (
                'error'=>'1',
                'mensaje'=>'Recurso no disponible '
            )
        );
        getResponse(401,$response);
    }else
    {
        $response=array
        (
            array
            (
                'error'=>'0',
                'mensaje'=>'Recurso disponible PUT',
                "id"=>$id,
                'nombre'=>$app->request->post('nombre')
            )
        );
         getResponse(200,$response);
    }
 });
/**
 * petición DELETE
 * */ 

$app->delete('/dato/:id','authenticate', function($id) use ($app)  {
    if(filter_var( trim($id),FILTER_VALIDATE_INT )==false)
    {
        
        $response=array
        (
            array
            (
                'error'=>'1',
                'mensaje'=>'Recurso no disponible'
            )
        );
        getResponse(401,$response);
    }else
    {
        $response=array
        (
            array
            (
                'error'=>'0',
                'mensaje'=>'Recurso disponible delete',
                "id"=>$id,
            )
        );
         getResponse(200,$response);
    }
 });
/**
 * correr la APP
 * */
$app->run();

