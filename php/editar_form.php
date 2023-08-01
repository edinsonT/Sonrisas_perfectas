<?php 
session_start();    
require 'conexion.php';

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
            <b>Bienvenido (a)</b> Nombre del usuario
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Cambiar Contraseña</a></li>
            <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5">

<?php include("Agenda_creada.php")?>

    <h1 style="text-align: center;">Editar Agenda</h1>
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Editar agendas
                    <a href="consultas_agenda.php" class="btn btn-danger float-end"> Regresar</a>
                  </h4>
                <div class="card-body">
                    <?php 
                    if(isset($_GET['idAgenda']))
                    {
                        $agendaId = mysqli_real_escape_string($conn, $_GET['idAgenda']) ;
                        $sql = "SELECT * FROM agenda WHERE idAgenda= '$agendaId'";
                        $result = mysqli_query($conn, $sql);
  
                        if(mysqli_num_rows($result) > 0)
                        {
                            $idAgenda = mysqli_fetch_array ($result );
                            
                            ?>
                            <form action="crear_agenda.php" method="POST">

                                

                                <div class="col-mb-3">
                                    <label for="idAgenda" class="col-sm-1 col-form-label">Id Agenda</label>
                                    <input type="number" class="form-control" id="idAgenda" value="<?=$idAgenda['idAgenda'];?>" name='idAgenda' required>
                                </div>   

                                <div class="col-mb-3">
                                    <label for="estadoAgenda" class="col-sm-1 col-form-label">Estado</label>
                                        <select id="estadoAgenda" class="form-select" value="<?=$idAgenda['estadoAgenda'];?>" name="estadoAgenda" required>
                                            <option >Abierta</option>
                                            <option>Cancelada</option>
                                        </select>   
                                </div> 
                                <div class="col-mb-3">
                                    <label for="numeroDeCitas" class="col-sm-1 col-form-label">Numero de citas</label>
                                    <input type="number" class="form-control" id="numeroDeCitas" value="<?=$idAgenda['numeroDeCitas'];?>" name='numeroDeCitas' required>
                                </div>   
                                <div class="col-mb-3">
                                    <label for="diasHabilitados" class="col-sm-1 col-form-label">Días habilitados</label>
                                    <input type="date" class="form-control" id="diasHabilitados" value="<?=$idAgenda['diasHabilitados'];?>"name='diasHabilitados' required>
                                </div>
                                <div class="col-mb-3">
                                    <label for="horaInicio" class="col-sm-1 col-form-label">Hora Inicio</label>
                                    <input type="time" class="form-control" id="horaInicio" value="<?=$idAgenda['horaInicio'];?>" name='horaInicio' required>
                                </div>
                                <div class="col-mb-3">
                                    <label for="horaFin" class="col-sm-1 col-form-label">Hora fin</label>
                                    <input type="time" class="form-control" id="horaFin" value="<?=$idAgenda['horaFin'];?>" name='horaFin' required>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <button type="sumbit" class="btn btn-primary" name='update_agenda'>Editar  Agenda</button>
                            
                                </div>   

                            </form>
                        <?php 
            }        
            else
            {
            echo "<h4> No se encontro agenda</h4>";
        }

    }
    ?>   


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

