<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/v1/paths.php';
require_once SITE_ROOT.'autoload.php';

include UTILS.'filters.inc.php';
include UTILS.'utils.inc.php';
include UTILS.'response_code.inc.php';
include UTILS.'common.inc.php';






if (PRODUCTION) { //in production
    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ERROR | E_WARNING); //error_reporting(E_ALL) ;
    //error_reporting(E_ALL) ; | E_NOTICE --> commit E_NOTICE to use timeout userdao_country
} else {
    ini_set('display_errors', '0');
    ini_set('error_reporting', '0'); //error_reporting(0);
}

    //ob_start();
    session_start();
    $_SESSION['module'] = '';



	 //clean
	  $filter = inputfilter::getInstance();
    $_POST = json_decode(file_get_contents('php://input'), true);
    $_POST = $filter->process($_POST);
    $_GET = $filter->process($_GET);



function handlerRouter()
{
    if (!empty($_GET['module'])) {
        $URI_module = $_GET['module'];
        if($URI_module === 'me'){
          $_GET['function'] = 'me';
        }
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
        $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
    }
    handlerModule($URI_module, $URI_function);
}

function handlerModule($URI_module, $URI_function)
{
    $modules = simplexml_load_file('resources/modules.xml');
    $exist = false;
    foreach ($modules->module as $module) {
        if (($URI_module === (String) $module->uri)) {
            $exist = true;

            $path = MODULES_PATH.$URI_module.'/controller/controller_'.$URI_module.'.class.php';

            if (file_exists($path)) {
                require_once $path;
                $controllerClass = 'controller_'.$URI_module;
                $obj = new $controllerClass();
            } else {
              $error_DB['error_type'] = 400;
              $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
              echo json_encode($error_DB);
              exit;
            }
            handlerfunction(((String) $module->name), $obj, $URI_function);
            break;
        }
    }
    if (!$exist) {
      $error_DB['error_type'] = 400;
      $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
      echo json_encode($error_DB);
      exit;
    }
}

function handlerFunction($module, $obj, $URI_function)
{
    $functions = simplexml_load_file(MODULES_PATH.$module.'/resources/functions.xml');
    $exist = false;
    foreach ($functions->function as $function) {
        if (($URI_function === (String) $function->uri)) {

            $exist = true;
            $event = (String) $function->name;
            break;
        }
    }
    if (!$exist) {
      $error_DB['error_type'] = 400;
      $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
      echo json_encode($error_DB);
      exit;
    } else {
        //$obj->$event();
        call_user_func(array($obj, $event));
    }
}

handlerRouter();
