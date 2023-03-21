<?php 
    namespace VideoClub\Exceptions;
    use Exception;
    class VideoClubException extends Exception{
        function msg(){echo "<br>Algo ha salido mal.<br>";}
    }
?>