<?php 
    namespace VideoClub;
    
    class CintaVideo extends Soporte{

        private int $duracion;

        public function __construct(string $titulo, int $numero, float $precio, int $duracion){
            parent::__construct($titulo,$numero,$precio);
            $this->duracion=$duracion;
        }

        public function muestraResumen():void{
            parent::muestraResumen();
            echo "Pelicula en VHS:<br>";
            echo $this->titulo . "<br>";
            echo $this->getPrecio() . " € (IVA no incluido)";
            echo "Duracion: " . $this->duracion . " minutos";
        }
    }
?>
