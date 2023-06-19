<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Pricing example · Bootstrap v5.0</title>

    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
  </head>
  <body>
    <?php
  session_start();
  
    ?>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check" viewBox="0 0 16 16">
    <title>Check</title>
    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
  </symbol>
</svg>

<div class="container py-3">
  <header>
    <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img width="48" height="48" src="https://img.icons8.com/fluency/48/online-shop.png" alt="online-shop"/>
        <span class="fs-4">ElecStore</span>
      </a>

      <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
        

</nav>
    </div>
 </header>
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
      <h1 class="display-4 fw-normal">Articulos</h1>
    </div>
 

  <main>
  <div class='row-cols-md-12 text-center'> 


  <?php
  $idUsuario = $_SESSION['id'];
  include '../conexion.php';
  // Consulta a la base de datos
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
        echo "<table class='table table-striped-columns'>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Cantidad</th>
                </tr>";
        
        // Iterar sobre los resultados de la consulta
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Nombre"] . "</td>
                    <td>" . $row["Descripcion"] . "</td>
                    <td>" . $row["Precio"] . "</td>
                    <td><img width='40' height='40' src='". $row["Imagen"] ."'/></td>
                    <td>" . $row["Cantidad"] . "</td>
                    <td><a href='eliminar.php?idprod=".$row["ID_Detalle_Venta"] ."&idprod2=".$row["ID_Producto"]."'><img width='50' height='50' src='https://img.icons8.com/ios/50/delete--v1.png' alt='delete--v1'/></a></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron productos";
    }
}

  
  ?>
  </div>
    </main>
</div>

<footer>
    <div class="text-center">
<?php
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

    echo "<span class='fs-4'>Total: $" . $row["total"] . "</span>";
}


