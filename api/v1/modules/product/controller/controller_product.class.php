<?php

class controller_product {

    public function __construct() {
        $_SESSION['module'] = 'product';
    }



    public function id(){

      if (isset($_GET['id'])) {

          $id = $_GET['id'];
          set_error_handler('ErrorHandler');
          try {
              $result = loadModel(MODEL_PRODUCT, 'product_model', 'getData', $id);
          } catch (Exception $e) {
              $error_DB['success'] = false;
              $error_DB['error_type'] = 500;
              $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
              echo json_encode($error_DB);
              exit;
          }
          restore_error_handler();


          if($result) {
            $currency = array(
              'USD' => '$',
              'GBP' => '£',
            );

            $jsondata['product']['_id'] = $result[0]['id_'];
            $jsondata['product']['name'] = $result[0]['name'];
            $jsondata['product']['category']['_id'] = $result[0]['category_id'];
            $jsondata['product']['category']['parent'] = $result[0]['category_parent'];
            $jsondata['product']['category']['ancestors'] = array($result[0]['root_name'],$result[0]['down1_name'],$result[0]['down2_name']);
            $jsondata['product']['price']['amount'] = $result[0]['price_amount'];
            $jsondata['product']['price']['currency'] = $result[0]['price_currency'];
            $jsondata['product']['pictures'] = $result[0]['pictures'];
            $jsondata['product']['displayPrice'] = $currency[$result[0]['price_currency']].$result[0]['price_amount'];
            $jsondata['product']['id'] = $result[0]['id_'];

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

    public function category(){
      if (isset($_GET['id'])) {
          $id = $_GET['id'];


          set_error_handler('ErrorHandler');
          try {
              $result = loadModel(MODEL_PRODUCT, 'product_model', 'getListByCategory', $id);
          } catch (Exception $e) {
              $error_DB['success'] = false;
              $error_DB['error_type'] = 500;
              $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
              echo json_encode($error_DB);
              exit;
          }
          restore_error_handler();


          if($result) {

            $currency = array(
              'USD' => '$',
              'GBP' => '£',
            );



            $jsondata['products'] = array();
            for ($i = 0; $i < count($result);$i++){
              $jsondata[$i]['product']['_id'] = $result[$i]['id_'];
              $jsondata[$i]['product']['name'] = $result[$i]['name'];
              $jsondata[$i]['product']['category']['_id'] = $result[$i]['category_id'];
              $jsondata[$i]['product']['category']['parent'] = $result[$i]['category_parent'];
              $jsondata[$i]['product']['category']['ancestors'] = array($result[$i]['root_name'],$result[$i]['down1_name'],$result[$i]['down2_name']);
              $jsondata[$i]['product']['price']['amount'] = $result[$i]['price_amount'];
              $jsondata[$i]['product']['price']['currency'] = $result[$i]['price_currency'];
              $jsondata[$i]['product']['pictures'] = $result[$i]['pictures'];
              $jsondata[$i]['product']['displayPrice'] = $currency[$result[$i]['price_currency']].$result[$i]['price_amount'];
              $jsondata[$i]['product']['id'] = $result[0]['id_'];

              array_push($jsondata['products'],$jsondata[$i]['product']);

            }

            echo json_encode($jsondata);
            exit;

          }else{

            $error_DB['success'] = false;
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = '1Hubo un problema en la Base de Datos, intentalo más tarde';
            echo json_encode($error_DB);
            exit;

          }

      }

    }

    public function text(){
      if(isset($_GET['query'])){
        $id = $_GET['query'];

        set_error_handler('ErrorHandler');
        try {
            $result = loadModel(MODEL_PRODUCT, 'product_model', 'getListByQuery', $id);
        } catch (Exception $e) {
            $error_DB['success'] = false;
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
        restore_error_handler();


        if($result) {

          $currency = array(
            'USD' => '$',
            'GBP' => '£',
          );

          //get ancestors
          set_error_handler('ErrorHandler');
          try {
              $ancestors = loadModel(MODEL_PRODUCT, 'product_model', 'getAncestors', $result[0]['category_id']);
          } catch (Exception $e) {
              $error_DB['success'] = false;
              $error_DB['error_type'] = 500;
              $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
              echo json_encode($error_DB);
              exit;
          }
          restore_error_handler();


          for ($i = 0; $i < count($ancestors);$i++){
              $ancestor_v1 = $ancestors[0];
              if($ancestors[$i]['down2_name'] != NULL){
                  $ancestor_v1 = $ancestors[$i];
              }
          }

          for ($i = 0; $i < count($result);$i++){
            $jsondata[$i]['products']['ancestors'] = array();
            $jsondata[$i]['product']['_id'] = $result[$i]['id_'];
            $jsondata[$i]['product']['name'] = $result[$i]['name'];
            $jsondata[$i]['product']['category']['_id'] = $result[$i]['category_id'];
            $jsondata[$i]['product']['category']['parent'] = $result[$i]['category_parent'];
            $jsondata[$i]['product']['price']['amount'] = $result[$i]['price_amount'];
            $jsondata[$i]['product']['price']['currency'] = $result[$i]['price_currency'];
            $jsondata[$i]['product']['pictures'] = $result[$i]['pictures'];
            $jsondata[$i]['product']['displayPrice'] = $currency[$result[$i]['price_currency']].$result[$i]['price_amount'];
            $jsondata[$i]['product']['id'] = $result[0]['id_'];

            foreach ($ancestor_v1 as $obj) {
                  array_push($jsondata[$i]['products']['ancestors'],$obj);
                  if($result[$i]['_id'] === $obj){
                    break;
                  }
            }
          }




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
