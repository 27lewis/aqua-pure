<?php
require_once 'conexion.php';
session_start();

// Verificar que el usuario sea un moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Verificar si se recibió un ID válido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: panel_moderador.php');
    exit();
}

$usuario_id = intval($_GET['id']);

// Evitar que el moderador se elimine a sí mismo
if ($_SESSION['user_id'] == $usuario_id) {
    echo "<script>alert('No puedes eliminar tu propio usuario.'); window.location.href = 'panel_moderador.php';</script>";
    exit();
}

try {
    // Verificar que el usuario exista antes de eliminar
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        echo "<script>alert('Usuario no encontrado.'); window.location.href = 'panel_moderador.php';</script>";
        exit();
    }

    // Eliminar usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);

    echo "<script>alert('Usuario eliminado correctamente.'); window.location.href = 'panel_moderador.php';</script>";
} catch (PDOException $e) {
    error_log("Error al eliminar usuario: " . $e->getMessage());
    echo "<script>alert('Ocurrió un error al intentar eliminar el usuario.'); window.location.href = 'panel_moderador.php';</script>";
}
?>
