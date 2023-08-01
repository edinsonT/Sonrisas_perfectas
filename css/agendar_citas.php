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

// Consulta para obtener las agendas disponibles
$sql = "SELECT idAgenda, horaInicio, horaFin, fechaAgenda, numeroDeCitas FROM agenda WHERE estadoAgenda = 'Abierta'";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Si el paciente ha seleccionado una cita, procesar el formulario
if (isset($_POST['submit'])) {
    $idAgendaSeleccionada = $_POST['id_agenda'];
    $horaCita = $_POST['hora_cita'];
    $fechaCita = $_POST['fecha_cita']; // Nueva variable para la fecha seleccionada

    // Obtener el ID del paciente basado en el correo
    $sql = "SELECT idPaciente FROM paciente WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $fila = mysqli_fetch_assoc($resultado);
    $idPaciente = $fila['idPaciente'];

    // Verificar si la agenda tiene citas disponibles
    $sql = "SELECT numeroDeCitas FROM agenda WHERE idAgenda = $idAgendaSeleccionada";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $fila = mysqli_fetch_assoc($resultado);
    $numeroDeCitas = $fila['numeroDeCitas'];

    if ($numeroDeCitas > 0) {
        // Insertar la nueva cita en la tabla citas
        $sql = "INSERT INTO citas (Paciente_idPaciente, estadoCita, fechaCita, horaCita, Agenda_idAgenda) VALUES ('$idPaciente', 'Asignada', '$fechaCita', '$horaCita', $idAgendaSeleccionada)";
        $resultado = mysqli_query($conn, $sql);

        if (!$resultado) {
            die("Error al reservar la cita: " . mysqli_error($conn));
        }

        // Actualizar el número de citas disponibles en la agenda
        $sql = "UPDATE agenda SET numeroDeCitas = numeroDeCitas - 1 WHERE idAgenda = $idAgendaSeleccionada";
        $resultado = mysqli_query($conn, $sql);

        if (!$resultado) {
            die("Error al actualizar el número de citas disponibles: " . mysqli_error($conn));
        }

        $mensaje_cita = "¡Cita reservada con éxito! Fecha: $fechaCita, Hora: $horaCita";
        $_SESSION['mensaje_cita'] = $mensaje_cita;
    } else {
        $mensaje_cita = "Lo sentimos, no hay citas disponibles en esta agenda.";
        $_SESSION['mensaje_cita'] = $mensaje_cita;
    }

    header("Location: inicio.php");
    exit();
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
    <!-- Resto del contenido -->
    <?php
    // Variable para contar las citas mostradas en la fila actual
    $citas_en_fila = 0;
    // Variable para definir cuántas citas se mostrarán en una fila
    $citas_por_fila = 4;
    ?>

    <form method="post">
        <div class="row">
            <?php while ($agenda = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Agenda ID: <?php echo $agenda['idAgenda']; ?></p>
                            <p class="card-text">Hora Inicio: <?php echo $agenda['horaInicio']; ?></p>
                            <p class="card-text">Hora Fin: <?php echo $agenda['horaFin']; ?></p>
                            <label for="fecha_cita">Seleccione la Fecha de la Cita:</label>
                            <input type="date" id="fecha_cita" name="fecha_cita" min="<?php echo date('Y-m-d'); ?>" required>
                            <label for="hora_cita">Seleccione la Hora de la Cita:</label>
                            <input type="time" id="hora_cita" name="hora_cita" min="<?php echo $agenda['horaInicio']; ?>" max="<?php echo $agenda['horaFin']; ?>" step="1800" required>
                            <input type="hidden" name="id_agenda" value="<?php echo $agenda['idAgenda']; ?>">
                            <button type="submit" name="submit" class="btn btn-primary">Seleccionar Cita</button>
                        </div>
                    </div>
                </div>
                <?php
                $citas_en_fila++;
                // Si ya se han mostrado 4 citas en la fila actual, cerrar la fila y abrir una nueva
                if ($citas_en_fila == $citas_por_fila) {
                    echo '</div>'; // Cerrar la fila actual
                    echo '<div class="row">'; // Abrir una nueva fila
                    $citas_en_fila = 0; // Reiniciar el contador de citas en la fila
                }
                ?>
            <?php endwhile; ?>
        </div> <!-- Cerrar la última fila si no se cerró anteriormente -->
    </form>
    <?php if ($citas_en_fila > 0) : ?>
        </div>
    <?php endif; ?>

    <a href="inicio.php" class="btn btn-primary">Volver</a>
</div>
<!-- ... -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

