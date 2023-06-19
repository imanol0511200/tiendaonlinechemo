<?php
$servername = "tiendaonline2.mysql.database.azure.com";
$username = "Imanol";
$password = "@Piripitiflautica123";
$dbname = "tiendaonline";

// Establecer la conexión con SSL
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect($conn, $servername, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);
if (mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}


//echo "Conexión exitosa";

// Cerrar conexión
//$conn->close();
?>
