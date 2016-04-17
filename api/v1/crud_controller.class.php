<?php

class crud_controller
{
    public function __construct()
    {
        require_once $_SERVER['DOCUMENT_ROOT'].'hipoteca/api/v1/hipoteca_validation.php';
        $_SESSION['module'] = 'crud';
        $this->db = db::getInstance();
    }

    public function get_all()
    {
        $sql = 'SELECT * FROM hipotecas';
        $stmt = $this->db->ejecutar($sql);
        $response = $this->db->listar($stmt);

        if ($response) {
            foreach ($response as $key => $value) {
                $jsondata['data'][$key]['idHipoteca'] = $value['idHipoteca'];
                $jsondata['data'][$key]['nif'] = $value['nif'];
                $jsondata['data'][$key]['nombre'] = $value['nombre'];
                $jsondata['data'][$key]['ape1'] = $value['ape1'];
                $jsondata['data'][$key]['ape2'] = $value['ape2'];
                $jsondata['data'][$key]['edad'] = intval($value['edad']);
                $jsondata['data'][$key]['telefono'] = $value['telefono'];
                $jsondata['data'][$key]['email'] = $value['email'];
                $jsondata['data'][$key]['dades_economiques']['ingresos_mensuales'] = intval($value['ingresos_mensuales']);
                $jsondata['data'][$key]['dades_economiques']['capital'] = intval($value['capital']);
                $jsondata['data'][$key]['dades_economiques']['tipo_interes'] = $value['tipo_interes'];
                $jsondata['data'][$key]['dades_economiques']['euribor'] = floatval($value['euribor']);
                $jsondata['data'][$key]['dades_economiques']['diferencial'] = floatval($value['diferencial']);
                $jsondata['data'][$key]['dades_economiques']['interes_fijo'] = floatval($value['interes_fijo']);
                $jsondata['data'][$key]['dades_economiques']['plazo_anyos'] = intval($value['plazo_anyos']);
                $jsondata['data'][$key]['dades_economiques']['producto_segurocasa'] = ($value['producto_segurocasa']) ? true : false;
                $jsondata['data'][$key]['dades_economiques']['producto_nomina'] = ($value['producto_nomina']) ? true : false;
                $jsondata['data'][$key]['dades_economiques']['producto_segurovida'] = ($value['producto_segurovida']) ? true : false;
            }
            $jsondata['success'] = true;
            echo json_encode($jsondata);
            exit;
        } else {
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
    }

    public function get()
    {
        if ($_GET['id']) {

            $sql = 'SELECT * FROM hipotecas WHERE idHipoteca="'.$_GET['id'].'"';
            $stmt = $this->db->ejecutar($sql);
            $response = $this->db->listar($stmt);

            if ($response[0]) {
                $value = $response[0];

                $jsondata['data']['idHipoteca'] = $value['idHipoteca'];
                $jsondata['data']['nif'] = $value['nif'];
                $jsondata['data']['nombre'] = $value['nombre'];
                $jsondata['data']['ape1'] = $value['ape1'];
                $jsondata['data']['ape2'] = $value['ape2'];
                $jsondata['data']['edad'] = intval($value['edad']);
                $jsondata['data']['telefono'] = $value['telefono'];
                $jsondata['data']['email'] = $value['email'];
                $jsondata['data']['dades_economiques']['ingresos_mensuales'] = intval($value['ingresos_mensuales']);
                $jsondata['data']['dades_economiques']['capital'] = intval($value['capital']);
                $jsondata['data']['dades_economiques']['tipo_interes'] = $value['tipo_interes'];
                $jsondata['data']['dades_economiques']['euribor'] = floatval($value['euribor']);
                $jsondata['data']['dades_economiques']['diferencial'] = floatval($value['diferencial']);
                $jsondata['data']['dades_economiques']['interes_fijo'] = floatval($value['interes_fijo']);
                $jsondata['data']['dades_economiques']['plazo_anyos'] = intval($value['plazo_anyos']);
                $jsondata['data']['dades_economiques']['producto_segurocasa'] = ($value['producto_segurocasa']) ? true : false;
                $jsondata['data']['dades_economiques']['producto_nomina'] = ($value['producto_nomina']) ? true : false;
                $jsondata['data']['dades_economiques']['producto_segurovida'] = ($value['producto_segurovida']) ? true : false;
                $jsondata['success'] = true;
                echo json_encode($jsondata);
                exit;
            } else {
                $error_DB['error_type'] = 500;
                $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
                echo json_encode($error_DB);
                exit;
            }
        } else {
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
    }

    public function add()
    {
        if ($_POST['data']) {
            $validate = hipoteca_validate($_POST['data']);

            if ($validate['resultado'] === true) {
                $jsondata = $_POST['data'];

                $jsondata['dades_economiques']['producto_segurocasa'] = ($jsondata['dades_economiques']['producto_segurocasa']) ? 1 : 0;
                $jsondata['dades_economiques']['producto_nomina'] = ($jsondata['dades_economiques']['producto_nomina']) ? 1 : 0;
                $jsondata['dades_economiques']['producto_segurovida'] = ($jsondata['dades_economiques']['producto_segurovida']) ? 1 : 0;
                $jsondata['dades_economiques']['euribor'] = ($jsondata['dades_economiques']['euribor'] === '') ? null : $jsondata['dades_economiques']['euribor'];
                $jsondata['dades_economiques']['diferencial'] = ($jsondata['dades_economiques']['diferencial'] === '') ? null : $jsondata['dades_economiques']['diferencial'];
                $jsondata['dades_economiques']['interes_fijo'] = ($jsondata['dades_economiques']['interes_fijo'] === '') ? null : $jsondata['dades_economiques']['interes_fijo'];
                $jsondata['idHipoteca'] = mt_rand(10, 10000);

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

                if ($response) {
                    $jsondata['success'] = true;
                    echo json_encode($jsondata);
                    exit;
                } else {
                    $error_DB['error_type'] = 500;
                    $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
                    echo json_encode($error_DB);
                    exit;
                }
            } else {
              $error['error'] = $validate['error'];
              $error['success'] = false;
              echo json_encode($error);
              exit;
            }
        } else {
            $error_DB['error_type'] = 400;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
    }

    public function set()
    {
        if ($_POST['data']) {
            $validate = hipoteca_validate($_POST['data']);

            if ($validate['resultado']) {
                $jsondata = $_POST['data'];

                $jsondata['dades_economiques']['producto_segurocasa'] = ($jsondata['dades_economiques']['producto_segurocasa']) ? 1 : 0;
                $jsondata['dades_economiques']['producto_nomina'] = ($jsondata['dades_economiques']['producto_nomina']) ? 1 : 0;
                $jsondata['dades_economiques']['producto_segurovida'] = ($jsondata['dades_economiques']['producto_segurovida']) ? 1 : 0;
                $jsondata['dades_economiques']['euribor'] = ($jsondata['dades_economiques']['euribor'] === '') ? null : $jsondata['dades_economiques']['euribor'];
                $jsondata['dades_economiques']['diferencial'] = ($jsondata['dades_economiques']['diferencial'] === '') ? null : $jsondata['dades_economiques']['diferencial'];
                $jsondata['dades_economiques']['interes_fijo'] = ($jsondata['dades_economiques']['interes_fijo'] === '') ? null : $jsondata['dades_economiques']['interes_fijo'];

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

                if ($response) {
                    $jsondata['success'] = true;
                    echo json_encode($jsondata);
                    exit;
                } else {
                    $error_DB['error_type'] = 500;
                    $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
                    echo json_encode($error_DB);
                    exit;
                }
            } else {
                $error['error'] = $validate['error'];
                $error['success'] = false;
                echo json_encode($error);
                exit;
            }
        } else {
            $error_DB['error_type'] = 400;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
    }

    public function delete()
    {
        if ($_GET['id']) {

            $sql = 'DELETE FROM hipotecas WHERE idHipoteca= "'.$_GET['id'].'"';
            $response = $this->db->ejecutar($sql);

            if ($response) {
                $jsondata['success'] = true;
                echo json_encode($jsondata);
                exit;
            } else {
                $error_DB['error_type'] = 500;
                $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
                echo json_encode($error_DB);
                exit;
            }
        } else {
            $error_DB['error_type'] = 500;
            $error_DB['error_message'] = 'Ha habido un problema, intentalo más tarde';
            echo json_encode($error_DB);
            exit;
        }
    }
}
