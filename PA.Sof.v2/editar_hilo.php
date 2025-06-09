<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: iniciarsesion.php");
    exit;
}

if (!isset($_GET['id'])) {
    die('ID de hilo no especificado.');
}

$hilo_id = $_GET['id'];

// Obtener datos del hilo y del usuario que lo creó
$stmt = $conn->prepare("
    SELECT f.id, f.titulo, f.contenido, f.user_id, u.tipo_usuario
    FROM foro_hilos f
    JOIN usuarios u ON f.user_id = u.id
    WHERE f.id = :id
");
$stmt->execute(['id' => $hilo_id]);
$hilo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hilo) {
    die('Hilo no encontrado.');
}

$es_autor = $hilo['user_id'] == $_SESSION['user_id'];
$es_moderador = isset($_SESSION['rol']) && $_SESSION['rol'] === 'moderador';

if (!$es_autor && !$es_moderador) {
    die('No tienes permiso para editar este hilo.');
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_titulo = trim($_POST['titulo']);
    $nuevo_contenido = trim($_POST['contenido']);

    if (empty($nuevo_titulo) || empty($nuevo_contenido)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $update_stmt = $conn->prepare("
            UPDATE foro_hilos
            SET titulo = :titulo, contenido = :contenido
            WHERE id = :id
        ");
        $update_stmt->execute([
            ':titulo' => $nuevo_titulo,
            ':contenido' => $nuevo_contenido,
            ':id' => $hilo_id
        ]);

        header("Location: ver_hilo.php?id=$hilo_id&mensaje=hilo_editado");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Hilo</title>
    <link rel="stylesheet" href="inicio.css">
</head>
<style>
/* General Body and Container */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #4dd0e1 0%, #00acc1 50%, #0097a7 100%);
    min-height: 100vh;
    color: #333;
    margin: 0;
    padding: 20px;
    line-height: 1.6;
}

.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 0 15px;
}

/* Back to Panel Button */
.btn-action, 
a[href*="panel"], 
button {
    display: inline-block;
    padding: 12px 20px;
    background: linear-gradient(135deg, #007B7F, #00a0a5);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    text-decoration: none;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 123, 127, 0.3);
    font-weight: 500;
}

.btn-action:hover, 
a[href*="panel"]:hover, 
button:hover {
    background: linear-gradient(135deg, #005f5f, #007B7F);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 127, 0.4);
}

/* Form Container */
.form-container, 
.panel-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Form Headings */
h1, h2, h3 {
    color: #007B7F;
    margin-top: 0;
    margin-bottom: 25px;
    font-weight: 600;
}

h1 {
    font-size: 2rem;
    text-align: center;
    background: linear-gradient(135deg, #007B7F, #4dd0e1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Form Labels */
label {
    display: block;
    color: #007B7F;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 1rem;
}

/* Form Inputs */
input[type="text"], 
textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e0f2f1;
    border-radius: 10px;
    font-size: 1rem;
    font-family: inherit;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
    box-sizing: border-box;
    margin-bottom: 20px;
}

input[type="text"]:focus, 
textarea:focus {
    outline: none;
    border-color: #4dd0e1;
    box-shadow: 0 0 0 3px rgba(77, 208, 225, 0.2);
    background: white;
}

textarea {
    min-height: 120px;
    resize: vertical;
}

/* Success/Confirmation Messages */
.success-message {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 25px;
    text-align: center;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(196, 230, 203, 0.3);
}

/* Form Actions */
.form-actions, 
.textarea-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-start;
    margin-top: 25px;
}

.form-actions .btn-action, 
.textarea-actions .btn-action {
    margin-bottom: 0;
    flex: 0 0 auto;
}

/* Secondary Button Style */
.btn-secondary {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268, #495057);
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }
    
    .container {
        margin: 10px auto;
        padding: 0 10px;
    }
    
    .form-container, 
    .panel-section {
        padding: 20px;
        border-radius: 12px;
    }
    
    h1 {
        font-size: 1.5rem;
    }
    
    input[type="text"], 
    textarea {
        padding: 12px;
    }
    
    .form-actions, 
    .textarea-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-action {
        width: 100%;
        text-align: center;
    }
}

/* Additional Polish */
.form-group {
    margin-bottom: 25px;
}

.form-group:last-child {
    margin-bottom: 0;
}

/* Improved visual hierarchy */
.panel-section h3 {
    border-bottom: 3px solid #4dd0e1;
    padding-bottom: 12px;
    margin-bottom: 25px;
    font-size: 1.4rem;
}

/* Enhanced replies section (if needed) */
.respuesta {
    background: rgba(249, 249, 249, 0.8);
    border: 1px solid rgba(238, 238, 238, 0.8);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    backdrop-filter: blur(5px);
}

.respuesta:hover {
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

/* Loading states */
.btn-action:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-action:disabled:hover {
    background: linear-gradient(135deg, #007B7F, #00a0a5);
    transform: none;
}

</style>
<body>
<div class="container">
    <a href="panel_moderador.php" class="btn-action">← Volver al panel</a>

    <div class="panel-section">
        <h3>Editar Hilo</h3>

        <?php if (isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="titulo">Título:</label><br>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($hilo['titulo']) ?>" required style="width: 100%; margin-bottom: 10px;"><br>

            <label for="contenido">Contenido:</label><br>
            <textarea name="contenido" id="contenido" rows="10" required style="width: 100%;"><?= htmlspecialchars($hilo['contenido']) ?></textarea><br><br>

            <button type="submit" class="btn-action">Guardar Cambios</button>
        </form>
    </div>
</div>
</body>
</html>
