<?php
session_start();
require 'conexion.php';

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

            $idRolPacientes = 5;
            $sqlInsertUsuario = "INSERT INTO usuarios (estadoUsuario, tipoDocumento, numeroDocumento, nombres, apellidos, pasword, correo, Roles_idRoles, idPaciente) VALUES ('Activo', ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsertUsuario = mysqli_prepare($conn, $sqlInsertUsuario);
            mysqli_stmt_bind_param($stmtInsertUsuario, "ssssssii", $tipoDocumento, $numeroDocumento, $nombres, $apellidos, $hashedPassword, $correo, $idRolPacientes, $idPaciente);

            if (mysqli_stmt_execute($stmtInsertUsuario)) {
                $successMessage = "Usuario creado correctamente.";
            } else {
                echo "Error al insertar el usuario en la tabla 'usuarios'.";
            }
        } else {
            echo "Error al insertar el paciente en la tabla 'paciente'.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.html">Brackets Odontologia y Ortodoncia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/servicios.html">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/contactenos.html">Contactenos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" >Iniciar sesion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
                        <input type="text" class="form-control" id="nombres"  placeholder="Escriba sus nombres" name="nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos </label>
                        <input type="text" class="form-control" id="apellidos"  placeholder="Escriba sus apellidos" name="apellidos" required>
                    </div>
                    <div class="col-md-7">
                        <label for="correo" class="form-label">Correo electronico </label>
                        <input type="email" class="form-control" id="correo"  placeholder="usuario@example.com" name="correo" required>
                    </div>
                    <div class="col-md-5">
                        <label for="pasword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pasword" name="pasword">
                    </div>
                    <div class="col-md-5">
                        <label for="celularPaciente" class="form-label">Numero de celular </label>
                        <input type="number" class="form-control" id="celularPaciente"  placeholder="3124567890" name="celularPaciente" required>
                    </div>
                    <div class="col-md-7">
                        <label for="direccionPaciente" class="form-label">Dirección </label>
                        <input type="text" class="form-control" id="direccionPaciente"  placeholder="Escriba su dirección" name="direccionPaciente">
                    </div>
                    <div class="col-md-7">
                        <label for="nombreContactoEmergencia" class="form-label">Nombres Contacto de emergencia </label>
                        <input type="text" class="form-control" id="nombreContactoEmergencia"  placeholder="Nombres" name="nombreContactoEmergencia" required>
                    </div>
                    <div class="col-md-5">
                        <label for="celularContactoEmergencia" class="form-label">Celular Contacto de emergencia </label>
                        <input type="number" class="form-control" id="celularContactoEmergencia"  placeholder="Numero de celular" name="celularContactoEmergencia" required>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Acepto terminos y condiciones.
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit">Registrarse</button>
                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Usuario creado correctamente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tu usuario ha sido creado correctamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.href = 'iniciar_sesion.php'">Iniciar sesión</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php if (!empty($successMessage)) : ?>
        document.addEventListener("DOMContentLoaded", function () {
            var successModal = new bootstrap.Modal(document.getElementById("successModal"));
            successModal.show();
        });
        <?php endif; ?>
    </script>
</body>
</html>
