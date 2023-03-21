<?php 
    if($_POST){
        if(isset($_POST["password"]) && isset($_POST["user"])){
            include_once ("DatabaseConect.php");
            
            session_start();

            try{
                $conexion = new PDO(DSN , USER, PASS);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,); 
                
                $sql = "SELECT * FROM cliente WHERE usuario = ?";
                $sentencia = $conexion->prepare($sql);
                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                $user = [$_POST["user"]];
                $sentencia->execute($user);
                if ($sentencia->rowCount() == 1){
                    $usu = $sentencia->fetch();
                    if ($_POST["user"] == $usu["usuario"] && password_verify($_POST["password"], $usu["contrasenia"])){
                        $_SESSION['usuario'] = $usu; 
                        echo "<meta http-equiv='Refresh' content='0.01;url=../View/MainPage.php'>";
                    }else{
                        echo "<script>alert('Credenciales inválidos')</script>";
                    }     
                    
                } 
            }catch(PDOException $e){
                echo "Fallo de conexión " . $e->getMessage();
            }
        }
    }
    echo "<meta http-equiv='Refresh' content='0.1;url=../View/LogOn.html'>";
?>