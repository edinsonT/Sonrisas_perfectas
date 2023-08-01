<?php
session_start();
require "conexion.php";

$correo = $_SESSION ['correo'];
$rol = $_SESSION ['rol'];


$nombres = isset($_SESSION['nombres']) ?  : "Nombre no disponible";


if (isset($_SESSION['mensaje_cita'])) {
  $mensaje_cita = $_SESSION['mensaje_cita'];
  unset($_SESSION['mensaje_cita']);
}

$sql = "SELECT nombres FROM usuarios WHERE correo = '$correo'";



$resultado = mysqli_query($conn, $sql);

 if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
 }

if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombres = $fila['nombres'];
}


function getHorarios()
{
    $horarios = "";
    $horaInicio = strtotime('08:00');
    $horaFin = strtotime('19:00');

    while ($horaInicio <= $horaFin) {
        $hora = date('H:i', $horaInicio);
        $horarios .= "<option value=\"$hora\">$hora</option>";
        $horaInicio = strtotime('+30 minutes', $horaInicio);
    }

    return $horarios;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonrisas Perfectas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/extilos.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="inicio.php">Gestión De Citas Odontológicas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Actualizar Datos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <b>Bienvenido (a)</b> <?php echo $nombres; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Cambiar Contraseña</a></li>
                        <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <?php include("Agenda_creada.php") ?>

    <h1 style="text-align: center;">Abrir Agenda</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Gestión de agendas
                        <a href="inicio.php" class="btn btn-danger float-end"> Regresar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="crear_agenda.php" method="post">
                        <div class="col-mb-3">
                            <label for="estadoAgenda" class="col-sm-1 col-form-label">Estado</label>
                            <select id="estadoAgenda" class="form-select" name="estadoAgenda" required>
                                <option>Abierta</option>
                                <option>Cancelada</option>
                            </select>
                        </div>
                        <div class="col-mb-3">
                            <label for="diasHabilitados" class="col-sm-1 col-form-label">Días habilitados</label>
                            <input type="date" class="form-control" id="diasHabilitados" name='diasHabilitados' required>
                        </div>
                        <div class="col-mb-3">
                            <label for="horaInicio" class="col-sm-1 col-form-label">Hora Inicio</label>
                            <select class="form-select" id="horaInicio" name='horaInicio' required>
                                <?php echo getHorarios(); ?>
                            </select>
                        </div>
                        <div class="col-mb-3">
                            <label for="horaFin" class="col-sm-1 col-form-label">Hora fin</label>
                            <select class="form-select" id="horaFin" name='horaFin' required>
                                <?php echo getHorarios(); ?>
                            </select>
                        </div>
                        <div class="col-mb-3">
                            <label for="numeroDeCitas" class="col-sm-1 col-form-label">Número de citas</label>
                            <input type="number" class="form-control" id="numeroDeCitas" name='numeroDeCitas' required>
                        </div>
                        <br>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" name='guardar_Age'>Habilitar Agenda</button>
                            <a href="consultas_agenda.php" class="btn btn-primary">Consultas agenda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
