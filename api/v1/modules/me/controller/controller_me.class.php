<?php

class controller_me {

    public function __construct() {
        $_SESSION['module'] = 'me';
    }




    public function cart(){

    }

    public function me(){
      set_error_handler('ErrorHandler');
      try {
          $result = loadModel(MODEL_ME, 'me_model', 'getData', "hola");
      } catch (Exception $e) {
          $error_DB['success'] = false;
          $error_DB['error_type'] = 500;
          $error_DB['error_message'] = 'Hubo un problema en la Base de Datos, intentalo más tarde';
          echo json_encode($error_DB);
          exit;
      }
      restore_error_handler();

      if($result){

        $jsondata['user']['_id'] = $result[0]['_id'];
        $jsondata['user']['data']['oauth'] = $result[0]['oauth'];
        $jsondata['user']['data']['cart'] = $result[0]['cart'];
        $jsondata['user']['profile']['picture'] = $result[0]['picture'];
        $jsondata['user']['profile']['username'] = $result[0]['username'];
        $jsondata['user']['id'] = $result[0]['_id'];

        echo json_encode($jsondata);
        exit;
      }



    }



}
