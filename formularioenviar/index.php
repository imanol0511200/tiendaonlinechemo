<?php
//Import PHPMailer
//Estos deben estar en la parte superior de su secuencia de comandos, no dentro de una función
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
session_start();
$idUsuario = $_SESSION['id'];
$resultados = "";
//Crear una instancia; pasar `true` permite excepciones
$mail = new PHPMailer(true);
include '../conexion.php';
$sql3 = "SELECT
usuario.user_correo
FROM
usuario
WHERE
usuario.id_usuario = $idUsuario";

$result3 = $conn->query($sql3);

while ($row = $result3->fetch_assoc()) {
  $correousuario = $row['user_correo'];
}

try {
    //configuracion del servidor
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Habilitar salida de depuración detallada
    $mail->isSMTP();                                            //Enviar usando SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Configurar el servidor SMTP para enviar a través
    $mail->SMTPAuth   = true;                                   //Habilitar autenticación SMTP
    $mail->Username   = 'imanolglesdhes@gmail.com';                     //SMTP correo
    $mail->Password   = 'rtppncemiuicrqyf';                               //SMTP contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Habilitar el cifrado TLS implícito
    $mail->Port       = 465;                                    //Puerto TCP para conectarse; use 587 si configuró `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('imanolglesdhes@gmail.com', 'ElecStore');
    $mail->addAddress($correousuario, 'ElecStore');     //Agregar un destinatario

    //Content
    $mail->isHTML(true);         
                            //Se envia el email en formato html
    $mail->Subject = 'Gracias por tu compra';
    
    
    
    $sql = "SELECT
    sum(detalles_venta.Precio_Unitario* 
    detalles_venta.Cantidad) as total
    FROM
    detalles_venta
    INNER JOIN
    ventas
    ON 
      detalles_venta.ID_Venta = ventas.ID_Venta
    INNER JOIN
    usuario
    ON 
      ventas.ID_Cliente = usuario.id_usuario
    WHERE
    ventas.ID_Cliente = $idUsuario AND
    ventas.status_venta = 0";
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
    
        $total= "<span class='fs-4'>Total: $" . $row["total"] . "</span>";
    }
    $sql = "SELECT
	productos.Nombre, 
	productos.Descripcion, 
	productos.Precio, 
	detalles_venta.Cantidad, 
	productos.Imagen,
    productos.ID_Producto, 
	detalles_venta.ID_Detalle_Venta
FROM
	usuario,
	ventas
	INNER JOIN
	detalles_venta
	ON 
		ventas.ID_Venta = detalles_venta.ID_Venta
	INNER JOIN
	productos
	ON 
		detalles_venta.ID_Producto = productos.ID_Producto
WHERE
	usuario.id_usuario = $idUsuario and status_venta = 0";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Mostrar los productos en una tabla
        $estructuratabla= "<table class='table table-striped-columns'>
                <tr>
                    <th>Nombre </th>
                    <th>Descripcion </th>
                    <th>Precio </th>
                    <th>Cantidad</th>
                </tr><tr>";
        
        // Iterar sobre los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
                 
                 $resultados .= "<tr><td>".$row['Nombre'] . '</td> <td>' . $row['Descripcion'] . '</td> <td>$ ' . $row['Precio'] .'</td> <td>' . $row['Cantidad'] ."</td></td>";

        }
        $fintabla="</table></br>";
    } else {
        echo "No se encontraron productos";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el valor seleccionado en el campo "localidad"
    $localidad = "<br><h3>Se enviaran los productos a la siguiente direccion
    </h3><br><h5>Localidad: ".$_POST['localidad']."</h5>";
    $codigo_postal = "<br><h5>codigo postal: ".$_POST['codigo_postal']."</h5>";
    $descripcion = "<br><h5>descripciond de la casa: ".$_POST['descripcion']."</h5>";
    // Realizar las operaciones necesarias con los datos recibidos
  
    // Ejemplo: Imprimir el valor de "localidad"
    echo "La localidad seleccionada es: " . $localidad;
  }

    $mail->Body = $estructuratabla.' '.$resultados.' '.$fintabla.' '.$total.' '.$localidad.' '.$codigo_postal.' '.$descripcion;
    $mail->CharSet = 'UTF-8';
    $mail->send();
    $sql = "call actualizarventa(1)";
        $result = $conn->query($sql);
    echo 'Message has been sent';
    header('location: ../index.php');
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>