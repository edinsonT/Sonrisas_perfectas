<?php 

function isNull ($tipoDocumento, $numeroDocumento, $nombrePaciente, $ApellidosPaciente, $celularPaciente, $correoPaciente, $nombreContactoEmergencia, $celularContactoEmergencia){
    if(strlen (trim($tipoDocumento)) < 1 || strlen (trim($numeroDocumento)) < 1 || strlen (trim($nombrePaciente)) < 1 ||strlen (trim($ApellidosPaciente)) < 1 ||strlen (trim($celularPaciente)) < 1 ||strlen (trim($correoPaciente)) < 1 ||strlen (trim($nombreContactoEmergencia)) < 1 ||strlen (trim($celularContactoEmergencia)) < 1)
    {
        return true ;
    }else{
        return false;

    }
}



?>