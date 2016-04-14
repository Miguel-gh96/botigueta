<?php
class crud_controller
{
    public function __construct()
    {
        $_SESSION['module'] = 'crud';
        $this->db = db::getInstance();
    }

    public function get_all()
    {
      $sql = 'SELECT * FROM hipotecas';
      $stmt = $this->db->ejecutar($sql);
      $response = $this->db->listar($stmt);

      if($response){
        foreach ($response as $key => $value) {
            $jsondata[$key]['idHipoteca'] = $value['idHipoteca'];
            $jsondata[$key]['nif'] = $value['nif'];
            $jsondata[$key]['nombre'] = $value['nombre'];
            $jsondata[$key]['ape1'] = $value['ape1'];
            $jsondata[$key]['ape2'] = $value['ape2'];
            $jsondata[$key]['edad'] = intval($value['edad']);
            $jsondata[$key]['telefono'] = $value['telefono'];
            $jsondata[$key]['email'] = $value['email'];
            $jsondata[$key]['dades_economiques']['ingresos_mensuales'] = intval($value['ingresos_mensuales']);
            $jsondata[$key]['dades_economiques']['capital'] = intval($value['capital']);
            $jsondata[$key]['dades_economiques']['tipo_interes'] = $value['tipo_interes'];
            $jsondata[$key]['dades_economiques']['euribor'] = floatval($value['euribor']);
            $jsondata[$key]['dades_economiques']['diferencial'] = floatval($value['diferencial']);
            $jsondata[$key]['dades_economiques']['interes_fijo'] = floatval($value['interes_fijo']);
            $jsondata[$key]['dades_economiques']['plazo_anyos'] = intval($value['plazo_anyos']);
            $jsondata[$key]['dades_economiques']['producto_segurocasa'] = ($value['producto_segurocasa']) ? True : False;
            $jsondata[$key]['dades_economiques']['producto_nomina'] = ($value['producto_nomina']) ? True : False;
            $jsondata[$key]['dades_economiques']['producto_segurovida'] = ($value['producto_segurovida']) ? True : False;
        }
        echo json_encode($jsondata);
        exit;
      }else{
        $error_DB['error_type'] = 500;
        $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
      }


    }

    public function get()
    {
      if($_GET['id']){
        $sql = 'SELECT * FROM hipotecas WHERE idHipoteca="'.$_GET['id'].'"';
        $stmt = $this->db->ejecutar($sql);
        $response = $this->db->listar($stmt);

        if($response[0]){
              $jsondata['idHipoteca'] = $value['idHipoteca'];
              $jsondata['nif'] = $value['nif'];
              $jsondata['nombre'] = $value['nombre'];
              $jsondata['ape1'] = $value['ape1'];
              $jsondata['ape2'] = $value['ape2'];
              $jsondata['edad'] = intval($value['edad']);
              $jsondata['telefono'] = $value['telefono'];
              $jsondata['email'] = $value['email'];
              $jsondata['dades_economiques']['ingresos_mensuales'] = intval($value['ingresos_mensuales']);
              $jsondata['dades_economiques']['capital'] = intval($value['capital']);
              $jsondata['dades_economiques']['tipo_interes'] = $value['tipo_interes'];
              $jsondata['dades_economiques']['euribor'] = floatval($value['euribor']);
              $jsondata['dades_economiques']['diferencial'] = floatval($value['diferencial']);
              $jsondata['dades_economiques']['interes_fijo'] = floatval($value['interes_fijo']);
              $jsondata['dades_economiques']['plazo_anyos'] = intval($value['plazo_anyos']);
              $jsondata['dades_economiques']['producto_segurocasa'] = ($value['producto_segurocasa']) ? True : False;
              $jsondata['dades_economiques']['producto_nomina'] = ($value['producto_nomina']) ? True : False;
              $jsondata['dades_economiques']['producto_segurovida'] = ($value['producto_segurovida']) ? True : False;
              echo json_encode($jsondata);
              exit;
        }else{
          $error_DB['error_type'] = 500;
          $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
          echo json_encode($error_DB);
          exit;
        }
      }else{
        $error_DB['error_type'] = 500;
        $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
      }
    }

