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
    <a class="navbar-brand" href="#">Gestión De Citas Odontológicas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Actualizar Datos</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>Bienvenido (a)</b> <?php echo $nombres; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="cambiar_contra.php">Cambiar Contraseña</a></li>
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


          

        <?php if (isset($mensaje_cita)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $mensaje_cita; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


                <p>El sistema de Gestión de Odontológica permite administrar la información de los pacientes, tratamientos y citas a través de una interfaz web </p>
                <div class="row">


   <?php if ($rol < 3) {?>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body" style="text-align: center;">
      <i class="bi bi-calendar4-event"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40" fill="#7F8C8D" class="bi bi-calendar4-event" viewBox="0 0 16  16">
    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
     </svg>
        <p class="card-text">En este modulo podrá consultar las agendas..</p>
        <a href="Agenda_form.php" class="btn btn-secondary">Crear agendas</a>
      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="card">
      <div class="card-body" style="text-align: center;">
      <i class="bi bi-calendar4-event"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40" fill="#7F8C8D" class="bi bi-calendar4-event" viewBox="0 0 16  16">
    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
     </svg>
        <p class="card-text">En este modulo podrá consultar las agendas..</p>
        <a href="consultas_agenda.php" class="btn btn-primary">Consultar agendas</a>
      </div>
    </div>
  </div>

 



  <?php }?>

  <?php if ($rol == 1) {?>

  <div class="col-sm-3">
    <div class="card">
      <div class="card-body" style="text-align: center;">
      <i class="bi bi-person-add"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
  <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
</svg>
        <p class="card-text">En este modulo podrá agregar nuevos usuario</p>
        <a href="agrega_user.php" class="btn btn-success">Agregar usuario</a>
      </div>
    </div>
  </div>
  <?php }?>

  <?php if ($rol > 4) {?>
  <div class="col-sm-3">
    <div class="card">
      <div class="card-body" style="text-align: center;">
      <i class="bi bi-search"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40" fill=#3498DB class="bi bi-search" viewBox="0 0 16 16">
        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
        <p class="card-text">En este modulo podrá ver las citas disponibles.</p>

<a href="pver_agendas.php" class="btn btn-primary">Ver citas</a>


      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="card">
      <div class="card-body" style="text-align: center;">
      <i class="bi bi-search"></i>
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40" fill="#2ECC71" class="bi bi-binoculars" viewBox="0 0 16 16">
      <path d="M3 2.5A1.5 1.5 0 0 1 4.5 1h1A1.5 1.5 0 0 1 7 2.5V5h2V2.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5v2.382a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V14.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 14.5v-3a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5v3A1.5 1.5 0 0 1 5.5 16h-3A1.5 1.5 0 0 1 1 14.5V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V2.5zM4.5 2a.5.5 0 0 0-.5.5V3h2v-.5a.5.5 0 0 0-.5-.5h-1zM6 4H4v.882a1.5 1.5 0 0 1-.83 1.342l-.894.447A.5.5 0 0 0 2 7.118V13h4v-1.293l-.854-.853A.5.5 0 0 1 5 10.5v-1A1.5 1.5 0 0 1 6.5 8h3A1.5 1.5 0 0 1 11 9.5v1a.5.5 0 0 1-.146.354l-.854.853V13h4V7.118a.5.5 0 0 0-.276-.447l-.895-.447A1.5 1.5 0 0 1 12 4.882V4h-2v1.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V4zm4-1h2v-.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5V3zm4 11h-4v.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V14zm-8 0H2v.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V14z"/>
    </svg>
        <p class="card-text">En este modulo podrá consultar las citas agendadas.</p>
        <a href="consultar_citas.php" class="btn btn-success">Consultar Citas</a>
      </div>
    </div>
  </div>
  <div class="col-sm-3" >
    <div class="card">
    <div class="card-body" style="text-align: center;">
    <i class="bi bi-x-circle"></i>
    <svg xmlns="http://www.w3.org/2000/svg" width="250" height="40"  fill="#A93226" class="bi bi-x-circle" viewBox="0 0 16 16" >
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
        <p class="card-text">En este modulo podrá cancelar las citas agendadas.</p>
        <a href="cancelar_citas.php" class="btn btn-warning" >Cancelar citas</a>
      </div>
    </div>
  </div>
  <?php }?>
        </div>  

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>
</html>

