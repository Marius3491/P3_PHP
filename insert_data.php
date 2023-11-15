<?php
include 'funciones.php';
include 'index.php';
// Conexión a la base de datos
$db = connectDB();

// Función para obtener la lista de comerciales
function getCommercials($db) {
    $query = "SELECT codigo, nombre FROM Comerciales";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function insertCommercial($db, $codigo, $nombre, $salario, $hijos, $fNacimiento) {
    $query = "INSERT INTO Comerciales (codigo, nombre, salario, hijos, fNacimiento) 
              VALUES (:codigo, :nombre, :salario, :hijos, :fNacimiento)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':hijos', $hijos);
    $stmt->bindParam(':fNacimiento', $fNacimiento);
    return $stmt->execute();
}

function insertProduct($db, $referencia, $nombre, $descripcion, $precio, $descuento) {
    $query = "INSERT INTO Productos (referencia, nombre, descripcion, precio, descuento) 
              VALUES (:referencia, :nombre, :descripcion, :precio, :descuento)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':referencia', $referencia);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':descuento', $descuento);
    return $stmt->execute();
}

function insertSale($db, $codComercial, $refProducto, $cantidad, $fecha) {
    $query = "INSERT INTO Ventas (codComercial, refProducto, cantidad, fecha) 
              VALUES (:codComercial, :refProducto, :cantidad, :fecha)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codComercial', $codComercial);
    $stmt->bindParam(':refProducto', $refProducto);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':fecha', $fecha);
    return $stmt->execute();
}

// Función para obtener la lista de productos
function getProductsList($db) {
    $query = "SELECT referencia, nombre FROM Productos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function validarFecha($fecha) {
    $patron = "/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])$/";
    return preg_match($patron, $fecha);
}
// Obtener la lista de comerciales
$commercials = getCommercials($db);

// Obtener la lista de productos
$products = getProductsList($db);

// Procesar el formulario de inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitCommercial'])) {
        // Insertar un nuevo comercial
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $salario = $_POST['salario'];
        $hijos = $_POST['hijos'];
        $fNacimiento = $_POST['fNacimiento'];

        if (!validarFecha($fNacimiento)) {
            $fechaNacimientoError = "Formato de fecha de nacimiento no válido. Utiliza YYYY-MM-DD.";
        } else {
            insertCommercial($db, $codigo, $nombre, $salario, $hijos, $fNacimiento);
        }
    } elseif (isset($_POST['submitProduct'])) {
        // Insertar un nuevo producto
        $referencia = $_POST['referencia'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $descuento = $_POST['descuento'];

        if (insertProduct($db, $referencia, $nombre, $descripcion, $precio, $descuento)) {
            echo "Producto insertado con éxito.";
        } else {
            echo "Error al insertar el producto.";
        }
    } elseif (isset($_POST['submitSale'])) {
        // Insertar una nueva venta
        $codComercial = $_POST['codComercial'];
        $refProducto = $_POST['refProducto'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];

        if (insertSale($db, $codComercial, $refProducto, $cantidad, $fecha)) {
            echo "Venta insertada con éxito.";
        } else {
            echo "Error al insertar la venta.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Insert Data</h1>

<!-- Formulario para insertar un nuevo comercial -->
<form method="POST">
    <h2>Insertar Comercial</h2>
    <label for="codigo">Código:</label>
    <input type="text" name="codigo" required>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <label for="salario">Salario:</label>
    <input type="text" name="salario" required>
    <label for="hijos">Número de Hijos:</label>
    <input type="text" name="hijos" required>
    <label for="fNacimiento">Fecha de Nacimiento:</label>
    <input type="date" name="fNacimiento" required>
    <input type="submit" name="submitCommercial" value="Insertar Comercial">
</form>

<!-- Formulario para insertar un nuevo producto -->
<form method="POST">
    <h2>Insertar Producto</h2>
    <label for="referencia">Referencia:</label>
    <input type="text" name="referencia" required>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <label for="descripcion">Descripción:</label>
    <input type="text" name="descripcion" required>
    <label for="precio">Precio:</label>
    <input type="text" name="precio" required>
    <label for="descuento">Descuento:</label>
    <input type="text" name="descuento" required>
    <input type="submit" name="submitProduct" value="Insertar Producto">
</form>

<!-- Formulario para insertar una nueva venta -->
<form method="POST">
    <h2>Insertar Venta</h2>
    <label for="codComercial">Código del Comercial:</label>
    <select name="codComercial" required>
        <?php foreach ($commercials as $commercial) : ?>
            <option value="<?php echo $commercial['codigo']; ?>"><?php echo $commercial['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="refProducto">Referencia del Producto:</label>
    <select name="refProducto" required>
        <?php foreach ($products as $product) : ?>
            <option value="<?php echo $product['referencia']; ?>"><?php echo $product['referencia'] . ' - ' . $product['nombre']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="cantidad">Cantidad:</label>
    <input type="text" name="cantidad" required>
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required>
    <input type="submit" name="submitSale" value="Insertar Venta">
</form>
</body>
</html>