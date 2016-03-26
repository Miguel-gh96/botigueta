<?php
//utilizar $_FILES['file'] no $_FILES['avatar'] por dropzone.js
function upload_files() {
    $error = "";
    $copiarFichero = false;
    $extensiones = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

    if(!isset($_FILES)) {
        $error .=  'No existe $_FILES <br>';
    }
    if(!isset($_FILES['file'])) {
        $error .=  'No existe $_FILES[file] <br>';
    }

    $imagen = $_FILES['file']['tmp_name'];
    $nom_fitxer= $_FILES['file']['name'];
    $mida_fitxer=$_FILES['file']['size'];
    $tipus_fitxer=$_FILES['file']['type'];
    $error_fitxer=$_FILES['file']['error'];

    if ($error_fitxer>0) { // El error 0 quiere decir que se subió el archivo correctamente
        switch ($error_fitxer){
            case 1: $error .=  'Fitxer major que upload_max_filesize <br>'; break;
            case 2: $error .=  'Fitxer major que max_file_size <br>';break;
            case 3: $error .=  'Fitxer només parcialment pujat <br>';break;
            //case 4: $error .=  'No has pujat cap fitxer <br>';break; //assignarem a l'us default-avatar
        }
    }


    ////////////////////////////////////////////////////////////////////////////
    if ($_FILES['file']['size'] > 55000 ){
        $error .=  "Large File Size <br>";
    }


    if ($_FILES['file']['name'] !== "") {
        ////////////////////////////////////////////////////////////////////////////
        @$extension = strtolower(end(explode('.', $_FILES['file']['name']))); // Obtenemos la extensión, en minúsculas para poder comparar
        if( ! in_array($extension, $extensiones)) {
            $error .=  'Sólo se permite subir archivos con estas extensiones: ' . implode(', ', $extensiones).' <br>';
        }
        ////////////////////////////////////////////////////////////////////////////
        if (!@getimagesize($_FILES['file']['tmp_name'])){
            $error .=  "Invalid Image File... <br>";
        }
        ////////////////////////////////////////////////////////////////////////////
        list($width, $height, $type, $attr) = @getimagesize($_FILES['file']['tmp_name']);
        if ($width > 400 || $height > 400){
            $error .=   "Maximum width and height exceeded. Please upload images below 400x400 px size <br>";
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    $upfile = MEDIA_PATH_ROOT.$_FILES['avatar']['name'];
    if (is_uploaded_file($_FILES['file']['tmp_name'])){
        if (is_file($_FILES['file']['tmp_name'])) {
            $idUnico = rand();
            $nombreFichero = $idUnico."-".$_FILES['file']['name'];
            $copiarFichero = true;
            // I use absolute route to move_uploaded_file because this happens when i run ajax
            $upfile = MEDIA_PATH_ROOT.$nombreFichero;
        }else{
                $error .=   "Invalid File...";
        }
    }

    $i=0;
    if ($error == "") {
        if ($copiarFichero) {
            if (!move_uploaded_file($_FILES['file']['tmp_name'],$upfile)) {
                $error .= "<p>Error al subir la imagen.</p>";
                return $return=array('resultado'=>false,'error'=>$error,'datos'=>"");
            }
            //We need edit $upfile because now i don't need absolute route.
            $upfile ='./backend/media/'.$nombreFichero;
            return $return=array('resultado'=>true , 'error'=>$error,'datos'=>$upfile);
        }
        if($_FILES['file']['error'] !== 0) { //Assignarem a l'us default-avatar
            $upfile = './backend/media/default-avatar.png';
            return $return=array('resultado'=>true,'error'=>$error,'datos'=>$upfile);
        }
    }else{
        return $return=array('resultado'=>false,'error'=>$error,'datos'=>"");
    }
}

function remove_files(){
	$name = $_POST["filename"];

  //we need split relative route in filename to obtain name img.
  $porciones = explode("/", $name);
  $name = $porciones[3];

	if(file_exists(MEDIA_PATH_ROOT.$name)){
		unlink(MEDIA_PATH_ROOT.$name);
		return true;
	}else{
		return false;
	}
}
