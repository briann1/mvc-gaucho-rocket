<?php

class ReservaModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }
 
     public function dameDestinos(){
		 $SQL = "SELECT * FROM  destinos ";
        return $this->database->query($SQL);
    }
	
	     public function dameCabinas(){
		 $SQL = "SELECT * FROM  cabina ";
        return $this->database->query($SQL);
    }
	
 
	 
	
		public function buscarDisponibilidad($data){
		
		$fecha=$data['fecha'];
        $origen=$data['origen']; 
        $destino=$data['destino'];
		$nivel=null;
		
		 $SQL = "SELECT vuelo.*,nave.*
			FROM  vuelo
			left join nave on (vuelo.id_nave=nave.id_nave) 
			where vuelo.id_origen=$origen and  vuelo.id_destino=$destino and fecha='$fecha'
		 ";
		 
 		 return $this->database->query($SQL);
		}
		
			
		public function dameCabinasDelVuelo($data){
		
		$id_vuelo=$data['vuelo']; 
		$id_cabina=$data['cabina']; 
 		
		 $SQL = "SELECT vuelo.*,nave_cabina.*
			FROM  vuelo
			left join nave_cabina on (vuelo.id_nave=nave_cabina.id_nave) 
			where vuelo.id_vuelo=$id_vuelo and  nave_cabina.id_cabina=$id_cabina  
		 ";
		 
 		 return $this->database->query($SQL);
		}
		
	
	
  

}