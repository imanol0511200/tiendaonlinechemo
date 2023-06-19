<?php
if (isset($_REQUEST['idprod'])) {
    $idprod = $_REQUEST['idprod'];
    $idprod2 = $_REQUEST['idprod2'];
    include '../conexion.php';
  // Consulta a la base de datos
  $sql = "DELETE FROM `tiendaonline`.`detalles_venta` WHERE `ID_Detalle_Venta` = $idprod";
  $result = $conn->query($sql);
  //agregar uno al stock
  $sql = "UPDATE productos 
  set Stock = Stock+1
  WHERE ID_Producto = $idprod2;";
  $result = $conn->query($sql);

header('location: enviar.php');
    
} else {
    // El campo "nombre" no se envió en el formulario
    echo "Error: El campo 'producto' no se envió en el formulario.";
}
?>