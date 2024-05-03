<?php
// ARCHIVOS
require("errores.php");
require("funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

sesionN1();
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denegado</title>
 </head>
 <body>
    <h1>Caca bolivia!</h1>
    <form action="#" method="post" class="form">
      <input type="submit" value="Cerrar Sesión" class="btn btn-primary form-control" name="cerses">
   </form>
    <p>No eres admin, mongolo</p>
 </body>
 </html>