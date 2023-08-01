<?php
session_start();
require "conexion.php";

$correo = $_SESSION['correo'];
$rol = $_SESSION['rol'];
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


if (isset($_POST['cancelar'])) {
    $id_cita = $_POST['id_cita'];


    $sql = "SELECT * FROM citas WHERE idcitas = $id_cita AND Paciente_idPaciente = (SELECT idPaciente FROM paciente WHERE correo = '$correo') AND estadoCita = 'Asignada'";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($resultado) > 0) {
     
      $sql = "UPDATE citas SET estadoCita = 'Cancelada' WHERE idcitas = $id_cita";
      $resultado = mysqli_query($conn, $sql);


        if ($resultado) {
            $mensaje_cita = "La cita ha sido cancelada correctamente.";
            $_SESSION['mensaje_cita'] = $mensaje_cita;
        } else {
            $mensaje_cita = "Error al cancelar la cita: " . mysqli_error($conn);
            $_SESSION['error_cita'] = $mensaje_cita;
        }
    } else {
        $mensaje_cita = "La cita con ID $id_cita no existe, no pertenece al paciente o ya ha sido cancelada.";
        $_SESSION['error_cita'] = $mensaje_cita;
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

    <title>Cancelar Cita</title>
  
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
        <h2 class="page-title">Sonrisas Perfectas</h2>
    <p>El sistema de Gestión de Odontológica permite administrar la información de los pacientes, tratamientos y citas a través de una interfaz web </p>
    <hr>
    <h4 style="text-align: start;">Citas Asignadas</h4>
    <?php 
    if (isset($_SESSION['mensaje_cita'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['mensaje_cita'] . '</div>';
        unset($_SESSION['mensaje_cita']);
    }

    if (isset($_SESSION['error_cita'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_cita'] . '</div>';
        unset($_SESSION['error_cita']);
    }
    ?>
    <?php 
   
    $sql = "SELECT * FROM citas WHERE Paciente_idPaciente = (SELECT idPaciente FROM paciente WHERE correo = '$correo') AND estadoCita = 'Asignada'";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    ?>
     <table class="table table-bordered table-striped table-citas">
        <thead>
            <tr>
                <th>Cita ID</th>
                <th>Estado Cita</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cita = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo $cita['idcitas']; ?></td>
                <td><?php echo $cita['estadoCita']; ?></td>
                <td><?php echo $cita['fechaCita']; ?></td>
                <td><?php echo $cita['horaCita']; ?></td>
                <td><?php echo $nombres; ?></td>
                <td>
                    <form method="post" action="cancelar_citas.php">
                        <input type="hidden" name="id_cita" value="<?php echo $cita['idcitas']; ?>">
                        <button type="submit" class="btn btn-danger" name="cancelar">Cancelar Cita</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="inicio.php" class="btn btn-primary">Volver</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
