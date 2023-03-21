<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Página de inicio</title>
    <?php 
    session_start();
    if (!isset($_SESSION["usuario"])) {echo "<meta http-equiv='Refresh' content='0.01;url=../View/SingUp.html'>";}?>
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
                            <a class="nav-link active" href="MainPage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Rent.php">Alquilar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Controller/SingOut.php">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>   
        
        <?php

            include_once "../Controller/DataBaseConect.php";

            try{

                $conexion = new PDO(DSN, USER, PASS);
                $conexion-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM alquileres inner join soporte on soporte.numero = alquileres.numeroSoporte WHERE numeroCliente='".$_SESSION["usuario"]["numero"]."' AND fechaDevolución IS NULL ORDER BY fechaAlquiler";

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                $sentencia -> execute();

                $alquileres = $sentencia -> fetchAll();

                echo "<p class='d-flex justify-content-center'>Hola " . $_SESSION["usuario"]["nombre"] . ", usted puede alquilar una cantidad máxima de " . $_SESSION["usuario"]["maxAlquilerConcurrente"] . " soportes simultáneos</p>";

                if (count($alquileres) > 0){
                    echo "<h2 class='d-flex justify-content-center mt-4'> Alquileres actuales </h2>";
                    echo "<div class='d-flex justify-content-center'><table class='table table-striped table-hover table-dark w-50'>";
                    echo "<thead><tr><th scope='col'>Soporte</th><th scope='col'>Fecha de alquiler</th><th scope='col'>Devolver</th></tr></thead>";

                    foreach($alquileres as $alquiler){
                        echo "<tr><td>" . $alquiler["titulo"] . "</td>";
                        echo "<td>" . $alquiler["fechaAlquiler"] . "</td>";
                        echo "<td>
                            <form action='../Controller/Return.php' method='post'>
                            <input type='hidden' name='numeroCliente' value='".$alquiler["numeroCliente"]."'/>
                            <input type='hidden' name='numeroSoporte' value='".$alquiler["numeroSoporte"]."'/>
                            <input type='hidden' name='fechaAlquiler' value='".$alquiler["fechaAlquiler"]."'/><button class='btn btn-secondary'>Devolver</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                }

                $sql = "SELECT * FROM alquileres inner join soporte on soporte.numero = alquileres.numeroSoporte WHERE numeroCliente='".$_SESSION["usuario"]["numero"]."' AND fechaDevolución IS NOT NULL ORDER BY fechaAlquiler";

                $sentencia = $conexion -> prepare($sql);
                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                $sentencia -> execute();

                $alquileres = $sentencia -> fetchAll();

                if (count($alquileres) > 0){
                    echo "<h2 class='d-flex justify-content-center mt-4'> Histórico de alquileres </h2>";
                    echo "<div class='d-flex justify-content-center'><table class='table table-striped table-hover table-dark w-50'>";
                    echo "<thead><th scope='col'>Soporte</th><th scope='col'>Fecha de alquiler</th><th scope='col'>Fecha de devolución</th></thead>";

                    foreach($alquileres as $alquiler){
                        echo "<tr><td>" . $alquiler["titulo"] . "</td>";
                        echo "<td>" . $alquiler["fechaAlquiler"] . "</td>";
                        echo "<td>" . $alquiler["fechaDevolución"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table></div>";
                }


                
                

            } catch(PDOException $e){
                echo $e -> getMessage();
            }
        ?>
    </div>
</body>
</html>