<?php
session_start();
require 'conexion.php';

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroDocumento = $_POST['numeroDocumento'];
    $newPassword = $_POST['newPassword'];
    $hashedPassword = sha1($newPassword);
    $hashedNewPassword = sha1($newPassword);

   
    $sqlCheckUsuario = "SELECT idUsuario FROM usuarios WHERE numeroDocumento = ? LIMIT 1";
    $stmtCheckUsuario = mysqli_prepare($conn, $sqlCheckUsuario);
    mysqli_stmt_bind_param($stmtCheckUsuario, "s", $numeroDocumento);
    mysqli_stmt_execute($stmtCheckUsuario);
    $resultCheckUsuario = mysqli_stmt_get_result($stmtCheckUsuario);

    if (mysqli_num_rows($resultCheckUsuario) === 1) {
        $row = mysqli_fetch_assoc($resultCheckUsuario);
        $idUsuario = $row['idUsuario'];

        $sqlUpdatePassword = "UPDATE usuarios SET pasword = ? WHERE idUsuario = ?";
        $stmtUpdatePassword = mysqli_prepare($conn, $sqlUpdatePassword);
        mysqli_stmt_bind_param($stmtUpdatePassword, "si", $hashedPassword, $idUsuario);

        if (mysqli_stmt_execute($stmtUpdatePassword)) {
            $successMessage = "Contraseña cambiada correctamente.";
        } else {
            $errorMessage = "Error al cambiar la contraseña.";
        }
    } else {
        $errorMessage = "El usuario con el número de documento proporcionado no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar contraseña</title>
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
        <h2 style="text-align: center;">Cambiar contraseña</h2>
        <div class="row vh-90 justify-content-center align-items-center">
            <div class="card text-center" style="width: 30rem;">
                <br>
                <form class="row g-3" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="col-12">
                        <label for="numeroDocumento" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" required>
                    </div>
                    <div class="col-12">
                        <label for="newPassword" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit">Cambiar contraseña</button>
                        <a href="iniciar_sesion.php"class="btn btn-success">Iniciar sesion</a>
                      
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($errorMessage)) : ?>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error al cambiar la contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $errorMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)) : ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Contraseña cambiada correctamente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¡La contraseña ha sido cambiada correctamente!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                    <a href="iniciar_sesion.php"class="btn btn-success">Iniciar sesion</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        <?php if (!empty($errorMessage)) : ?>
        document.addEventListener("DOMContentLoaded", function () {
            var errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
            errorModal.show();
        });
        <?php endif; ?>

        <?php if (!empty($successMessage)) : ?>
        document.addEventListener("DOMContentLoaded", function () {
            var successModal = new bootstrap.Modal(document.getElementById("successModal"));
            successModal.show();
        });
        <?php endif; ?>
    </script>
</body>
</html>