    public function add()
    {

        if($_POST['data']){
          $jsondata = $_POST['data'];

          $jsondata['dades_economiques']['producto_segurocasa'] = ($jsondata['dades_economiques']['producto_segurocasa']) ? 1 : 0;
          $jsondata['dades_economiques']['producto_nomina'] = ($jsondata['dades_economiques']['producto_nomina']) ? 1 : 0;
          $jsondata['dades_economiques']['producto_segurovida'] = ($jsondata['dades_economiques']['producto_segurovida']) ? 1 : 0;
          $jsondata['dades_economiques']['euribor'] = ($jsondata['dades_economiques']['euribor'] === "") ? NULL : $jsondata['dades_economiques']['euribor'];
          $jsondata['dades_economiques']['diferencial'] = ($jsondata['dades_economiques']['diferencial'] === "") ? NULL : $jsondata['dades_economiques']['diferencial'];
          $jsondata['dades_economiques']['interes_fijo'] = ($jsondata['dades_economiques']['interes_fijo'] === "") ? NULL : $jsondata['dades_economiques']['interes_fijo'];
          $jsondata['idHipoteca'] = mt_rand(10,10000);
          $sql = 'INSERT INTO hipotecas VALUES ( '
          .'"'.$jsondata['idHipoteca'].'", '
          .'"'.$jsondata['nif'].'", '
          .'"'.$jsondata['nombre'].'", '
          .'"'.$jsondata['ape1'].'", '
          .'"'.$jsondata['ape1'].'", '
          .''.$jsondata['edad'].', '
          .''.$jsondata['telefono'].', '
          .'"'.$jsondata['email'].'", '
          .$jsondata['dades_economiques']['ingresos_mensuales'].', '
          .$jsondata['dades_economiques']['capital'].', '
          .'"'.$jsondata['dades_economiques']['tipo_interes'].'", '
          .$jsondata['dades_economiques']['euribor'].', '
          .$jsondata['dades_economiques']['diferencial'].', '
          .'"'.$jsondata['dades_economiques']['interes_fijo'].'", '
          .$jsondata['dades_economiques']['plazo_anyos'].', '
          .$jsondata['dades_economiques']['producto_segurocasa'].', '
          .$jsondata['dades_economiques']['producto_nomina'].', '
          .$jsondata['dades_economiques']['producto_segurovida'].' )';

          $response = $this->db->ejecutar($sql);

          if($response){
            $jsondata['success'] = True;
            echo json_encode($jsondata);
            exit;
          }else{
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
          }
        }else{
          $error_DB['error_type'] = 400;
          $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
          echo json_encode($error_DB);
          exit;
        }
    }

    public function set()
    {
      if($_POST['data']){

        $jsondata = $_POST['data'];

        $jsondata['dades_economiques']['producto_segurocasa'] = ($jsondata['dades_economiques']['producto_segurocasa']) ? 1 : 0;
        $jsondata['dades_economiques']['producto_nomina'] = ($jsondata['dades_economiques']['producto_nomina']) ? 1 : 0;
        $jsondata['dades_economiques']['producto_segurovida'] = ($jsondata['dades_economiques']['producto_segurovida']) ? 1 : 0;
        $jsondata['dades_economiques']['euribor'] = ($jsondata['dades_economiques']['euribor'] === "") ? NULL : $jsondata['dades_economiques']['euribor'];
        $jsondata['dades_economiques']['diferencial'] = ($jsondata['dades_economiques']['diferencial'] === "") ? NULL : $jsondata['dades_economiques']['diferencial'];
        $jsondata['dades_economiques']['interes_fijo'] = ($jsondata['dades_economiques']['interes_fijo'] === "") ? NULL : $jsondata['dades_economiques']['interes_fijo'];

        $sql = 'UPDATE hipotecas SET '
        .'nif = "'.$jsondata['nif'].'", '
        .'nombre = "'.$jsondata['nombre'].'", '
        .'ape1 = "'.$jsondata['ape1'].'", '
        .'ape2 = "'.$jsondata['ape1'].'", '
        .'edad = '.$jsondata['edad'].', '
        .'telefono = '.$jsondata['telefono'].', '
        .'email = "'.$jsondata['email'].'", '
        .'ingresos_mensuales = '.$jsondata['dades_economiques']['ingresos_mensuales'].', '
        .'capital = '.$jsondata['dades_economiques']['capital'].', '
        .'tipo_interes = "'.$jsondata['dades_economiques']['tipo_interes'].'", '
        .'euribor = '.$jsondata['dades_economiques']['euribor'].', '
        .'diferencial = '.$jsondata['dades_economiques']['diferencial'].', '
        .'interes_fijo = "'.$jsondata['dades_economiques']['interes_fijo'].'", '
        .'plazo_anyos = '.$jsondata['dades_economiques']['plazo_anyos'].', '
        .'producto_segurocasa = '.$jsondata['dades_economiques']['producto_segurocasa'].', '
        .'producto_nomina = '.$jsondata['dades_economiques']['producto_nomina'].', '
        .'producto_segurovida = '.$jsondata['dades_economiques']['producto_segurovida']
        .' WHERE nif="'.$jsondata['nif'].'"';

        $response = $this->db->ejecutar($sql);

        if($response){
          $jsondata['success'] = True;
          echo json_encode($jsondata);
          exit;
        }else{
          $error_DB['error_type'] = 500;
          $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
          echo json_encode($error_DB);
          exit;
        }

      }else{
        $error_DB['error_type'] = 400;
        $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
      }

    }

    public function delete()
    {
      if($_GET['id'] ){

        $sql = 'DELETE FROM hipotecas WHERE idHipoteca= "'.$_GET['id'].'"';
        $response = $this->db->ejecutar($sql);

        if($response){
          $jsondata['success'] = True;
          echo json_encode($jsondata);
          exit;
        }else{
          $error_DB['error_type'] = 500;
          $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
          echo json_encode($error_DB);
          exit;
        }

      }else{
        $error_DB['error_type'] = 500;
        $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
        echo json_encode($error_DB);
        exit;
      }
    }

}
