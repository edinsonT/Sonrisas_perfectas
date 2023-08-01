<?php
session_start();
require "conexion.php";

// Verificar si se ha proporcionado un ID de agenda válido
if (isset($_GET['idAgenda'])) {
    $idAgendaSeleccionada = $_GET['idAgenda'];
} else {
    header("Location: agendas_disponibles.php");
    exit();
}

// Función para reservar la cita
function reservarCita($conn, $idPaciente, $idAgenda, $horaCita) {
    $fechaActual = date("Y-m-d");
    $sql = "INSERT INTO citas (Paciente_idPaciente, estadoCita, fechaCita, horaCita, Agenda_idAgenda) 
            VALUES ($idPaciente, 'Asignada', '$fechaActual', '$horaCita', $idAgenda)";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error al reservar la cita: " . mysqli_error($conn));
    }

    // Actualizar el número de citas disponibles en la agenda
    $sql = "UPDATE agenda SET numeroDeCitas = numeroDeCitas - 1 WHERE idAgenda = $idAgenda";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Error al actualizar el número de citas disponibles: " . mysqli_error($conn));
    }

    // Redireccionar al usuario a la página de inicio después de reservar la cita
    header("Location: inicio.php?cita_reservada=true&fecha=$fechaActual&hora=$horaCita");
    exit();
}

// Procesar el formulario para reservar la cita
if (isset($_POST['submit'])) {
    // Obtener el ID del paciente desde la sesión
    if (isset($_SESSION['idPaciente'])) {
        $idPaciente = $_SESSION['idPaciente'];
    } else {
        // Si el ID del paciente no está definido, redirigir a la página de inicio
        header("Location: inicio.php");
        exit();
    }

    // Obtener los datos del formulario
    $horaCita = $_POST['hora_cita'];

  
    // Reservar la cita
    reservarCita($conn, $idPaciente, $idAgendaSeleccionada, $horaCita);

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonrisas Perfectas - Reservar Cita</title>
    <!-- Agregar la librería de Bootstrap al inicio de la página -->
    <!-- Puedes incluirlo localmente o usar un enlace CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Reservar Cita</h2>
        <form method="post">
            <label for="hora_cita">Seleccione la Hora de la Cita:</label>
            <input type="time" id="hora_cita" name="hora_cita" min="<?php echo $agenda['horaInicio']; ?>" max="<?php echo $agenda['horaFin']; ?>" step="1800" required>
            <input type="hidden" name="idAgenda" value="<?php echo $idAgendaSeleccionada; ?>">
            <button type="submit" name="submit">Reservar Cita</button>
        </form>
    </div>

    <!-- Agregar los scripts de Bootstrap al final de la página -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
