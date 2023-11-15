<?php
include 'funciones.php';
include 'index.php';
// Conexión a la base de datos
$db = connectDB();

// Función para obtener la lista de comerciales
function getCommercialsList($db) {
    $query = "SELECT codigo, nombre FROM Comerciales";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener las ventas de un comercial
function getSalesForCommercial($db, $codComercial) {
    $query = "SELECT V.*, P.referencia as productCode, P.nombre as productName
              FROM Ventas V
              JOIN Productos P ON V.refProducto = P.referencia
              WHERE V.codComercial = :codComercial";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codComercial', $codComercial);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener la lista de comerciales
$commercials = getCommercialsList($db);

// Procesar el formulario
$selectedCommercial = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codComercial'])) {
    $selectedCommercial = $_POST['codComercial'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sales</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>View Sales</h1>
<form method="POST">
    <label for="codComercial">Select a Commercial:</label>
    <select name="codComercial" id="codComercial">
        <?php foreach ($commercials as $commercial) : ?>
            <option value="<?php echo $commercial['codigo']; ?>" <?php if ($commercial['codigo'] == $selectedCommercial) echo 'selected'; ?>>
                <?php echo $commercial['codigo'] . ' - ' . $commercial['nombre']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="View Sales">
</form>

<?php
if ($selectedCommercial !== null) {
    $sales = getSalesForCommercial($db, $selectedCommercial);

    if (!empty($sales)) {
        $commercialName = $commercials[array_search($selectedCommercial, array_column($commercials, 'codigo'))]['nombre'];
        echo "<h2>Sales for $commercialName:</h2>";
        echo "<table>";

        echo "<tr><th>Product Code</th><th>Product Name</th><th>Quantity</th><th>Date</th></tr>";

        foreach ($sales as $sale) {
            echo "<tr>";
            echo "<td>" . $sale['productCode'] . "</td>";
            echo "<td>" . $sale['productName'] . "</td>";
            echo "<td>" . $sale['cantidad'] . "</td>";
            echo "<td>" . $sale['fecha'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No sales found for the selected commercial.";
    }
}
?>
</body>
</html>
