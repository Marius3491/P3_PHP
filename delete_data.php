<?php
include 'funciones.php';
include 'index.php';
$db = connectDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['deleteSale'])) {
        $codComercial = $_POST['codComercial'];
        $refProducto = $_POST['refProducto'];

        // Iniciar una transacción
        $db->beginTransaction();

        try {
            // Eliminar la venta
            $query_delete = "DELETE FROM Ventas WHERE codComercial = :codComercial AND refProducto = :refProducto";
            $stmt_delete = $db->prepare($query_delete);
            $stmt_delete->bindParam(':codComercial', $codComercial);
            $stmt_delete->bindParam(':refProducto', $refProducto);

            if ($stmt_delete->execute()) {
                // Confirmar la transacción
                $db->commit();
                echo "Venta eliminada con éxito.";
            } else {
                // Revertir la transacción en caso de error
                $db->rollBack();
                echo "Error al eliminar la venta.";
            }
        } catch (PDOException $e) {
            // Manejar excepciones
            $db->rollBack();
            echo "Error en la transacción: " . $e->getMessage();
        }
    } elseif (isset($_POST['deleteCommercial'])) {
        // Eliminar un comercial
        $codigo = $_POST['codigo'];

        // Iniciar una transacción
        $db->beginTransaction();

        try {
            // Eliminar el comercial
            $query_delete = "DELETE FROM Comerciales WHERE codigo = :codigo";
            $stmt_delete = $db->prepare($query_delete);
            $stmt_delete->bindParam(':codigo', $codigo);

            if ($stmt_delete->execute()) {
                // Confirmar la transacción
                $db->commit();
                echo "Comercial eliminado con éxito.";
            } else {
                // Revertir la transacción en caso de error
                $db->rollBack();
                echo "Error al eliminar el comercial.";
            }
        } catch (PDOException $e) {
            // Manejar excepciones
            $db->rollBack();
            echo "Error en la transacción: " . $e->getMessage();
        }
    } elseif (isset($_POST['deleteProduct'])) {
        // Eliminar un producto
        $referencia = $_POST['referencia'];

        // Iniciar una transacción
        $db->beginTransaction();

        try {
            // Eliminar el producto
            $query_delete = "DELETE FROM Productos WHERE referencia = :referencia";
            $stmt_delete = $db->prepare($query_delete);
            $stmt_delete->bindParam(':referencia', $referencia);

            if ($stmt_delete->execute()) {
                // Confirmar la transacción
                $db->commit();
                echo "Producto eliminado con éxito.";
            } else {
                // Revertir la transacción en caso de error
                $db->rollBack();
                echo "Error al eliminar el producto.";
            }
        } catch (PDOException $e) {
            // Manejar excepciones
            $db->rollBack();
            echo "Error en la transacción: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Data</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Delete Data</h1>
<p style="color: red;">Nota: Si intenta eliminar un registro de comerciales o productos que aún están relacionados con ventas, la operación podría generar un error debido a la integridad referencial. Asegúrese de eliminar las ventas relacionadas primero si es necesario.</p>
<form method="POST">
    <h2>Delete Sale</h2>
    <label for="codComercial">Commercial Code:</label>
    <input type="text" name="codComercial" required>
    <label for="refProducto">Product Reference:</label>
    <input type="text" name="refProducto" required>
    <input type="submit" name="deleteSale" value="Delete Sale">
</form>

<form method="POST">
    <h2>Delete Commercial</h2>
    <label for="codigo">Commercial Code:</label>
    <input type="text" name="codigo" required>
    <input type="submit" name="deleteCommercial" value="Delete Commercial">
</form>

<form method="POST">
    <h2>Delete Product</h2>
    <label for="referencia">Product Reference:</label>
    <input type="text" name="referencia" required>
    <input type="submit" name="deleteProduct" value="Delete Product">
</form>
</body>
</html>