<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document</title>
    <?php 
    session_start();
    if (!isset($_SESSION["usuario"])) {echo "<meta http-equiv='Refresh' content='0.01;url=../View/SingUp.html'>";} ?>
</head>
<body class="bg-dark text-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="MainPage.php">VideoClub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="MainPage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="Rent.php">Alquilar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Controller/SingOut.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row float-start m-3">
            <form class="d-flex" role="search" action="" method="POST">
                <input class="form-control me-2" type="search" placeholder="Nombre del producto" aria-label="Search" name="palabra">
                <button class="btn btn-outline-success" type="submit" name="buscador">Buscar</button>
            </form>
        </div>
        
        <div class="row float-start m-3 w-100">
            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Número</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Alquilar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                                
                            include_once "../Controller/DatabaseConect.php"; 

                            try{
                                $conexion = new PDO(DSN, USER, PASS);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $sql = "SELECT * FROM soporte LEFT JOIN alquileres ON alquileres.numeroSoporte = soporte.numero ORDER BY fechaAlquiler DESC";
                                    
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                $sentencia -> execute();

                                // Buscar por nombre
                                if(isset($_POST["buscador"])){
                                        $producto = $_POST["palabra"];
                                        $consulta = "SELECT * FROM soporte WHERE titulo LIKE '%". $producto ."%'";
                                        $sentencia_buscada = $conexion -> prepare($consulta);
                                        $sentencia_buscada -> setFetchMode(PDO::FETCH_ASSOC);
                                        $sentencia_buscada -> execute();
                                        while ($row = $sentencia_buscada -> fetch()){
                                            
                                        }
                                }

                                while($fila = $sentencia -> fetch()){
                                    echo "<tr>
                                        <td>".$fila["titulo"]."</td>
                                        <td>".$fila["numero"]."</td>
                                        <td>".$fila["precio"]."</td>
                                        <td>".($fila["fechaDevolución"]==null && $fila["fechaAlquiler"]!=null? 
                                        "Este soporte ya está alquilado" : 
                                        "<form action='../Controller/Rent.php' method='post'>
                                        <input type='hidden' value='".$_SESSION["usuario"]["numero"]."' name='user'>
                                        <input type='hidden' value='".$fila["numero"]."' name='soporte'>
                                        <input class='btn btn-danger' type='submit' value='Alquilar'></form>")."</td>
                                        </tr>
                                    ";
                                                
                                }
                                            

                                }catch(PDOException $e){
                                    echo $e -> getMessage();
                                }

                            ?>
                    </tr>
                </tbody>
            </table>
        </div>
    
    </div>
</body>
</html>