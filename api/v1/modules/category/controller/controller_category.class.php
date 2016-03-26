<?php

class controller_category
{
    public function __construct()
    {
        //add autoload
        $_SESSION['module'] = 'category';
    }

    public function id()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            set_error_handler('ErrorHandler');
            try {
                $result = loadModel(MODEL_CATEGORY, 'category_model', 'getData', $id);
            } catch (Exception $e) {
                $error_DB['success'] = false;
                $error_DB['error_type'] = 500;
                $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
                echo json_encode($error_DB);
                exit;
            }
            restore_error_handler();


            if($result) {


              set_error_handler('ErrorHandler');
              try {
                  $ancestors = loadModel(MODEL_CATEGORY, 'category_model', 'getAncestors', $id);
              } catch (Exception $e) {
                  $error_DB['success'] = false;
                  $error_DB['error_type'] = 500;
                  $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
                  echo json_encode($error_DB);
                  exit;
              }
              restore_error_handler();

              $ancestor = array();
              foreach ($ancestors[0] as $obj) {
                    array_push($ancestor,$obj);
                    if($id === $obj){
                      break;
                    }

              }
              $jsondata['category'] = $result[0];
              $jsondata['category']['ancestors'] = $ancestor;
              echo json_encode($jsondata);
              exit;

            }else{

              $error_DB['success'] = false;
              $error_DB['error_type'] = 500;
              $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
              echo json_encode($error_DB);
              exit;

            }

        }
    }

    public function parent()
    {
        if (isset($_GET['id'])) {

          $id = $_GET['id'];
          set_error_handler('ErrorHandler');
          try {
              $result = loadModel(MODEL_CATEGORY, 'category_model', 'getCategories', $id);
          } catch (Exception $e) {
              $error_DB['success'] = false;
              $error_DB['error_type'] = 500;
              $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
              echo json_encode($error_DB);
              exit;
          }
          restore_error_handler();

          if($result) {


            set_error_handler('ErrorHandler');
            try {
                $ancestors = loadModel(MODEL_CATEGORY, 'category_model', 'getAncestors', $id);
            } catch (Exception $e) {
                $error_DB['success'] = false;
                $error_DB['error_type'] = 500;
                $error_DB['error_message'] = '1Hubo un problema en la Base de Datos, intentalo más tarde';
                echo json_encode($error_DB);
                exit;
            }
            restore_error_handler();

            for ($i = 0; $i < count($result);$i++){
              $result[$i]['ancestors'] = array();
              foreach ($ancestors[$i] as $obj) {
                    array_push($result[$i]['ancestors'],$obj);
                    if($result[$i]['_id'] === $obj){
                      break;
                    }
              }
            }



            $jsondata['categories'] = $result;

            echo json_encode($jsondata);
            exit;

          }else{

            $error_DB['success'] = false;
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
            echo json_encode($error_DB);
            exit;

          }

        }
    }
}
