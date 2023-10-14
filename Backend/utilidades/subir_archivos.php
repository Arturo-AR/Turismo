<?php

function subirArchivo($extensionesValidas, $archivo, $nombreArchivo, $ruta){
    $resultado      = false;
    $fileName       = $archivo["name"];
    $fileSize       = $archivo["size"];
    $fileTmp        = $archivo["tmp_name"];
    $fileType       = $archivo["type"];
    $posFile        = explode(".", $fileName);
    $fileExt        = strtolower(end($posFile));

    

    $pathNameFile = $ruta.$nombreArchivo.'.'.$fileExt;


    if(in_array($fileExt, $extensionesValidas) === true){
        $archivoCargado  = move_uploaded_file($fileTmp,$pathNameFile);
    }

    if($archivoCargado){
        $resultado = true;
    }

    return $resultado;
}


?>
