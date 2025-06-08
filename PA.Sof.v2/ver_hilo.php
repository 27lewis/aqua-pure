<?php
require_once 'conexion.php';
session_start();

if (!isset($_GET['id'])) {
    die('ID de hilo no especificado.');
}

$hilo_id = $_GET['id'];

// Obtener la información del hilo
$stmt = $conn->prepare("
    SELECT f.id, f.titulo, f.contenido, f.fecha_creacion, u.nombre AS autor
    FROM foro_hilos f
    JOIN usuarios u ON f.user_id = u.id
    WHERE f.id = :id
");
$stmt->execute(['id' => $hilo_id]);
$hilo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hilo) {
    die('Hilo no encontrado.');
}

// Obtener las respuestas del hilo
$respuesta_stmt = $conn->prepare("
    SELECT r.id, r.contenido, r.fecha, r.es_moderador, u.nombre
    FROM foro_respuestas r
    JOIN usuarios u ON r.user_id = u.id
    WHERE r.hilo_id = :id
    ORDER BY r.fecha ASC
");
$respuesta_stmt->execute(['id' => $hilo_id]);
$respuestas = $respuesta_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($hilo['titulo']) ?></title>
    <link rel="stylesheet" href="inicio.css">
</head>
<style>
  /* General Body and Container */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa; /* Light background for the page */
    color: #333;
    margin: 0;
    padding: 20px;
    line-height: 1.6;
}

.container {
    max-width: 900px; /* Adjust max-width as needed */
    margin: 20px auto; /* Center the container on the page */
    padding: 0 15px; /* Add some horizontal padding */
}

/* Back to Threads Button */
.btn-action {
    display: inline-block; /* Make it behave like a button */
    padding: 8px 15px;
    background-color: #007B7F;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 0.9rem;
    text-decoration: none; /* Remove underline for links */
    margin-bottom: 20px; /* Space below the button */
}

.btn-action:hover {
    background-color: #005f5f;
}

/* Panel Sections (for thread details, replies, and reply form) */
.panel-section {
    background: #fff;
    border-radius: 10px;
    padding: 25px; /* Increased padding for better spacing */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px; /* Space between sections */
}

.panel-section h3 {
    color: #007B7F;
    border-bottom: 2px solid #4de2e2;
    padding-bottom: 10px;
    margin-top: 0; /* Remove default top margin */
    margin-bottom: 20px; /* Space below the heading */
    font-size: 1.5rem; /* Larger font for main headings */
}

/* Thread Content Details */
.panel-section p {
    margin-bottom: 10px; /* Space between paragraphs */
}

.panel-section p strong {
    color: #007B7F; /* Emphasize author/date labels */
}

/* Replies Section */
.respuesta {
    background-color: #f9f9f9; /* Light background for individual replies */
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px; /* Space between replies */
}

.respuesta p {
    margin-bottom: 8px;
}

.respuesta p:last-child {
    margin-bottom: 0; /* No margin after the last paragraph in a reply */
}

.respuesta strong {
    color: #333; /* Make author name prominent */
}

.respuesta em {
    color: #666; /* Subtle color for date */
    font-size: 0.9em;
}

.respuesta hr {
    border: 0;
    border-top: 1px solid #e0e0e0;
    margin: 15px 0;
}

/* Badges (Moderator) - Reusing existing badge styles */
.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 15px;
    font-size: 0.75rem; /* Slightly smaller for badges */
    font-weight: bold;
    text-transform: capitalize;
    margin-left: 5px; /* Space after name */
}

.badge-moderador {
    background-color: #007B7F;
    color: white;
}

/* Reply Form */
.panel-section form {
    margin-top: 20px; /* Space above the form fields */
}

.panel-section textarea {
    width: calc(100% - 22px); /* Full width minus padding and border */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    min-height: 100px; /* Adequate height for textarea */
    box-sizing: border-box; /* Include padding/border in width */
    margin-bottom: 15px; /* Space between textarea and buttons */
}

.textarea-actions {
    display: flex;
    justify-content: flex-start; /* Align button to the left */
}

.textarea-actions .btn-action {
    margin-bottom: 0; /* Remove extra margin from general btn-action */
}

/* Message for no replies */
.panel-section > p {
    font-style: italic;
    color: #666;
}

/* Responsive adjustments if needed, similar to panel.css */
@media (max-width: 768px) {
    .container {
        margin: 15px auto;
        padding: 0 10px;
    }
    .panel-section {
        padding: 20px;
    }
}
</style>

<body>
    <div class="container">
        <a href="listar_hilos.php" class="btn-action">← Volver a los hilos</a>

        <div class="panel-section">
            <h3><?= htmlspecialchars($hilo['titulo']) ?></h3>
            <p><strong>Autor:</strong> <?= htmlspecialchars($hilo['autor']) ?> | 
               <strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($hilo['fecha_creacion'])) ?></p>
            <p><?= nl2br(htmlspecialchars($hilo['contenido'])) ?></p>
        </div>

        <div class="panel-section">
            <h3>Respuestas (<?= count($respuestas) ?>)</h3>

            <?php if (empty($respuestas)): ?>
                <p>No hay respuestas aún. Sé el primero en responder.</p>
            <?php else: ?>
                <?php foreach ($respuestas as $r): ?>
                    <div class="respuesta">
                        <p>
                            <strong><?= htmlspecialchars($r['nombre']) ?></strong>
                            <?php if ($r['es_moderador']): ?>
                                <span class="badge badge-moderador">Moderador</span>
                            <?php endif; ?>
                            | <em><?= date('d/m/Y H:i', strtotime($r['fecha'])) ?></em>
                        </p>
                        <p><?= nl2br(htmlspecialchars($r['contenido'])) ?></p>
                        <hr>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="panel-section">
            <h3>Responder al hilo</h3>
            <form action="responder_hilo.php" method="post">
                <input type="hidden" name="hilo_id" value="<?= $hilo_id ?>">
                <textarea name="contenido" rows="5" style="width:100%;" required></textarea>
                <div class="textarea-actions">
                    <button type="submit" class="btn-action">Publicar respuesta</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