?>
      
      <br>
      <form action="index.php" method="POST">
    <label for="localidad">Localidad:</label>
    <select name="localidad" id="localidad">
    <option value="Jilotepec de Molina Enriquez">Jilotepec de Molina Enriquez</option>
    <option value="San Cristóbal Ecatepec">San Cristóbal Ecatepec</option>
  <option value="Ciudad Nezahualcóyotl">Ciudad Nezahualcóyotl</option>
  <option value="Naucalpan de Juárez">Naucalpan de Juárez</option>
  <option value="Ciudad de Tlalnepantla">Ciudad de Tlalnepantla</option>
  <option value="Chimalhuacán">Chimalhuacán</option>
  <option value="Toluca de Lerdo">Toluca de Lerdo</option>
  <option value="Ciudad López Mateos">Ciudad López Mateos</option>
  <option value="Cuautitlán Izcalli">Cuautitlán Izcalli</option>
  <option value="Xico">Xico</option>
  <option value="Ixtapaluca">Ixtapaluca</option>
  <option value="San Francisco Coacalco">San Francisco Coacalco</option>
  <option value="Ciudad Nicolás Romero">Ciudad Nicolás Romero</option>
  <option value="Ojo de Agua">Ojo de Agua</option>
  <option value="Buenavista">Buenavista</option>
  <option value="San Pablo de las Salinas">San Pablo de las Salinas</option>
  <option value="Chicoloapan de Juárez">Chicoloapan de Juárez</option>
  <option value="Chalco de Díaz Covarrubias">Chalco de Díaz Covarrubias</option>
  <option value="Naucalpan de Juárez (Interlomas)">Naucalpan de Juárez (Interlomas)</option>
  <option value="Cuautitlán">Cuautitlán</option>
  <option value="Texcoco de Mora">Texcoco de Mora</option>
  <option value="Tepexpan">Tepexpan</option>
  <option value="Los Reyes Acaquilpan">Los Reyes Acaquilpan</option>
  <option value="Fuentes del Valle">Fuentes del Valle</option>
  <option value="San Mateo Atenco">San Mateo Atenco</option>
  <option value="Tultepec">Tultepec</option>
  <option value="San Salvador Tizatlalli">San Salvador Tizatlalli</option>
  <option value="San Miguel Zinacantepec">San Miguel Zinacantepec</option>
  <option value="Teoloyucan">Teoloyucan</option>
  <option value="Zumpango de Ocampo">Zumpango de Ocampo</option>
  <option value="San Buenaventura">San Buenaventura</option>
  <option value="Melchor Ocampo">Melchor Ocampo</option>
  <option value="Tepotzotlán">Tepotzotlán</option>
  <option value="Colonia Santa Teresa">Colonia Santa Teresa</option>
  <option value="San Jerónimo Cuatro Vientos">San Jerónimo Cuatro Vientos</option>
  <option value="Coyotepec">Coyotepec</option>
  <option value="San Martín Azcatepec">San Martín Azcatepec</option>
  <option value="San Pablo Autopan">San Pablo Autopan</option>
  <option value="San Isidro">San Isidro</option>
  <option value="Tultitlán de Mariano Escobedo">Tultitlán de Mariano Escobedo</option>
  <option value="Amecameca de Juárez">Amecameca de Juárez</option>
  <option value="San José Guadalupe Otzacatipan">San José Guadalupe Otzacatipan</option>
  <option value="Metepec">Metepec</option>
  <option value="San Francisco Acuautla">San Francisco Acuautla</option>
  <option value="La Magdalena Atlicpac">La Magdalena Atlicpac</option>
  <option value="San Jerónimo Chicahualco">San Jerónimo Chicahualco</option>
  <option value="Ocoyoacac">Ocoyoacac</option>
  <option value="Tejupilco">Tejupilco</option>
  <option value="Valle de Bravo">Valle de Bravo</option>
  <option value="Emiliano Zapata (La Paz)">Emiliano Zapata (La Paz)</option>
  <option value="San Francisco Coaxusco">San Francisco Coaxusco</option>
  <option value="San Martín Cuautlalpan">San Martín Cuautlalpan</option>
  <option value="Teotihuacán de Arista">Teotihuacán de Arista</option>
  <option value="Jesús del Monte">Jesús del Monte</option>
  <option value="San Jorge Pueblo Nuevo">San Jorge Pueblo Nuevo</option>
  <option value="Atlacomulco de Fabela">Atlacomulco de Fabela</option>
  <option value="Lerma de Villada">Lerma de Villada</option>
  <option value="Santiago Tequixquiac">Santiago Tequixquiac</option>
  <option value="San Mateo Otzacatipan">San Mateo Otzacatipan</option>
  <option value="San Miguel Coatlinchán">San Miguel Coatlinchán</option>
  <option value="Los Reyes Acozac">Los Reyes Acozac</option>
  <option value="Tenango de Arista">Tenango de Arista</option>
  <option value="Chiconcuac de Juárez">Chiconcuac de Juárez</option>
  <option value="San Pedro Totoltepec">San Pedro Totoltepec</option>
  <option value="San Rafael">San Rafael</option>
  <option value="Capulhuac de Mirafuentes">Capulhuac de Mirafuentes</option>
  <option value="Xonacatlán">Xonacatlán</option>
  <option value="San Juan Zitlaltepec">San Juan Zitlaltepec</option>
  <option value="San Andrés Cuexcontitlán">San Andrés Cuexcontitlán</option>
  <option value="Santa María Ajoloapan (Tecámac)">Santa María Ajoloapan (Tecámac)</option>
  <option value="Ixtapan de la Sal">Ixtapan de la Sal</option>
  <option value="Santiago Teyahualco">Santiago Teyahualco</option>
  <option value="San José Huilango">San José Huilango</option>
  <option value="San Salvador Atenco">San Salvador Atenco</option>
  <option value="Tezoyuca">Tezoyuca</option>
  <option value="Ozumba de Alzate">Ozumba de Alzate</option>
  <option value="San Francisco Tlalcilalcalpan">San Francisco Tlalcilalcalpan</option>
  <option value="San Antonio Acahualco">San Antonio Acahualco</option>
  <option value="Ampliación San Mateo (Colonia Solidaridad)">Ampliación San Mateo (Colonia Solidaridad)</option>
  <option value="Juchitepec de Mariano Riva Palacio">Juchitepec de Mariano Riva Palacio</option>
  <option value="Tecámac de Felipe Villanueva">Tecámac de Felipe Villanueva</option>
  <option value="Santiago Tlacotepec">Santiago Tlacotepec</option>
  <option value="Santa María Tulantongo">Santa María Tulantongo</option>
  <option value="San Mateo Huitzilzingo">San Mateo Huitzilzingo</option>
  <option value="Alborada Jaltenco">Alborada Jaltenco</option>
  <option value="Fraccionamiento Social Progresivo Santo Tomás Chiconautla">Fraccionamiento Social Progresivo Santo Tomás Chiconautla</option>
  <option value="Xalatlaco">Xalatlaco</option>
  <option value="Santa Ana Nextlalpan">Santa Ana Nextlalpan</option>
  <option value="Tlalmanalco de Velázquez">Tlalmanalco de Velázquez</option>
  <option value="Tenancingo de Degollado">Tenancingo de Degollado</option>
  <option value="Apaxco de Ocampo">Apaxco de Ocampo</option>
  <option value="Santa María Atarasquillo">Santa María Atarasquillo</option>
  <option value="San Pedro Tultepec">San Pedro Tultepec</option>
  <option value="Tepetlixpa">Tepetlixpa</option>
  <option value="Santiago Tianguistenco de Galeana">Santiago Tianguistenco de Galeana</option>
  <option value="Veintidós de Febrero">Veintidós de Febrero</option>
  <option value="San Sebastián Chimalpa">San Sebastián Chimalpa</option>
  <option value="San Martín de las Pirámides">San Martín de las Pirámides</option>
  <option value="Temascalcingo de José María Velasco">Temascalcingo de José María Velasco</option>
  <option value="San Antonio la Isla">San Antonio la Isla</option>
  <option value="Santa María Huexcoluco">Santa María Huexcoluco</option>
  <option value="Lomas de San Sebastián">Lomas de San Sebastián</option>
  <option value="Villa Santiago Cuautlalpan">Villa Santiago Cuautlalpan</option>
  <option value="San Juan de las Huertas">San Juan de las Huertas</option>
  <option value="San Francisco Zentlalpan">San Francisco Zentlalpan</option>
  <option value="Xico (Tejupilco)">Xico (Tejupilco)</option>
  <option value="San Miguel Ameyalco">San Miguel Ameyalco</option>
  <option value="Santa Cruz Tecamac">Santa Cruz Tecamac</option>
  <option value="Atizapán de Zaragoza">Atizapán de Zaragoza</option>
  <option value="San Miguel Tlaixpan">San Miguel Tlaixpan</option>
  <option value="Chiautla">Chiautla</option>
  <option value="Tlalnepantla de Baz">Tlalnepantla de Baz</option>
  <option value="San Mateo Texcalyacac">San Mateo Texcalyacac</option>
  <option value="Tejupilco de Hidalgo">Tejupilco de Hidalgo</option>
  <option value="San Miguel Tecuiciapan">San Miguel Tecuiciapan</option>
  <option value="Loma Bonita Xicotencatl">Loma Bonita Xicotencatl</option>
  <option value="San Lorenzo Cuauhtenco">San Lorenzo Cuauhtenco</option>
  <option value="Texcalyacac">Texcalyacac</option>
  <option value="Santa María Totoltepec">Santa María Totoltepec</option>
  <option value="San Miguel el Alto">San Miguel el Alto</option>
  <option value="Ampliación San Francisco (San Francisco Tlalnepantla)">Ampliación San Francisco (San Francisco Tlalnepantla)</option>
  <option value="Tecámac de Felipe Villanueva (Ozumbilla)">Tecámac de Felipe Villanueva (Ozumbilla)</option>
  <option value="San Martín Tepetlixpan">San Martín Tepetlixpan</option>
  <option value="Santa Cruz del Monte">Santa Cruz del Monte</option>
  <option value="Santa María Huecatitla">Santa María Huecatitla</option>
  <option value="Santa María Nativitas">Santa María Nativitas</option>
  <option value="San Andrés Atenco">San Andrés Atenco</option>
  <option value="Ampliación San Mateo (San Mateo Mexicaltzingo)">Ampliación San Mateo (San Mateo Mexicaltzingo)</option>
  <option value="San Marcos Huixtoco">San Marcos Huixtoco</option>
  <option value="San José el Vidrio">San José el Vidrio</option>
  <option value="Tlatlaya">Tlatlaya</option>
  <option value="San Francisco Chimalpa">San Francisco Chimalpa</option>
  <option value="San Pablo Tecalco">San Pablo Tecalco</option>
  <option value="San Martín de las Pirámides (San Martín Xochinahuac)">San Martín de las Pirámides (San Martín Xochinahuac)</option>
  <option value="Santa María Jajalpa">Santa María Jajalpa</option>
  <option value="Santa María Mazatla">Santa María Mazatla</option>
  <option value="Santa María Ixtulco">Santa María Ixtulco</option>
  <option value="San Mateo Tezoquipan">San Mateo Tezoquipan</option>
  <option value="San Felipe Teotlalcingo">San Felipe Teotlalcingo</option>
  <option value="Santa María Rayón">Santa María Rayón</option>
  <option value="San Mateo Ixtacalco">San Mateo Ixtacalco</option>
  <option value="Santa María Nenetzintla">Santa María Nenetzintla</option>
  <option value="San Felipe Hueyotlipan">San Felipe Hueyotlipan</option>
  <option value="San Cristóbal Huichochitlán">San Cristóbal Huichochitlán</option>
  <option value="Santa María la Alta">Santa María la Alta</option>
  <option value="San Andrés Tlalamac">San Andrés Tlalamac</option>
  <option value="Santa María del Monte">Santa María del Monte</option>
  <option value="San Juan Tejalpa">San Juan Tejalpa</option>
  <option value="San Pedro Tlalcuapan">San Pedro Tlalcuapan</option>
  <option value="San Andrés Tizapa">San Andrés Tizapa</option>
  <option value="Santa María Xochitepec">Santa María Xochitepec</option>
  <option value="San Francisco Ayotuzco">San Francisco Ayotuzco</option>
  <option value="Santa María Nativitas (Zacualpan)">Santa María Nativitas (Zacualpan)</option>
  <option value="San Mateo Cuautepec">San Mateo Cuautepec</option>
  <option value="Santa María Polanco">Santa María Polanco</option>
  <option value="San Nicolás Totolapan">San Nicolás Totolapan</option>
  <option value="Santa María Jajalpa (Tequexquinahuac)">Santa María Jajalpa (Tequexquinahuac)</option>
  <option value="Santa María Xonacatlán">Santa María Xonacatlán</option>
  <option value="San Mateo Teolocholco">San Mateo Teolocholco</option>
  <option value="San Miguel Zinacantepec">San Miguel Zinacantepec</option>
  <option value="San Mateo Otzacatipan (La Concepción)">San Mateo Otzacatipan (La Concepción)</option>
  <option value="Santa María Ixtulco (Santa María Atlihuetzia)">Santa María Ixtulco (Santa María Atlihuetzia)</option>
  <option value="San Mateo Almomoloa">San Mateo Almomoloa</option>
  <option value="San Jerónimo Acazulco">San Jerónimo Acazulco</option>
  <option value="Santa María Tlapacoya">Santa María Tlapacoya</option>
  <option value="Santa María Atzompa">Santa María Atzompa</option>
  <option value="San Miguel Topilejo">San Miguel Topilejo</option>
  <option value="San Mateo Tlalchichilpan">San Mateo Tlalchichilpan</option>
  <option value="Santa María Totoltepec (Calimaya)">Santa María Totoltepec (Calimaya)</option>
  <option value="Santa María Xigui">Santa María Xigui</option>
  <option value="San Marcos Tlacoyalco">San Marcos Tlacoyalco</option>
  <option value="San Nicolás Buenos Aires">San Nicolás Buenos Aires</option>
  <option value="San José Tepuzas">San José Tepuzas</option>
  <option value="San Lorenzo Chiautzingo">San Lorenzo Chiautzingo</option>
  <option value="Santa María Ayotuzco">Santa María Ayotuzco</option>
  <option value="San Pedro Zictepec">San Pedro Zictepec</option>
  <option value="San Miguel Almoloyan">San Miguel Almoloyan</option>
  <option value="San Martín Coapaxtongo">San Martín Coapaxtongo</option>
  <option value="Santa María Yolotepec">Santa María Yolotepec</option>
  <option value="San José Temascatío">San José Temascatío</option>
  <option value="San Pablo Autopan">San Pablo Autopan</option>
    </select>
    <br><br>
    <label for="codigo_postal">Código Postal:</label>
    <input type="text" name="codigo_postal" id="codigo_postal">
    <br><br>
    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" id="descripcion">
    <br><br>
      <button type="submit" class="btn btn-dark" data-bs-toggle="modal">
        Enviar Comprobante
      </button>
  </form>
      

    </div>

  </footer>

    
  </body>
</html>
