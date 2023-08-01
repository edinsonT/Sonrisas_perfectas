<?php
session_start();
require 'conexion.php';

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

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $celularPaciente = $_POST['celularPaciente'];
    $correo = $_POST['correo'];
    $pasword = $_POST['pasword'];
    $hashedPassword = sha1($pasword);
    $nombreContactoEmergencia = $_POST['nombreContactoEmergencia'];
    $celularContactoEmergencia = $_POST['celularContactoEmergencia'];
    $direccionPaciente = $_POST['direccionPaciente'];

    $sqlCheckPaciente = "SELECT idPaciente FROM paciente WHERE numeroDocumento = ?";
    $stmtCheckPaciente = mysqli_prepare($conn, $sqlCheckPaciente);
    mysqli_stmt_bind_param($stmtCheckPaciente, "s", $numeroDocumento);
    mysqli_stmt_execute($stmtCheckPaciente);
    $resultCheckPaciente = mysqli_stmt_get_result($stmtCheckPaciente);

    if (mysqli_num_rows($resultCheckPaciente) > 0) {
        echo "Error: El paciente con el número de documento '$numeroDocumento' ya existe.";
        exit;
    } else {
        $sqlInsertPaciente = "INSERT INTO paciente (tipoDocumento, numeroDocumento, nombres, apellidos, celularPaciente, correo, pasword, nombreContactoEmergencia, celularContactoEmergencia, direccionPaciente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertPaciente = mysqli_prepare($conn, $sqlInsertPaciente);
        mysqli_stmt_bind_param($stmtInsertPaciente, "ssssssssss", $tipoDocumento, $numeroDocumento, $nombres, $apellidos, $celularPaciente, $correo, $pasword, $nombreContactoEmergencia, $celularContactoEmergencia, $direccionPaciente);

        if (mysqli_stmt_execute($stmtInsertPaciente)) {
            $idPaciente = mysqli_insert_id($conn);

            $idRolSecretaria = 2;
            $sqlInsertUsuario = "INSERT INTO usuarios (estadoUsuario, tipoDocumento, numeroDocumento, nombres, apellidos, pasword, correo, Roles_idRoles, idPaciente) VALUES ('Activo', ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsertUsuario = mysqli_prepare($conn, $sqlInsertUsuario);
            mysqli_stmt_bind_param($stmtInsertUsuario, "ssssssii", $tipoDocumento, $numeroDocumento, $nombres, $apellidos, $hashedPassword, $correo, $idRolSecretaria, $idPaciente);

            if (mysqli_stmt_execute($stmtInsertUsuario)) {
                $successMessage = "Usuario creado correctamente.";
            } else {
                echo "Error al insertar el usuario en la tabla 'usuarios'.";
            }
        } else {
            echo "";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sonrisas Perfectas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/extilos.css">
</head>
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

<body>

    <div class="container mt-5">
        <h2 style="text-align: center;">Brackets Odontologia y Ortodoncia</h2>
        <p>Somos una empresa líder en el sector de la odontología, especializados en el área de ortodoncia.</p>
        <div class="row vh-90 justify-content-center align-items-center">
            <div class="card text-center" style="width: 55rem;">

                <br>
                <form class="row g-3" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="col-md-4">
                        <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                        <select class="form-select" name="tipoDocumento" id="tipoDocumento" required>
                            <option selected disabled value="">Seleccione</option>
                            <option>C.C</option>
                            <option>C.E</option>
                            <option>T.I</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="numeroDocumento" class="form-label">Numero de documento</label>
                        <input type="number" class="form-control" id="numeroDocumento" name="numeroDocumento" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombres" class="form-label">Nombres </label>
                        <input type="text" class="form-control" id="nombres" placeholder="Escriba sus nombres" name="nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" placeholder="Escriba sus apellidos" name="apellidos" required>
                    </div>
                    <div class="col-md-6">
                        <label for="celularPaciente" class="form-label">Celular</label>
                        <input type="number" class="form-control" id="celularPaciente" placeholder="Escriba su numero de celular" name="celularPaciente" required>
                    </div>
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" placeholder="Escriba su correo" name="correo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pasword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pasword" placeholder="Escriba su contraseña" name="pasword" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombreContactoEmergencia" class="form-label">Nombre del contacto de emergencia</label>
                        <input type="text" class="form-control" id="nombreContactoEmergencia" placeholder="Escriba el nombre del contacto de emergencia" name="nombreContactoEmergencia" required>
                    </div>
                    <div class="col-md-6">
                        <label for="celularContactoEmergencia" class="form-label">Celular del contacto de emergencia</label>
                        <input type="number" class="form-control" id="celularContactoEmergencia" placeholder="Escriba el numero del contacto de emergencia" name="celularContactoEmergencia" required>
                    </div>
                    <div class="col-md-6">
                        <label for="direccionPaciente" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccionPaciente" placeholder="Escriba su direccion" name="direccionPaciente" required>
                    </div>
                    <br>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                    </div>
                </form>
                <br>

                <br>
                <br>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Correcto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $successMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="redirectToInicio()">Ir a Inicio</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php if (!empty($successMessage)) : ?>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById("successModal"));
                successModal.show();
            });

            function redirectToInicio() {
                window.location.href = 'inicio.php';
            }
        <?php endif; ?>
    </script>
</body>

</html>
