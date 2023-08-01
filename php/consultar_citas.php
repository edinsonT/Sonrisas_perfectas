<?php
session_start();
require "conexion.php";

$correo = $_SESSION['correo'];
$rol = $_SESSION['rol'];


$nombres = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : "Nombre no disponible";

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



$sql = "SELECT idPaciente FROM paciente WHERE correo = '$correo'";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$fila = mysqli_fetch_assoc($resultado);
$idPaciente = $fila['idPaciente'];


$sql = "SELECT * FROM citas WHERE Paciente_idPaciente = $idPaciente";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonrisas Perfectas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
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
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> 
<div class="container">
    <h2 style="text-align: center;">Sonrisas Perfectas</h2>
    <p>El sistema de Gestión de Odontológica permite administrar la información de los pacientes, tratamientos y citas a través de una interfaz web </p>
   
        <hr>
        <div class="row">
        <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
              
        <h4 style="text-align: start;">Consultar Citas
 
        <a href="excel2.php" class="icon-link" >
                  <i class="bi bi-file-earmark-excel-fill"></i>
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel-fill" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z"/>
                    </svg></h4>
</a>
</div>
<div class="card-body">              
              <table class="table table-bordered table-striped ">  
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Estado Cita</th>
                        <th>Fecha Cita</th>
                        <th>Hora Cita</th>
                        <th>ID Agenda</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cita = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo $cita['idcitas']; ?></td>
                            <td><?php echo $cita['estadoCita']; ?></td>
                            <td><?php echo $cita['fechaCita']; ?></td>
                            <td><?php echo $cita['horaCita']; ?></td>
                            <td><?php echo $cita['Agenda_idAgenda']; ?></td>
                            <td><?php echo $nombres; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
        
        <a href="inicio.php" class="btn btn-primary">Volver</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

