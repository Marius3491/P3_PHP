<?php

include 'funciones.php';
include 'index.php';
$db = connectDB();

/**
 * Get the list of products from the database
 * @param PDO $db Database connection
 * @return array List of products
 */
function getProducts($db) {
    $query = "SELECT referencia, nombre FROM Productos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$products = getProducts($db);
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>View Products</title>
        <link rel="stylesheet" type="text/css" href="styles.css">

    </head>
    <body>
    <h1>View Products</h1>
    <table>
        <tr>
            <th>Reference</th>
            <th>Name</th>
        </tr>
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['referencia']; ?></td>
                <td><?php echo $product['nombre']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </body>
    </html>
<?php
