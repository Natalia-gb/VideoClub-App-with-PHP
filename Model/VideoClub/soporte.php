<?php
    namespace VideoClub;
    include_once ("resumible.php");
    use VideoClub\Resumible;
    abstract class Soporte implements Resumible{
    
        public string $titulo;
        protected int $numero;
        private float $precio;
        private const IVA = 1.21;
        public bool $alquilado;

        public function __construct(string $titulo, int $numero, float $precio){
            $this->titulo = $titulo;
            $this->numero = $numero;
            $this->precio = $precio;
            $this->alquilado = false;
        }

        public function getPrecio():float{return $this->precio;}

        public function getPrecioConIVA():float{return $this->precio*self::IVA;}

        public function getNumero():int{return $this->numero;}

        public function isAlquilado():bool{return $this->alquilado;}

        public function setAlquilado($bool):void{$this->alquilado=$bool;}

        public function muestraResumen():void{
            echo "<b>" . $this->titulo . "</b><br>";
            echo "Precio: " . $this->precio . "<br>";
            echo "Precio IVA incluido: " . $this->getPrecioConIVA() . " euros<br>";
            echo "Estado de alquiler: " . (($this->alquilado)?"Alquilado":"No Alquilado");
            echo "<br>";
        }
    }
?>