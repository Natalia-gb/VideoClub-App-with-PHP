<?php 
    namespace VideoClub\Exceptions;
    include_once("videoclubexception.php");
    use \VideoClub\Exceptions\VideoClubException;
    class SoporteYaAlquiladoException extends VideoClubException{
        function msg(){echo "<br>El soporte solicitado ya esta alquilado <br>";}
    }
?>