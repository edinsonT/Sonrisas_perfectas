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


$sql = "SELECT * FROM agenda WHERE estadoAgenda = 'Abierta'";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'submit_') === 0) {
            $agendaId = substr($key, strlen('submit_'));
            $horaCita = $_POST['hora_cita'][$agendaId]; 

      
            $sql = "SELECT idPaciente FROM paciente WHERE correo = '$correo'";
            $resultado = mysqli_query($conn, $sql);

            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            $fila = mysqli_fetch_assoc($resultado);
            $idPaciente = $fila['idPaciente'];

            $sql = "SELECT numeroDeCitas, diasHabilitados FROM agenda WHERE idAgenda = $agendaId";
            $resultado = mysqli_query($conn, $sql);

            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            $fila = mysqli_fetch_assoc($resultado);
            $numeroDeCitas = $fila['numeroDeCitas'];
            $diasHabilitados = $fila['diasHabilitados'];

            if ($numeroDeCitas > 0) {
     
                $fechaActual = date("Y-m-d");

             
                $sql = "INSERT INTO citas (Paciente_idPaciente, estadoCita, fechaCita, horaCita, Agenda_idAgenda) VALUES ('$idPaciente', 'Asignada', '$diasHabilitados', '$horaCita', $agendaId)";
                $resultado = mysqli_query($conn, $sql);

           
                $sql = "UPDATE agenda SET numeroDeCitas = numeroDeCitas - 1 WHERE idAgenda = $agendaId";
                $resultado = mysqli_query($conn, $sql);

                if (!$resultado) {
                    die("Error al actualizar el número de citas disponibles: " . mysqli_error($conn));
                }

                $mensaje_cita = "¡Cita reservada con éxito! Fecha: $diasHabilitados, Hora: $horaCita"; 
                $_SESSION['mensaje_cita'] = $mensaje_cita;
            } else {
                $mensaje_cita = "Lo sentimos, no hay citas disponibles en esta agenda.";
                $_SESSION['mensaje_cita'] = $mensaje_cita;
            }

            header("Location: inicio.php");
            exit();
        }
    }
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
<div class="container mt-5">
<h2 style="text-align: center;">Sonrisas Perfectas</h2>

<p>El sistema de Gestión de Odontológica permite administrar la información de los pacientes, tratamientos y citas a través de una interfaz web </p>
        
      
        <hr>
    
        <div class="row">
        <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
              <h4 style="text-align:left;">Por favor seleccione una Cita</h4>
              </div>
        <form method="post">
        <div class="card-body">              
              <table class="table table-bordered table-striped ">   
            <tr>
                <th>Agenda ID</th>
                <th>Día Cita</th>
                <th>Citas disponibles</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Seleccione la Hora de la Cita</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php while ($agenda = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?php echo $agenda['idAgenda']; ?></td>
            <td><?php echo $agenda['diasHabilitados']; ?></td>
            <td><?php echo $agenda['numeroDeCitas']; ?></td>
            <td><?php echo $agenda['horaInicio']; ?></td>
            <td><?php echo $agenda['horaFin']; ?></td>
            
            <td>
                <select name="hora_cita[<?php echo $agenda['idAgenda']; ?>]">
                    <?php
                    $horaInicio = strtotime($agenda['horaInicio']);
                    $horaFin = strtotime($agenda['horaFin']);
                    while ($horaInicio <= $horaFin) {
                        $hora = date('H:i', $horaInicio);
                        echo "<option value='$hora'>$hora</option>";
                        $horaInicio += 1800; 
                    }
                    ?>
                </select>
                <input type="hidden" name="dias_habilitados[<?php echo $agenda['idAgenda']; ?>]" value="<?php echo $agenda['diasHabilitados']; ?>">
                <input type="hidden" name="id_agenda[<?php echo $agenda['idAgenda']; ?>]" value="<?php echo $agenda['idAgenda']; ?>">
            </td>
            <td>
                <button type="submit" name="submit_<?php echo $agenda['idAgenda']; ?>" class="btn btn-primary">Apartar Cita</button>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>
    </table>
</form>

        <a href="inicio.php" class="btn btn-primary">Volver</a>
    </div>
</div>
</div>
</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
