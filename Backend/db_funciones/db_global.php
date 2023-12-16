<?php
function comenzarConexion($db = 0){
  ini_set('mssql.charset', 'utf-8');
  ini_set('memory_limit', '1024M');
  date_default_timezone_set('America/Mexico_City');

// Production
  if ($db == 0) {
    $DBName = "u842376912_exploring_test";
  } else {
    $DBName = $db;
  }

  $DBServer =  "localhost";
  $DBUser   =  "u842376912_root";
  $DBPass   =  "kw2=Ec6[q#Z9";
  

// TEST
  // if ($db == 0) {
  //   $DBName = "exploring";
  // } else {
  //   $DBName = $db;
  // }
  
  // $DBServer =  "localhost";
  // $DBUser   =  "root";
  // $DBPass   =  "";

  $dbConnect = new mysqli($DBServer, $DBUser, $DBPass, $DBName) or die("Connect failed: %s\n". $dbConnect -> error);

  $dbConnect->query("SET @@session.wait_timeout = 3600;");
  if($dbConnect->connect_error){
    die('Error de conexion: ' . $dbConnect->connect_error);
  }

  $dbConnect->query("SET NAMES 'utf8'");
  $dbConnect->autocommit(FALSE);

  return $dbConnect;
}


function cerrarConexion($dbConnect){
  mysqli_close($dbConnect);
}


?>
