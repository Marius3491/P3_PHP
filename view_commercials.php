<?php
include 'funciones.php';
include 'index.php';
$db = connectDB();

/**
 * Get the list of commercials from the database
 * @param PDO $db Database connection
 * @return array List of commercials
 */
function getCommercials($db) {
    $query = "SELECT codigo, nombre FROM Comerciales";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$commercials = getCommercials($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Commercials</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<h1>View Commercials</h1>
<table>
    <tr>
        <th>Code</th>
        <th>Name</th>
    </tr>
    <?php foreach ($commercials as $commercial) : ?>
        <tr>
            <td><?php echo $commercial['codigo']; ?></td>
            <td><?php echo $commercial['nombre']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

