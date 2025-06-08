
<?php
$host = "localhost:3307";
$dbname = "aqua-pure";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "¡Conexión exitosa!";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>


