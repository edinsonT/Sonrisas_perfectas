
<?php 
session_start();  
require "conexion.php";

if (isset($_POST['eliminar_agenda'])) {
    $agendaId = mysqli_real_escape_string($conn, $_POST['eliminar_agenda']);

   
    mysqli_autocommit($conn, false);

    $sqlDeleteCitas = "DELETE FROM citas WHERE Agenda_idAgenda = '$agendaId'";
    $resultDeleteCitas = mysqli_query($conn, $sqlDeleteCitas);

  
    if ($resultDeleteCitas) {
        $sqlDeleteAgenda = "DELETE FROM agenda WHERE idAgenda='$agendaId'";
        $resultDeleteAgenda = mysqli_query($conn, $sqlDeleteAgenda);

        if ($resultDeleteAgenda) {

            mysqli_commit($conn);
            $_SESSION['message'] = "Agenda eliminada correctamente";
        } else {
  
            mysqli_rollback($conn);
            $_SESSION['message'] = "Error al eliminar la agenda";
        }
    } else {
    
        mysqli_rollback($conn);
        $_SESSION['message'] = "Error al eliminar registros en la tabla 'citas'";
    }

    mysqli_autocommit($conn, true); 

    header("Location: consultas_agenda.php");
    exit(0);
}





if(isset($_POST['update_agenda']))
{
  $agendaId = mysqli_real_escape_string($conn,$_POST['idAgenda']);
  $idAgenda = mysqli_real_escape_string($conn,$_POST['idAgenda']); 
  $estadoAgenda = mysqli_real_escape_string($conn,$_POST['estadoAgenda']); 
  $numeroDeCitas = mysqli_real_escape_string($conn,$_POST['numeroDeCitas']); 
  $diasHabilitados = mysqli_real_escape_string($conn,$_POST['diasHabilitados']); 
  $horaInicio = mysqli_real_escape_string($conn,$_POST['horaInicio']); 
  $horaFin = mysqli_real_escape_string($conn,$_POST['horaFin']);

  $sql = "UPDATE agenda SET  idAgenda= '$idAgenda', estadoAgenda= '$estadoAgenda', numeroDeCitas='$numeroDeCitas', diasHabilitados='$diasHabilitados', horaInicio='$horaInicio', horaFin='$horaFin' WHERE idAgenda= '$agendaId'";

   $result = mysqli_query($conn, $sql);

   if($result)
   {
    $_SESSION['message']= "Agenda actualizada correctamente";
    header("Location: consultas_agenda.php");
    exit(0);
   }
   else
   {
    $_SESSION['message']= "Agenda no actualizada correctamente";
    header("Location: consultas_agenda.php");
    exit(0);
   }

}

if(isset($_POST['guardar_Age']))
{
  
  $idAgenda = mysqli_real_escape_string($conn,$_POST['idAgenda']); 
  $estadoAgenda = mysqli_real_escape_string($conn,$_POST['estadoAgenda']); 
  $numeroDeCitas = mysqli_real_escape_string($conn,$_POST['numeroDeCitas']); 
  $diasHabilitados = mysqli_real_escape_string($conn,$_POST['diasHabilitados']); 
  $horaInicio = mysqli_real_escape_string($conn,$_POST['horaInicio']); 
  $horaFin = mysqli_real_escape_string($conn,$_POST['horaFin']); 

  $sql = "INSERT INTO agenda (idAgenda, estadoAgenda, numeroDeCitas, diasHabilitados, horaInicio, horaFin) VALUES ('$idAgenda','$estadoAgenda', '$numeroDeCitas', '$diasHabilitados', '$horaInicio', '$horaFin')";

  $result = mysqli_query($conn, $sql);
  if($result)
  {
    $_SESSION['message']= "Agenda creada correctamente";
    header("Location: Agenda_form.php");
    exit(0);

  }
  else{
    $_SESSION['message']= "Agenda no se pudo crear correctamente";
    header("Location: Agenda_form.php");
    exit(0);
  }

}


?>

