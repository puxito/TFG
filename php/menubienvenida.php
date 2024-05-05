<?php
// ARCHIVOS
require("errores.php");
require("funciones.php");

// SESIÓN
session_start();

// CONEXIÓN
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar la sesión y el rol del usuario
$usu = sesionN1();

?>



<?php
// Obtener el rol del usuario
$correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
$sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoElectronicoUsuario);
$stmt->execute();
$result = $stmt->get_result();
$fila = $result->fetch_assoc();
$rol = $fila["idRolFK"];

// Zona de Administradores (rol = 1)
if ($rol == 1) {
   echo '
      <!DOCTYPE html>
         <html lang="es">

         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="icon" href="media/iconos/logo.png" type="image/x-icon" />
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="../estilos/menustyle.css">
         <title>FitFood</title>

         <body>
            <header>
               <div>
                  <p><img src="../media/logoancho.png"></p>
               </div>
               <div class="panel">
                  <h1 class="display-6"><strong>Bienvenido</strong></h1>
               </div>
               <div class="perfil">
                  <form action="#" method="post">
                     <input type="submit" value="Cerrar Sesión" name="cerses">
                  </form>
               </div>
               </div>
            </header>
               <section>
               <div class="container">
                  <div class="col">
                     <div class="col-md-6">
                        <article >
                           <h2>Panel de Control &#128736</h2>
                           <p>Acceso solo administradores</p>
                           <a href="../administracion/indexadmin.php" class="btn btn-primary">Acceder</a>
                        </article>
                     </div>
                  </div>
               </div>
               <div class="container">
                  <div class="col">
                     <div class="col-md-6">
                        <article>
                           <h2>Sitio Web</h2>
                           <p>Acceso General</p>
                           <a href="../index.php" class="btn btn-primary">Acceder</a>
                        </article>
                     </div>
                  </div>
               </div>
               </section>
               <footer>
               <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
            </footer>



            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
         </body>
         </html>';
}
?>


<?php
// Obtener el rol del usuario
$correoElectronicoUsuario = $_SESSION["correoElectronicoUsuario"];
$sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoElectronicoUsuario);
$stmt->execute();
$result = $stmt->get_result();
$fila = $result->fetch_assoc();
$rol = $fila["idRolFK"];

// Zona de Usuarios Clientes (rol = 3)
if ($rol == 3) {
   header("Location: ../index.php");
   exit();
}
?>


