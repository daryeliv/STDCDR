<?php
// Configurar datos de acceso a la Base de datos
$host = "localhost";
$dbname = "cruzroja";
$dbuser = "sa";
$dbuserpass = "1234";

$dsn = "sqlsrv:Server=DESKTOP-K2UURMB\DARYEMYSQL;Database=cruzroja";
$dbuser;
$dbuserpass;

try {
  // Crear conexión a postgres
  $conn = new PDO($dsn, $dbuser, $dbuserpass);

  // Mostrar mensaje si la conexión es correcta
  if($conn){
    //echo "Conectado a la base correctamente!";
    echo "\n";
  }
} catch (PDOException $e) {
  // Si hay error en la conexión mostrarlo
  echo $e->getMessage();
}
?>
