<?php

session_start(); 
require "conexion.php";

if ($_POST) {
    $correo = $_POST['correo'];

 
    $password = sha1($_POST['pasword']); 

    $sql = "SELECT correo, pasword, Roles_idRoles FROM usuarios WHERE correo = '$correo'";

    $result = mysqli_query($conn, $sql);
    $num = $result->num_rows;
    
    if ($num > 0) {
        $row = $result->fetch_array();
        $storedPassword = $row['pasword'];

   
        if ($password === $storedPassword) {
            $_SESSION['id'] = $row['idUsuario'];
      
            $_SESSION['rol'] = $row['Roles_idRoles'];
            
            $_SESSION['correo'] = $row['correo'];

            header("Location: inicio.php");
            exit();
        } else {
            echo "La contraseña no es válida";
        }
    } else {
        echo "El usuario no existe";
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
            <p>Somos una empresa líder en el sector de la odontología, especializados en el área de ortodoncia. </p>
            <div class="row vh-90 justify-content-center align-items-center">
                <div class="card text-center" style="width: 35rem;" >
                    <br>
                    <div class="card-header">
                        <h4 style="text-align: center;">Inicia sesión</h4>
                        <br>
                    <div class="row">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
                   
                            <div class="mb-3">
                              <label for="correo" class="form-label">Correo</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name="correo" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                              <label for="pasword" class="form-label">Contraseña</label>
                              <input type="password" class="form-control" name="pasword" id="pasword" required>
                            </div>

                    
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
           
                            <div>
                                <a href="cambiar_contrasena.php" class="card-link">¿Olvido su contraseña?</a>
                                <a href="registro.php" class="card-link">Registrarse</a>
                            </div>
                            
                          </form>
                        </div>    
                    </div>

            </div>
            
                </div>
                    
            </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>                       
</body>
</html>