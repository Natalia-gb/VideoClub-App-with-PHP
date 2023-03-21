<?php 
    namespace VideoClub;

    class Cliente {
        
        private int $numero;
        public string $nombre;
        private string $usuario;
        private array $soportesAlquilados;
        private int $numSoportesAlquilados;
        private int $maxAlquilerConcurrente;

        // public function getUser(): string { return $this->user; }
        // public function getPassword(): string { return $this->password; }
        // public function verifyPassword($pass): bool { return password_verify($pass,$this->password);}
    

        public function __construct(string $nombre, int $numero, int $maxAlquilerConcurrente){
            $this->nombre = $nombre;
            $this->numero = $numero;
            $this->soportesAlquilados = [];
            $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        }

        function getNumero():int{return $this->numero;}

        function setNumero(int $numero):void{$this->numero = $numero;}

        public function getName(): string { return $this->name; }

        function getNumSoportesAlquilados():int{return count($this->soportesAlquilados);}

        function getMaxAlquilerConcurrente():int{return $this->maxAlquilerConcurrente;}

        function alquilar(Soporte $soporte):bool{
            if(!in_array($soporte, $this->soportesAlquilados) && $this->maxAlquilerConcurrente > count($this->soportesAlquilados)){
                $soporte->alquilado=true;
                $this->soportesAlquilados[] = $soporte;
                echo "<br>" . $soporte->titulo . " alquilado";
                return true;
            }else{
                echo "<br>No se ha podido alquilar " . $soporte->titulo;
                return false;
            }
        }
        
        function tieneAlquilado(Soporte $soporte):bool{return in_array($soporte,$this->soportesAlquilados);}

        function devolver(int $numSoporte):bool{
            $flag = false;
            for($i =  0 ; $i < count($this->soportesAlquilados) ; $i++){
                if ($this->soportesAlquilados[$i]->getNumero() == $numSoporte){
                    $this->soportesAlquilados[$i]->alquilado=false;
                    $this->soportesAlquilados[$i] = null;
                    $this->numSoportesAlquilados--;
                    $flag = true;
                    break;
                }
            }
            return $flag;
        }

        function listarAlquileres():void{
            foreach($this->soportesAlquilados as $soporte){
                if(isset($soporte)){echo $soporte->muestraResumen() . "<br>";};
            }
        }

        function muestraResumen():void{
            echo $this->nombre . "  cliente Nº: " . $this->numero . "<br>";
            echo "Has alquilado un total de " . $this->numSoportesAlquilados . " soportes<br>";
            echo $this->listarAlquileres();
        }
    }
?>


