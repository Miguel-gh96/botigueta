<?php
if(stripos($_SERVER["CONTENT_TYPE"], "application/json") === 0) {
     $_POST = json_decode(file_get_contents("php://input"), true);
}
/*require_once $_SERVER['DOCUMENT_ROOT'].'hipoteca/api/v1/crud_controller.php';*/
//db
require_once $_SERVER['DOCUMENT_ROOT'].'hipoteca/api/v1/model/conf.class.singleton.php';
require_once $_SERVER['DOCUMENT_ROOT'].'hipoteca/api/v1/model/db.class.singleton.php';

if (PRODUCTION) { //in production
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ERROR | E_WARNING); //error_reporting(E_ALL) ;
    //error_reporting(E_ALL) ; | E_NOTICE --> commit E_NOTICE to use timeout userdao_country
} else {
    ini_set('display_errors', '0');
    ini_set('error_reporting', '0'); //error_reporting(0);
}

    session_start();
    $_SESSION['module'] = '';

function handlerRouter()
{
    if (!empty($_GET['module'])) {
        $URI_module = $_GET['module'];
    } else {
        $error_DB['error_type'] = 400;
        $error_DB['error_message'] = '1Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
    }

    if (!empty($_GET['function'])) {
        $URI_function = $_GET['function'];
    } else {
        $error_DB['error_type'] = 400;
        $error_DB['error_message'] = '2Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
    }
    handlerModule($URI_module, $URI_function);
}

function handlerModule($URI_module, $URI_function)
{
    $path = $_SERVER['DOCUMENT_ROOT'].'hipoteca/api/v1/'.$URI_module.'_controller.class.php';

    if (file_exists($path)) {
        require_once $path;
        $controllerClass = $URI_module.'_controller';
        $obj = new $controllerClass();
    } else {
        $error_DB['error_type'] = 400;
        $error_DB['error_message'] = '3Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
    }
    handlerfunction($URI_module, $obj, $URI_function);
}

function handlerFunction($module, $obj, $URI_function)
{
    call_user_func(array($obj, $URI_function));
}

handlerRouter();
