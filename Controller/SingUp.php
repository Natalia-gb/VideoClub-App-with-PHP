<?php 
    if($_POST){
        session_start();
        if($_POST["password"] == $_POST["confirm-password"] && strlen($_POST["password"]) >= 8 && isset($_POST["name"]) && isset($_POST["user"]) && isset($_POST["email"])){
            include_once ("DatabaseConect.php");
            try{
                $conexion = new PDO(DSN , USER, PASS);
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,); 
                
                $sql = "SELECT * FROM cliente WHERE usuario = ? OR email = ?";
                $sentencia = $conexion->prepare($sql);

                $data = [
                    $_POST["user"],
                    $_POST["email"]
                ];
                $sentencia->execute($data);

                if ($sentencia->rowCount() == 0){
                   
                    $user = [
                        $_POST["name"],
                        3,
                        $_POST["user"],
                        password_hash($_POST["password"],PASSWORD_DEFAULT),
                        $_POST["email"]
                    ];
                    
                    $sql = "INSERT INTO cliente(nombre,maxAlquilerConcurrente,usuario,contrasenia,email) VALUES (?,?,?,?,?)";
                    $sentencia = $conexion->prepare($sql);
                    $sentencia->execute($user);

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
                        }     
                    } 
                    echo "<meta http-equiv='Refresh' content='0.01;url=../View/MainPage.php'>";

                    
                }
                
                
            }catch(PDOException $e){
                echo "Fallo de conexión " . $e->getMessage();
            }
        }else{
            echo "<script>alert('Las contraseñas no coinciden')</script>";
        }
    }
    echo "<meta http-equiv='Refresh' content='0.1;url=../View/SingUp.html'>";
?>