<?php
// ARCHIVOS
require("../php/errores.php");
require("../php/funciones.php");

// CONEXION
$conn = conectarBBDD();

// VARIABLES
$mensaje = '';

// Verificar si hay una sesión iniciada
sesionN1();

//---INSERT---//
$idUsuario = obtenerIDUsuario();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Dieta</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body,
        html {
            height: 100%;
        }

        .content {
            min-height: calc(100vh - 76px - 56px);
        }

        .content {
            flex: 1;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .column {
            width: 45%;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .comida-container {
            margin-bottom: 20px;
        }

        .comida-container.hidden {
            display: none;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #fff;
        }

        .search-box {
            position: relative;
        }

        .search-results {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }

        .search-results div {
            padding: 10px;
            cursor: pointer;
        }

        .search-results div:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #006691;">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img class="rounded" src="../media/logoancho.png" alt="logo" width="155">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <?php
                if (sesionN0()) {
                    // El usuario ha iniciado sesión

                    // Verificar si el usuario es administrador
                    $conexion = conectarBBDD();
                    $nombre_usuario = $_SESSION["correoElectronicoUsuario"];
                    $sql = "SELECT idRolFK FROM usuarios WHERE correoElectronicoUsuario = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("s", $nombre_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $fila = $result->fetch_assoc();
                    $administrador = $fila["idRolFK"];
                    $stmt->close();
                    $conexion->close();

                    $nombre_usuario = obtenerNombreUsuario();
                    $ruta_imagen = obtenerRutaImagenUsuario();
                    echo '
                        <ul class="ms-auto m-2 navbar-nav">
                            <li class="border border-dark rounded dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <img class="rounded-circle" src="../' . $ruta_imagen . '" width="65" alt="Foto de Perfil">
                                    Bienvenido: <span class="fw-bold">' . $nombre_usuario . '</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../perfil.php">Mi Perfil</a></li>';
                    if ($administrador == 1) {
                        echo '<li><a class="dropdown-item" href="../administracion/indexadmin.php">Panel de Control</a></li>';
                    }
                    echo '       
                                    <form method="post">
                                        <input type="hidden" name="cerses" value="true">
                                        <button type="submit" class="dropdown-item">Cerrar Sesión
                                        </button>
                                        </form>
                                    </ul>
                                </li>
                            </ul>';
                } else {
                    echo '
                            <article class="ms-auto">
                                <h2 hidden>Inicio sesión</h2>
                                <form class="d-flex align-items-center" method="post">
                                    <div class="">
                                        <a class="btn btn-primary" href="../php/login.php">Iniciar Sesion</a>
                                        <a class="btn btn-primary" href="../php/registro.php">Registrarse</a>
                                    </div>
                                </form>
                            </article>';
                }
                ?>
            </div>
        </div>
    </nav>
    <main class="content container">
        <div class="column">
            <h1>Añadir Dieta</h1>
            <div class="mb-3">
                <label for="nombreDieta" class="form-label">Nombre de la dieta:</label>
                <input type="text" class="form-control" id="nombreDieta" placeholder="Nombre de la dieta">
            </div>
            <div class="mb-3">
                <label for="tipoDieta" class="form-label">Tipo de dieta:</label>
                <input type="text" class="form-control" id="tipoDieta" placeholder="Tipo de dieta">
            </div>
            <div class="mb-3">
                <label for="numComidas" class="form-label">Número de comidas:</label>
                <input type="number" class="form-control" id="numComidas" min="1" max="6" onchange="actualizarNumComidas()">
            </div>
            <div id="comidas">
                <!-- Contenedores de Comida -->
            </div>
            <button type="button" class="btn btn-primary" onclick="guardarDieta()">Guardar</button>

            <div id="comidas">
                <div class="comida-container hidden" id="comida-1">
                    <div>
                        <h3>Comida 1</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 1)">
                            <div class="search-results" id="search-results-1"></div>
                        </div>
                        <div id="productosSeleccionados1"></div>
                    </div>
                </div>
                <div class="comida-container hidden" id="comida-2">
                    <div>
                        <h3>Comida 2</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 2)">
                            <div class="search-results" id="search-results-2"></div>
                        </div>
                        <div id="productosSeleccionados2"></div>
                    </div>
                </div>
                <div class="comida-container hidden" id="comida-3">
                    <div>
                        <h3>Comida 3</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 3)">
                            <div class="search-results" id="search-results-3"></div>
                        </div>
                        <div id="productosSeleccionados3"></div>
                    </div>
                </div>
                <div class="comida-container hidden" id="comida-4">
                    <div>
                        <h3>Comida 4</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 4)">
                            <div class="search-results" id="search-results-4"></div>
                        </div>
                        <div id="productosSeleccionados4"></div>
                    </div>
                </div>
                <div class="comida-container hidden" id="comida-5">
                    <div>
                        <h3>Comida 5</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 5)">
                            <div class="search-results" id="search-results-5"></div>
                        </div>
                        <div id="productosSeleccionados5"></div>
                    </div>
                </div>
                <div class="comida-container hidden" id="comida-6">
                    <div>
                        <h3>Comida 6</h3>
                        <div class="search-box">
                            <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, 6)">
                            <div class="search-results" id="search-results-6"></div>
                        </div>
                        <div id="productosSeleccionados6"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <!-- CONTENIDO A LA DERECHA -->
        </div>
    </main>
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2023 Centro Deportivo. Todos los derechos reservados.</p>
        <a href="#">Aviso Legal</a> | <a href="#">Política de Privacidad</a> | <a href="#">Cookies</a>
    </footer>
    <script>
        let productos = [];

        function inicializarPagina() {
            fetch('obtener_productos.php')
                .then(response => response.json())
                .then(data => {
                    productos = data;
                });

            document.addEventListener('click', function(event) {
                const searchResultsContainers = document.querySelectorAll('.search-results');
                searchResultsContainers.forEach(container => {
                    if (!container.contains(event.target) && !container.previousElementSibling.contains(event.target)) {
                        container.innerHTML = '';
                    }
                });
            });
        }

        function buscarProducto(query, comidaIndex) {
            const resultsDiv = document.getElementById(`search-results-${comidaIndex}`);
            resultsDiv.innerHTML = '';
            if (query.length > 0) {
                const results = productos.filter(producto =>
                    producto.nombreProducto.toLowerCase().includes(query.toLowerCase())
                );

                results.forEach(producto => {
                    const resultDiv = document.createElement('div');
                    resultDiv.textContent = producto.nombreProducto;
                    resultDiv.onclick = () => seleccionarProducto(producto, comidaIndex);
                    resultsDiv.appendChild(resultDiv);
                });
            }
        }

        function seleccionarProducto(producto, comidaIndex) {
            const productosSeleccionadosDiv = document.getElementById(`productosSeleccionados${comidaIndex}`);
            const productoDiv = document.createElement('div');
            productoDiv.classList.add('producto-seleccionado');
            productoDiv.innerHTML = `
                <span>${producto.nombreProducto}</span>
                <input type="number" placeholder="Cantidad" class="form-control cantidad-producto" data-producto-id="${producto.idProducto}">
                <button class="btn btn-danger btn-sm" onclick="eliminarProducto(this)">Eliminar</button>
            `;
            productosSeleccionadosDiv.appendChild(productoDiv);

            document.getElementById(`search-results-${comidaIndex}`).innerHTML = '';
            document.querySelector(`#search-results-${comidaIndex}`).previousElementSibling.value = '';
        }

        function eliminarProducto(button) {
            button.parentElement.remove();
        }

        function actualizarNumComidas() {
            const numComidas = parseInt(document.getElementById('numComidas').value, 10);
            const comidaContainers = document.querySelectorAll('.comida-container');
            comidaContainers.forEach((container, index) => {
                if (index < numComidas) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            });
        }

        function guardarDieta() {
            const nombreDieta = document.getElementById('nombreDieta').value;
            const tipoDieta = document.getElementById('tipoDieta').value;
            const numComidas = parseInt(document.getElementById('numComidas').value, 10);

            let comidas = [];

            for (let i = 1; i <= numComidas; i++) {
                let productosSeleccionadosDiv = document.getElementById(`productosSeleccionados${i}`);
                let productos = productosSeleccionadosDiv.querySelectorAll('.producto-seleccionado');

                let comida = [];
                productos.forEach(productoDiv => {
                    let productoId = productoDiv.querySelector('.cantidad-producto').getAttribute('data-producto-id');
                    let productoCantidad = productoDiv.querySelector('.cantidad-producto').value;
                    comida.push({
                        idProducto: productoId,
                        cantidad: productoCantidad
                    });
                });

                comidas.push(comida);
            }

            let dieta = {
                nombreDieta,
                tipoDieta,
                numComidas,
                comidas
            };

            // Enviar los datos al servidor
            fetch('guardar_dieta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dieta)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Dieta guardada exitosamente.');
                    // Redirigir o limpiar el formulario si es necesario
                } else {
                    alert('Error al guardar la dieta.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', inicializarPagina);
    </script>
</body>

</html>
