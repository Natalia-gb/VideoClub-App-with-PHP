<?php
    namespace VideoClub;
    
    include_once ("autoload.php");
    include_once ("./exception/clientenoencontradoexception.php");
    include_once ("./exception/soportenoencontradoexception.php");
    include_once ("./exception/soporteyaalquiladoexception.php"); 
    include_once ("./exception/cuposuperadoexception.php");

    use \VideoClub\exception\ClienteNoEncontradoException;
    use \VideoClub\exception\SoporteNoEncontradoException;
    use \VideoClub\exception\SoporteYaAlquiladoexception;
    use \VideoClub\exception\CupoSuperadoexception;
    use \VideoClub\Soporte;
    use \VideoClub\CintaVideo;
    use \VideoClub\Juego; 
    use \VideoClub\Dvd;
    use \VideoClub\Cliente;

    class VideoClub {
        
        private String $nombre;
        private array $productos;
        private int $numProductos;
        private array $socios;
        private int $numSocios; 
        private int $numProductosAlquilados;
        private int $numTotalAlquileres;

        public function __construct(string $nombre){
            $this->nombre = $nombre;
            $this->productos = [];
            $this->numProductos = 0;
            $this->socios = [];
            $this->numSocios  = 0;
        }

        public function getNumProductosAlquilados():int{
            return $this->numProductosAlquilados;
        }

        public function getNumTotalAlquileres():int{
            return $this->numTotalAlquileres;
        }

        private function incluirProducto(Soporte $producto):void{
            $this->productos[] = $producto;
            echo "Incluido producto " . $this->numProductos."<br>";
            $this->numProductos++;
        }

        public function incluirCintaVideo(string $titulo, float $precio, int $duracion):void{
            $nuevaCinta = new CintaVideo($titulo, $this->numProductos, $precio, $duracion);
            $this->incluirProducto($nuevaCinta);
        }

        public function incluirDvd(string $titulo, float $precio, array $idiomas, string $pantalla):void{
            $nuevoDvd = new Dvd($titulo, $this->numProductos, $precio, $idiomas, $pantalla);
            $this->incluirProducto($nuevoDvd);
        }

        public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ):void{
            $nuevoJuego = new Juego($titulo, $this->numProductos, $precio, $consola, $minJ, $maxJ);
            $this->incluirProducto($nuevoJuego);
        }

        public function incluirSocio(string $nombre, int $maxAlquileresConcurrentes = 3):void{
            $nuevoSocio = new Cliente($nombre, $this->numSocios, $maxAlquileresConcurrentes);
            $this->socios[$this->numSocios] = $nuevoSocio;
            echo "Incluido socio ".$this->numSocios."<br>";
            $this->numSocios++;
        }

        public function listarProductos():void{
            echo "Listado de los " . $this->numProductos . " productos disponibles:";
            for($i = 0; $i < $this->numProductos; $i++){
                echo "<br>";
                $this->productos[$i]->muestraResumen();
            }
        }

        public function listarSocios():void{
            echo "Listado de $this->numSocios socios del videoclub:";
            for($i = 0; $i < $this->numSocios; $i++){
                echo "<br>";
                $this->socios[$i]->muestraResumen();
            }
        }

        public function alquilarSocioProducto(int $numeroCliente, int $numeroSoporte): bool{
            try{
                if(!isset($this->socios[$numeroCliente])){
                    throw new ClienteNoEncontradoException();
                }elseif(!isset($this->productos[$numeroSoporte])){
                    throw new SoporteNoEncontradoException();
                }elseif(($this->socios[$numeroCliente]->getMaxAlquilerConcurrente() - $this->socios[$numeroCliente]->getNumSoportesAlquilados()) == 0){
                    throw new CupoSuperadoException(); 
                }elseif(($this->productos[$numeroSoporte]->isAlquilado())){
                    throw new SoporteYaalquiladoException();
                }else{
                    $this->socios[$numeroCliente]->alquilar($this->productos[$numeroSoporte]);
                    return false;
                }
            }catch(ClienteNoEncontradoException|SoporteNoEncontradoException|CupoSuperadoException|SoporteYaalquiladoException $e){
                $e->msg();
                return true;
            }
        }

        public function alquilarSocioProductos(int $numeroCliente, array $numerosProductos){
            foreach($numerosProductos as $producto){
                if ($this->alquilarSocioProducto($numeroCliente, $producto)) {break;};
            }  
        }

        public function devolverSocioProducto(int $numSocio, int $numeroProducto){
            try{
                if(!isset($this->socios[$numSocio])){
                    throw new ClienteNoEncontradoException();
                }elseif(!isset($this->productos[$numeroProducto])){
                    throw new SoporteNoEncontradoException();
                }elseif(!$this->productos[$numeroProducto]->isAlquilado()){
                    throw new SoporteYaalquiladoException();
                }else{
                    $this->socios[$numSocio]->devolver($numeroProducto);
                    return false;
                }
            }catch(ClienteNoEncontradoException|SoporteNoEncontradoException|SoporteYaalquiladoException $e){
                $e->msg();
                return true;
            }
        }

        public function devolverSocioProductos(int $numSocio, array $numerosProductos){
            foreach($numerosProductos as $producto){
                if($this->devolverSocioProducto($numSocio, $producto)) {break;};
            }
        }

    }
?>
