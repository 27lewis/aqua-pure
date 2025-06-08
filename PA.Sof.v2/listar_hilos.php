<?php
require_once 'conexion.php';
session_start();

$hilos = $conn->query("
    SELECT f.id, f.titulo, u.nombre AS autor, f.fecha_creacion,
           (SELECT COUNT(*) FROM foro_respuestas r WHERE r.hilo_id = f.id) AS respuestas
    FROM foro_hilos f
    LEFT JOIN usuarios u ON f.user_id = u.id
    ORDER BY f.fecha_creacion DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Hilos</title>
    <link rel="stylesheet" href="inicio.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 960px;
            margin: 30px auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .container h2 {
            color: #007B7F;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4de2e2;
            font-size: 1.8rem;
        }

        .btn, .btn-back {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #00a650;
        }

        .btn:hover {
            background-color: #008f44;
        }

        .btn-back {
            background-color: #4a90e2;
            margin-right: 10px;
        }

        .btn-back:hover {
            background-color: #357ABD;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .tabla th, .tabla td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .tabla th {
            background-color: #007B7F;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .tabla tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        .tabla tbody tr:hover {
            background-color: #f0f0f0;
        }

        .btn-sec {
            display: inline-block;
            padding: 6px 12px;
            background-color: #007B7F;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-sec:hover {
            background-color: #005f5f;
        }

        @media (max-width: 768px) {
            .container {
                margin: 15px;
                padding: 15px;
            }

            .tabla {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .tabla thead,
            .tabla tbody,
            .tabla th,
            .tabla td,
            .tabla tr {
                display: block;
            }

            .tabla thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .tabla tr {
                border: 1px solid #e0e0e0;
                margin-bottom: 10px;
                border-radius: 8px;
            }

            .tabla td {
                border: none;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }

            .tabla td:before {
                content: attr(data-label);
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                color: #555;
            }

            .btn, .btn-back {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="panel_moderador.php" class="btn-back">← Volver</a>

        <a href="crear_hilo.php" class="btn">Crear nuevo hilo</a>

        <h2>Lista de Hilos</h2>
        
        <table class="tabla">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Respuestas</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($hilos as $hilo): ?>
                <tr>
                    <td data-label="Título"><?= htmlspecialchars($hilo['titulo']) ?></td>
                    <td data-label="Autor"><?= htmlspecialchars($hilo['autor']) ?></td>
                    <td data-label="Respuestas"><?= $hilo['respuestas'] ?></td>
                    <td data-label="Fecha"><?= date('d/m/Y H:i', strtotime($hilo['fecha_creacion'])) ?></td>
                    <td data-label="Acciones"><a href="ver_hilo.php?id=<?= $hilo['id'] ?>" class="btn-sec">Ver</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
