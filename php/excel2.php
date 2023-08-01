<?php
session_start();
require "conexion.php";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_citas.xls");

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

<table class="table">
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
