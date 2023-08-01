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
    <title>Agendas disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/extilos.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
      <a class="navbar-brand" href="inicio.php">Gestión De Citas Odontologicas</a>
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
            </ul>
          </li>
        </ul>
      </div>
    </div>
</nav>
<br>
<div class="container mt-5">

  <?php include('Agenda_creada.php')?>

  <h1 style="text-align: center;">Agendas disponibles</h1>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>Agendas Creadas
                  <a href="Agenda_form.php" class="btn btn-primary float-end">Crear Agenda</a>
                  <a href="excel1.php" class="icon-link" >
                  <i class="bi bi-file-earmark-excel-fill"></i>
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel-fill" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z"/>
                    </svg>
                  </a>
            </div>
              
              <div class="card-body">              
              <table class="table table-bordered table-striped ">         
                <thead>
                    <tr>
                        <th>ID Agenda</th>
                        <th>Estado Agenda</th>
                        <th>Numero De Citas</th>
                        <th>Días Habilitados</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql = "SELECT * FROM agenda";
                  $result = $result = mysqli_query($conn, $sql);
                  
                  if(mysqli_num_rows($result) > 0)
                  {
                    foreach($result as $agenda){
                      ?>
                       <tr>
                            <td><?php echo $agenda['idAgenda']; ?></td>
                            <td><?php echo $agenda['estadoAgenda']; ?></td>
                            <td><?php echo $agenda['numeroDeCitas']; ?></td>
                            <td><?php echo $agenda['diasHabilitados']; ?></td>
                            <td><?php echo $agenda['horaInicio']; ?></td>
                            <td><?php echo $agenda['horaFin']; ?></td>
                            <td>
                              <a href="editar_form.php?idAgenda=<?= $agenda['idAgenda']; ?>"class="btn btn-success btn-sm">Editar Agendas</a>                             
                              <form action="crear_agenda.php" method="POST" class="d-inline">
                                <button type="submit" name="eliminar_agenda" value="<?=$agenda ['idAgenda']; ?>" href="eliminar.php" class="btn btn-danger btn-sm">Eliminar agenda</a>

                              </form>
                              

                            </td>
                           


                      <?php 
                      
                    }

                  }else{
                    echo "No se puedo consultar las agendas";
                  }

                  ?>
                  </tr>
                </tbody>
            </table>
            </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



</body>
</html>