<?php
include 'funciones.php';
include 'index.php';
// Conexión a la base de datos
$db = connectDB();

// Función para actualizar los datos de un comercial
function updateCommercial($db, $codigo, $nombre, $salario, $hijos, $fNacimiento) {
    $query = "UPDATE Comerciales 
              SET nombre = :nombre, salario = :salario, hijos = :hijos, fNacimiento = :fNacimiento 
              WHERE codigo = :codigo";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':hijos', $hijos);
    $stmt->bindParam(':fNacimiento', $fNacimiento);
    return $stmt->execute();
}

// Función para actualizar los datos de un producto
function updateProduct($db, $referencia, $nombre, $descripcion, $precio, $descuento) {
    $query = "UPDATE Productos 
              SET nombre = :nombre, descripcion = :descripcion, precio = :precio, descuento = :descuento 
              WHERE referencia = :referencia";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':referencia', $referencia);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':descuento', $descuento);
    return $stmt->execute();
}

// Función para actualizar los datos de una venta
function updateSale($db, $codComercial, $refProducto, $cantidad, $fecha) {
    $query = "UPDATE Ventas 
              SET cantidad = :cantidad, fecha = :fecha 
              WHERE codComercial = :codComercial AND refProducto = :refProducto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codComercial', $codComercial);
    $stmt->bindParam(':refProducto', $refProducto);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':fecha', $fecha);
    return $stmt->execute();
}

function getCommercials($db) {
    $query = "SELECT codigo, nombre FROM Comerciales";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

// Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateCommercial'])) {
        // Actualizar datos de un comercial
        if (!validarFecha($_POST['fNacimiento'])) {
            $fechaNacimientoError = "Formato de fecha de nacimiento no válido. Utiliza YYYY-MM-DD.";
        } else {
            updateCommercial($db, $_POST['codigo'], $_POST['nombre'], $_POST['salario'], $_POST['hijos'], $_POST['fNacimiento']);
        }
    } elseif (isset($_POST['updateProduct'])) {
        // Actualizar datos de un producto
        if (updateProduct($db, $_POST['referencia'], $_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['descuento'])) {
            echo "Datos del producto actualizados con éxito.";
        } else {
            echo "Error al actualizar los datos del producto.";
        }
    } elseif (isset($_POST['updateSale'])) {
        // Actualizar datos de una venta
        if (updateSale($db, $_POST['codComercial'], $_POST['refProducto'], $_POST['cantidad'], $_POST['fecha'])) {
            echo "Datos de la venta actualizados con éxito.";
        } else {
            echo "Error al actualizar los datos de la venta.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Data</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Update Data</h1>

<!-- Formulario para actualizar un comercial -->
<form method="POST">
    <h2>Actualizar Comercial</h2>
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
    <input type="submit" name="updateCommercial" value="Actualizar Comercial">
</form>

<!-- Formulario para actualizar un producto -->
<form method="POST">
    <h2>Actualizar Producto</h2>
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
    <input type="submit" name="updateProduct" value="Actualizar Producto">
</form>

<!-- Formulario para actualizar una venta -->
<form method="POST">
    <h2>Actualizar Venta</h2>
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
    <input type="submit" name="updateSale" value="Actualizar Venta">
</form>
</body>
</html>