<?php
function committedRolledbackDb($dbConnect, $array, $ejecutarDb, $objetoRespuesta, $mensaje) {
    //echo "|".$ejecutarDb."|";
    $hacer = true;

    /*for($i = 0; $i < count($array); $i++){
        if(!$array[$i]){
        $hacer = false;
        break;
        }
    }*/

    if ($dbConnect -> connect_errno) {
        echo "Failed to connect to MySQL: " . $dbConnect -> connect_error;
        exit();
    }

    if (!$dbConnect -> commit()) {
        echo "Commit transaction failed";
        exit();
    }
    if($hacer){
        if ($ejecutarDb) {
            $dbConnect->commit();
        }
        $respuesta = constructorRespuesta("exito", $mensaje, $objetoRespuesta);
    } else {
        if ($ejecutarDb) {
            $dbConnect->rollback();
            echo("No entre");
        }
        $respuesta = constructorRespuesta("fallo", $mensaje, $objetoRespuesta);
    }
    return $respuesta;
}
?>
