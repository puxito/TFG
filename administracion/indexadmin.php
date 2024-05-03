<?php

// ARCHIVOS
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

sesionN2();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="../media/logo.png" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../estilos/menustyle.css">
  <title>FitFood</title>
</head>

<body>
  <header>
    <div>
      <p><img src="../media/logoancho.png"></p>
    </div>
    <div class="panel">
      <h1 class="display-6"><strong>Panel de Control</strong></h1>
    </div>
    <div class="perfil">
      <!-- Agrega contenido aquí si es necesario -->
    </div>
    </div>
  </header>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <article>
            <h2>Administración de Usuarios</h2>
            <p>Gestionar los usuarios del sitio web.</p>
            <a href="../cruds/crud_usuarios.php" class="btn btn-primary">Acceder</a>
          </article>
        </div>
        <div class="col-md-6">
          <article>
            <h2>Administración de Roles</h2>
            <p>Gestionar los roles de los usuarios.</p>
            <a href="#" class="btn btn-primary">Acceder</a>
          </article>
        </div>
        <div class="col-md-6">
          <article>
            <h2>Administración de Productos</h2>
            <p>Gestionar los usuarios del sitio web.</p>
            <a href="../cruds/crud_productos.php" class="btn btn-primary">Acceder</a>
          </article>
        </div>
        <div class="col-md-6">
          <article>
            <h2>Administración de Categorías</h2>
            <p>Gestionar las categorías de los productos.</p>
            <a href="#" class="btn btn-primary">Acceder</a>
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

</html>