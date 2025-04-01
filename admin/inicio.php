<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grissel Santana</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/fullcalendar.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        
        </div></div><div class="container">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
    <p class="text-secondary mb-0"><b>Tus citas agendadas son las siguientes</b></p>
    <a href="panel_grissel.php" class="btn btn-modern">Disponibilidad</a>
    <a href="lista_clientas.php" class="btn btn-modern">Clientas</a> <!-- Nuevo botón "Clientas" -->

</div><style>
    .btn-modern {
        background-color: #5a9bf4;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s;
        cursor: pointer;
    }

    .btn-modern:hover {
        background-color: #4a8ae3;
        transform: scale(1.05);
    }

    .btn-modern:active {
        background-color: #3979d2;
        transform: scale(0.98);
    }

    .card-header {
        background-color: #fff;
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }
</style>

            <div class="card-body">
                <?php include "calendario.php";?>
            </div>
        </div>
    </div>

    <div class="row"><div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Consultar Citas</h5>
                        <p class="card-text">Accede al módulo para consultar más detalles.</p>
                        <a href="mod_reservas.php" class="btn btn-primary"><i class="fas fa-calendar"></i> Ir a detalles</a>
                    </div>
                </div>
            </div>

    <?php include("../footer.php"); ?>
</body>
</html>