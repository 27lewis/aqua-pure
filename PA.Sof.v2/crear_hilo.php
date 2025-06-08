<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: iniciarsesion.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    if ($titulo && $contenido) {
        $stmt = $conn->prepare("INSERT INTO foro_hilos (titulo, contenido, user_id, fecha_creacion) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$titulo, $contenido, $_SESSION['user_id']]);
        header('Location: listar_hilos.php');
        exit();
    } else {
        $error = 'Todos los campos son obligatorios.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Hilo</title>
    <link rel="stylesheet" href="inicio.css">
    <style>
        /* Improved Form Styles */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 90%; /* Adjust width as needed */
            max-width: 600px;
            margin: 30px auto;
        }

        .form-container h2 {
            color: #007B7F;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4de2e2;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: calc(100% - 22px); /* Adjust for padding and border */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-group textarea {
            min-height: 150px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-start; /* Align buttons to the left */
            margin-top: 20px;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .form-actions button:first-child { /* Publicar button */
            background-color: #007B7F;
            color: white;
        }

        .form-actions button:first-child:hover {
            background-color: #005f5f;
        }

        /* Styling for the Cancel button as an anchor */
        .form-actions .btn-cancel {
            display: inline-block; /* Treat as a button-like element */
            padding: 10px 20px;
            background-color: #f8f9fa;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-decoration: none; /* Remove underline */
            font-size: 1rem;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .form-actions .btn-cancel:hover {
            background-color: #e9ecef;
        }

        /* Specific error message style */
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Crear Hilo</h2>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="5" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit">Publicar</button>
                <a href="listar_hilos.php" class="btn-cancel">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>