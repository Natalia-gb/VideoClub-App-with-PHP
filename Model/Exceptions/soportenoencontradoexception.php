<?php 
    namespace VideoClub\Exceptions;
    include_once("videoclubexception.php");
    use \VideoClub\Exceptions\VideoClubException;
    class SoporteNoEncontradoException extends VideoClubException{
        function msg(){echo "<br>No es posible encontrar el soporte o no existe  <br>";}
    }
?>