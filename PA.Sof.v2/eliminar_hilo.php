<?php
require_once 'conexion.php';
session_start();

// Verificar que el usuario sea moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Validar que se haya enviado el ID del hilo
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: panelmoderador.php?error=ID%20inválido");
    exit();
}

$id_hilo = (int)$_GET['id'];

try {
    // Primero eliminar las respuestas relacionadas al hilo
    $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE hilo_id = ?");
    $stmt->execute([$id_hilo]);

    // Luego eliminar el hilo en sí
    $stmt = $conn->prepare("DELETE FROM foro_hilos WHERE id = ?");
    $stmt->execute([$id_hilo]);

    header("Location: panelmoderador.php#foro");
    exit();
} catch (PDOException $e) {
    error_log("Error al eliminar el hilo: " . $e->getMessage());
    header("Location: panelmoderador.php?error=No%20se%20pudo%20eliminar%20el%20hilo");
    exit();
}
?>
