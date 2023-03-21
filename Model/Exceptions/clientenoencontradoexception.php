<?php 
    namespace VideoClub\Exceptions;
    include_once("videoclubexception.php");
    use \VideoClub\Exceptions\VideoClubException;
    class ClienteNoEncontradoException extends VideoClubException{
        function msg(){echo "<br>No es posible encontrar al cliente o no existe <br>";}
    }
?>