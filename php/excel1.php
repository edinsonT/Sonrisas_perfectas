<?php 
require "conexion.php";


header("Content-Type: application(xls)");
header("Content-Disposition: attachment; filename= reporte_agenda.xls");



?>

<table class="table table-bordered table-striped ">         
                <thead>
                    <tr>
                        <th>ID Agenda</th>
                        <th>Estado Agenda</th>
                        <th>Numero De Citas</th>
                        <th>Días Habilitados</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
             
                    </tr>
                </thead>
                <tbody>
                  <?php 
                  $sql = "SELECT * FROM agenda";
                  $result = $result = mysqli_query($conn, $sql);
                  
                  if(mysqli_num_rows($result) > 0)
                  {
                    foreach($result as $agenda){
                      ?>
                       <tr>
                            <td><?php echo $agenda['idAgenda']; ?></td>
                            <td><?php echo $agenda['estadoAgenda']; ?></td>
                            <td><?php echo $agenda['numeroDeCitas']; ?></td>
                            <td><?php echo $agenda['diasHabilitados']; ?></td>
                            <td><?php echo $agenda['horaInicio']; ?></td>
                            <td><?php echo $agenda['horaFin']; ?></td>
                            <td>
                             
                              

                            </td>
                           


                      <?php 
                      
                    }

                  }else{
                    echo "No se puedo consultar las agendas";
                  }

                  ?>
                  </tr>
                </tbody>
            </table>