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
    die("Error en la consulta: " . mysqli_error($conn));
}

if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombres = $fila['nombres'];
}

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];
    $newPassword = $_POST['newPassword'];
    $hashedNewPassword = sha1($newPassword);

    $idUsuario = $_SESSION['id']; 

   
    $sqlUpdatePassword = "UPDATE usuarios SET pasword = ? WHERE idUsuario = ?";
    $stmtUpdatePassword = mysqli_prepare($conn, $sqlUpdatePassword);
    mysqli_stmt_bind_param($stmtUpdatePassword, "si", $hashedNewPassword, $idUsuario);

    if (mysqli_stmt_execute($stmtUpdatePassword)) {
        $successMessage = "Contraseña cambiada correctamente.";
    } else {
        $errorMessage = "Error al cambiar la contraseña.";
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
        <h2 style="text-align: center;">Cambiar contraseña</h2>
        <div class="row vh-90 justify-content-center align-items-center">
            <div class="card text-center" style="width: 30rem;">
                <br>
                <form class="row g-3" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="col-12">
                        <label for="documento" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="col-12">
                        <label for="newPassword" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit">Cambiar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
    <?php if (!empty($errorMessage)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($successMessage)) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

 
    <div class="text-center mt-3">
        <a href="inicio.php" class="btn btn-secondary">Volver a Inicio</a>
    </div>
</body>
</html>

