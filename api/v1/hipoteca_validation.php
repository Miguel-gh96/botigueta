<?php

function hipoteca_validate($value)
{

    $error = array();
    $valido = true;
    $filtro = array(
        'nif' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/(^[X-Z]\d{7}[A-Z]$)|(^\d{8}[A-Z]$)/'),
        ),
        'nombre' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[A-Za-z-á-é-í-ó-ú\s]{2,30}$/'),
        ),
        'ape1' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[A-Za-z-á-é-í-ó-ú\s]{2,30}$/'),
        ),
        'ape2' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[A-Za-z-á-é-í-ó-ú\s]{2,30}$/'),
        ),
        'edad' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[1-9]\d*$/'),
        ),
        'telefono' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[9|8|7|6]\d{8}$/'),
        ),
        'email' => array(
            'filter' => FILTER_CALLBACK,
            'options' => 'valida_email',
        ),
    );

    $resultado = filter_var_array($value, $filtro);

    $filtro_dades_economiques = array(
        'ingresos_mensuales' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
        'capital' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
        'euribor' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
        'diferencial' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
        'interes_fijo' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
        'plazo_anyos' => array(
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' => '/^[0-9]\d*(\.\d+)?$/'),
        ),
    );

    $resultado2 = filter_var_array($value['dades_economiques'],$filtro_dades_economiques);



    if ($resultado != '' && $resultado) {
        if (!$resultado['nif']) {
            $error['nif'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado['nombre']) {
            $error['nombre'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado['ape1']) {
            $error['ape1'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado['email']) {
            $error['email'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado2['ingresos_mensuales']) {
            $error['ingresos_mensuales'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado2['capital']) {
            $error['capital'] = 'Error en el campo.';
            $valido = false;
        }

        if (!$resultado2['plazo_anyos']) {
            $error['plazo_anyos'] = 'Error en el campo.';
            $valido = false;
        }

        if ($value['euribor'] != ''){
          if (!$resultado2['euribor']) {
              $error['euribor'] = 'Error en el campo.';
              $valido = false;
          }
        }

        if ($value['diferencial'] != ''){
          if (!$resultado2['diferencial']) {
              $error['diferencial'] = 'Error en el campo.';
              $valido = false;
          }
        }

        if ($value['interes_fijo'] != ''){
          if (!$resultado2['interes_fijo']) {
              $error['interes_fijo'] = 'Error en el campo.';
              $valido = false;
          }
        }

        if ($value['ape2'] != ''){
          if (!$resultado['ape2']) {
              $error['ape2'] = 'Error en el campo.';
              $valido = false;
          }
        }

        if ($value['edad'] != ''){
          if (!$resultado['edad']) {
              $error['edad'] = 'Error en el campo.';
              $valido = false;
          }
        }

        if ($value['telefono'] != ''){
          if (!$resultado['telefono']) {
              $error['telefono'] = 'Error en el campo.';
              $valido = false;
          }
        }

    } else {
        $valido = false;
    };

    $datos = array_merge( $resultado,  $resultado2);
    return $return = array('resultado' => $valido, 'error' => $error, 'datos' => $datos);
}

function valida_dates($start_days, $dayslight)
{
    $start_day = date('m/d/Y', strtotime($start_days));
    $daylight = date('m/d/Y', strtotime($dayslight));

    list($mes_one, $dia_one, $anio_one) = split('/', $start_day);
    list($mes_two, $dia_two, $anio_two) = split('/', $daylight);

    $dateOne = new DateTime($anio_one.'-'.$mes_one.'-'.$dia_one);
    $dateTwo = new DateTime($anio_two.'-'.$mes_two.'-'.$dia_two);

    if ($dateOne <= $dateTwo) {
        return true;
    }

    return false;
}

//validate email
function valida_email($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (filter_var($email, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^.{5,50}$/')))) {
            return $email;
        }
    }

    return false;
}

function validate_town($town)
{
    $town = filter_var($town, FILTER_SANITIZE_STRING);

    return $town;
}
