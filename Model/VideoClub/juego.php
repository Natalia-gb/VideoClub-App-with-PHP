<?php
    namespace VideoClub;
    
    class Juego extends Soporte{

        public string $consola;
        private int $minNumJugadores;
        private int $maxNumJugadores;

        public function __construct(string $titulo, int $numero, float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores){
            parent::__construct($titulo,$numero,$precio);
            $this->consola=$consola;
            $this->minNumJugadores=$minNumJugadores;
            $this->maxNumJugadores=$maxNumJugadores;
        }

        public function muestraJugadoresPosibles():string{
            if($this->minNumJugadores == 1 && $this->maxNumJugadores == $this->minNumJugadores){ return "Para un jugador";}
            else if ($this->minNumJugadores == $this->maxNumJugadores){return "Para " . $this->minNumJugadores . " jugadores";}
            else {return "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores;}
        }

        public function muestraResumen():void{
           parent::muestraResumen();
           echo "Juego para: " . $this->consola . "<br>";
           echo $this->titulo . "<br>";
           echo $this->getPrecio() . " € (IVA no incluido)<br>";
           echo $this->muestraJugadoresPosibles();
        }
    }
?>
