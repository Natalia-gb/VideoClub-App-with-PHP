<?php 
    session_start();
    include_once "DatabaseConect.php";

    $date = new DateTime();

    $rent= [
        $_POST["user"],
        $_POST["soporte"],
        $date->format("Y-m-d")
    ];

    try{
        $conexion = new PDO(DSN , USER, PASS);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,);

        $sql = "INSERT INTO alquileres(numeroCliente, numeroSoporte, fechaAlquiler) VALUES (?,?,?)";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute($rent);

    }catch(PDOException $e){
        echo "Fallo de conexión " . $e->getMessage();
    }

    echo "<meta http-equiv='Refresh' content='0.1;url=../View/Rent.php'>";


?>