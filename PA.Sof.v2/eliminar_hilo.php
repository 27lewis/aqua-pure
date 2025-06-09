<?php
require_once 'conexion.php';
session_start();

// Verificar que el usuario sea moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    echo "<script>alert('No tienes permiso para acceder a esta página. Por favor, inicia sesión como moderador.'); window.location.href = 'iniciarsesion.php';</script>";
    exit();
}

// Validar que se haya enviado el ID del hilo
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID de hilo inválido o no proporcionado.'); window.location.href = 'panel_moderador.php';</script>";
    exit();
}

$id_hilo = (int)$_GET['id'];

try {
    // Iniciar transacción para asegurar consistencia
    $conn->beginTransaction();
    
    // Verificar que el hilo existe antes de eliminarlo
    $stmt = $conn->prepare("SELECT id, titulo FROM foro_hilos WHERE id = ?");
    $stmt->execute([$id_hilo]);
    $hilo = $stmt->fetch();
    
    if (!$hilo) {
        $conn->rollback();
        echo "<script>alert('El hilo que intentas eliminar no existe.'); window.location.href = 'panel_moderador.php';</script>";
        exit();
    }
    
    // Primero eliminar las respuestas relacionadas al hilo
    $stmt = $conn->prepare("DELETE FROM foro_respuestas WHERE hilo_id = ?");
    $stmt->execute([$id_hilo]);
    $respuestas_eliminadas = $stmt->rowCount();

    // Luego eliminar el hilo en sí
    $stmt = $conn->prepare("DELETE FROM foro_hilos WHERE id = ?");
    $stmt->execute([$id_hilo]);
    
    // Confirmar la transacción
    $conn->commit();
    
    // Mensaje de éxito con JavaScript
    echo "<script>alert('Hilo \\'{$hilo['titulo']}\\' eliminado exitosamente junto con {$respuestas_eliminadas} respuestas.'); window.location.href = 'panel_moderador.php#foro';</script>";
    exit();
    
} catch (PDOException $e) {
    // Revertir la transacción en caso de error
    if ($conn->inTransaction()) {
        $conn->rollback();
    }
    
    error_log("Error al eliminar el hilo ID {$id_hilo}: " . $e->getMessage());
    // Mensaje de error con JavaScript
    echo "<script>alert('Ocurrió un error al intentar eliminar el hilo: No se pudo eliminar el hilo. Error técnico.'); window.location.href = 'panel_moderador.php';</script>";
    exit();
}
?>


