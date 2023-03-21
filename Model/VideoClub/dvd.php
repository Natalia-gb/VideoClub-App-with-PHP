<?php 
    namespace VideoClub;

    class Dvd extends Soporte{

        public array $idiomas;
        public string $formatoPantalla;
        
        public function __construct(string $titulo, int $numero, float $precio, array $idiomas, string $formatoPantalla){
            parent::__construct($titulo,$numero,$precio);
            $this->idiomas = $idiomas;
            $this->formatoPantalla = $formatoPantalla;
        }

        public function muestraResumen():void {
            parent::muestraResumen();
            echo "Pelicula en DVD:<br>";
            echo $this->titulo . "<br>";
            echo $this->getPrecio() . "€ (IVA no incluido)<br>";
            echo "Idiomas: ";
            for($i = 0 ; $i < count($this->idiomas) ; $i++ ){echo $this->idiomas[$i].(($i == (count($this->idiomas)-1))?"<br>":",");}
            echo "Formato Pantalla:".$this->formatoPantalla;
        }
    }
?>
