<?php 
    namespace VideoClub\Exceptions;
    include_once("videoclubexception.php");
    use \VideoClub\Exceptions\VideoClubException;
    class CupoSuperadoException extends VideoClubException{
        function msg(){echo "<br>Superas el maximo de alquileres concurrentes  <br>";}
    }
?>