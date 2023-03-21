<?php  
    session_start();
    session_destroy();
    echo "<meta http-equiv='Refresh' content='0.01;url=../View/LogOn.html'>";
?>