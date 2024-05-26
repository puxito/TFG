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

$idUsuario = obtenerIDUsuario();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Dieta</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+onE6pRhejjBo5S1a1Jo3t4H2y74p" crossorigin="anonymous"></script>
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
                <label for="observacionesDieta" class="form-label">Observaciones:</label>
                <input type="text" class="form-control" id="observacionesDieta" placeholder="Observaciones">
            </div>
            <div class="mb-3">
                <label for="numComidas" class="form-label">Número de comidas:</label>
                <input type="number" class="form-control" id="numComidas" min="1" max="10" onchange="actualizarNumComidas()">
            </div>
            <div id="comidas"></div>
            <button class="btn btn-primary" onclick="guardarDieta()">Guardar Dieta</button>
            <button class="btn btn-secondary" onclick="calcularValoresNutricionales()">Calcular Valores Nutricionales</button>
        </div>
        <div class="column" id="comidasGuardadas"></div>
    </main>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <p>&copy; 2024 FitFood. Todos los derechos reservados.</p>
                </div>
                <div class="col text-center">
                    <ul class="list-unstyled">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Servicios</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Variables globales para almacenar productos y comidas
        let productos = [];

        // Función para inicializar la página
        function inicializarPagina() {
            fetch('obtener_productos.php')
                .then(response => response.json())
                .then(data => {
                    productos = data;
                    actualizarNumComidas();
                });
        }

        // Función para actualizar el número de comidas
        function actualizarNumComidas() {
            const numComidas = document.getElementById('numComidas').value;
            crearCajetillas(numComidas);
        }

        // Función para crear los contenedores de comidas
        function crearCajetillas(numComidas) {
            const comidasDiv = document.getElementById('comidas');
            comidasDiv.innerHTML = '';

            for (let i = 1; i <= numComidas; i++) {
                const comidaContainer = document.createElement('div');
                comidaContainer.classList.add('comida-container');
                comidaContainer.innerHTML = `
                <div>
                    <h3>Comida ${i}</h3>
                    <div class="search-box">
                        <input type="text" placeholder="Buscar productos..." oninput="buscarProducto(this.value, ${i})">
                        <div class="search-results" id="search-results-${i}"></div>
                    </div>
                    <div id="productosSeleccionados${i}"></div>
                </div>
            `;
                comidasDiv.appendChild(comidaContainer);
            }
        }

        // Función para buscar productos
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

        // Función para seleccionar un producto
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
        }

        // Función para eliminar un producto seleccionado
        function eliminarProducto(button) {
            button.parentElement.remove();
        }

        // Función para guardar la dieta
        function guardarDieta() {
            const nombreDieta = document.getElementById('nombreDieta').value;
            const tipoDieta = document.getElementById('tipoDieta').value;
            const observacionesDieta = document.getElementById('observacionesDieta').value;
            const numComidas = document.getElementById('numComidas').value;

            const comidas = [];
            for (let i = 1; i <= numComidas; i++) {
                const productosSeleccionados = document.querySelectorAll(`#productosSeleccionados${i} .producto-seleccionado`);
                const productos = [];
                productosSeleccionados.forEach(productoDiv => {
                    const productoId = productoDiv.querySelector('.cantidad-producto').dataset.productoId;
                    const cantidad = productoDiv.querySelector('.cantidad-producto').value;
                    productos.push({
                        idProducto: productoId,
                        cantidad: cantidad
                    });
                });
                comidas.push(productos);
            }

            fetch('guardar_dieta.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nombreDieta,
                        tipoDieta,
                        observacionesDieta,
                        comidas
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Dieta guardada con éxito');
                    } else {
                        alert('Error al guardar la dieta');
                    }
                });
        }
        // Función para calcular los valores nutricionales
        function calcularValoresNutricionales() {
            const comidasGuardadasDiv = document.getElementById('comidasGuardadas');
            comidasGuardadasDiv.innerHTML = '';

            const numComidas = document.getElementById('numComidas').value;

            let totalCalorias = 0;
            let totalProteinas = 0;
            let totalGrasas = 0;
            let totalCarbohidratos = 0;

            for (let i = 1; i <= numComidas; i++) {
                const productosSeleccionados = document.querySelectorAll(`#productosSeleccionados${i} .producto-seleccionado`);
                let caloriasComida = 0;
                let proteinasComida = 0;
                let grasasComida = 0;
                let carbohidratosComida = 0;

                productosSeleccionados.forEach(productoDiv => {
                    const productoId = productoDiv.querySelector('.cantidad-producto').dataset.productoId;
                    const cantidad = parseFloat(productoDiv.querySelector('.cantidad-producto').value);
                    const producto = productos.find(p => p.idProducto == productoId);

                    caloriasComida += (producto.caloriasProducto * cantidad / producto.cantidadProducto);
                    proteinasComida += (producto.proteinasProducto * cantidad / producto.cantidadProducto);
                    grasasComida += (producto.grasasProducto * cantidad / producto.cantidadProducto);
                    carbohidratosComida += (producto.hcarbonoProducto * cantidad / producto.cantidadProducto);
                });

                totalCalorias += caloriasComida;
                totalProteinas += proteinasComida;
                totalGrasas += grasasComida;
                totalCarbohidratos += carbohidratosComida;

                const comidaDiv = document.createElement('div');
                comidaDiv.innerHTML = `
                    <h3>Comida ${i}</h3>
                    <p>Calorías: ${caloriasComida.toFixed(2)} kcal</p>
                    <p>Proteínas: ${proteinasComida.toFixed(2)} g</p>
                    <p>Grasas: ${grasasComida.toFixed(2)} g</p>
                    <p>Carbohidratos: ${carbohidratosComida.toFixed(2)} g</p>
                `;

                comidasGuardadasDiv.appendChild(comidaDiv);
            }

            const totalDiv = document.createElement('div');
            totalDiv.innerHTML = `
                <h3>Total Diario</h3>
                <p>Calorías: ${totalCalorias.toFixed(2)} kcal</p>
                <p>Proteínas: ${totalProteinas.toFixed(2)} g</p>
                <p>Grasas: ${totalGrasas.toFixed(2)} g</p>
                <p>Carbohidratos: ${totalCarbohidratos.toFixed(2)} g</p>
            `;

            comidasGuardadasDiv.appendChild(totalDiv);
        }

        // Llamar a la función para inicializar la página cuando se carga por primera vez
        document.addEventListener('DOMContentLoaded', inicializarPagina);
    </script>
</body>

</html>