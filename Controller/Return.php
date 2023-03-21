<?php 
    session_start();
    include_once "../Controller/DatabaseConect.php";
    try{ 
        var_dump($_POST); 
        $conexion = new PDO(DSN, USER, PASS); 
        $conexion-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
        $sql = "UPDATE alquileres SET fechaDevolución = ? WHERE numeroCliente = ? AND numeroSoporte = ? AND fechaAlquiler = ? "; 
        $sentencia = $conexion -> prepare($sql); 
    
        $fechaDevolución = new DateTime(); 
        $fechaAlquiler = $_POST["fechaAlquiler"]; 
        $numeroCliente = $_POST["numeroCliente"]; 
        $numeroSoporte = $_POST["numeroSoporte"];
    
        $isOk = $sentencia -> execute([$fechaDevolución->format("Y-m-d"),$numeroCliente,$numeroSoporte,$fechaAlquiler]); 
    
    } catch(PDOException $e){ 
        echo $e -> getMessage(); 
    }
    echo "<meta http-equiv='Refresh' content='0.1;url=../View/MainPage.php'>";


?>