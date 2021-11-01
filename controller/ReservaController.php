<?php

class ReservaController{
    private $reservaModel;
    private $printer;
	
    public function __construct($reservaModel,$printer){
		$this->reservaModel = $reservaModel;
        $this->printer=$printer;
    }

    public function show(){

        if(isset ($_SESSION["id_usuario"])){ 
                $this->solicitarReserva(); 
        }
        else{
            header("Location: /mvc-gaucho-rocket/login");
        }
    }
   
   
   
   
       public function solicitarReserva(){

		$destinos = $this->reservaModel->dameDestinos();
		$data["destinos"] = $destinos;
		$data["mensaje"] = "";

          echo $this->printer->render("view/solicitarReservaView.html", $data);

	}
	
	
		
	    public function procesarReserva()
    {
		
         $data = array(
            'origen' => $_POST['origen'],
            'destino' => $_POST['destino'],
            'fecha' => $_POST['fecha'], 
            'id_usuario' => $_SESSION["id_usuario"], 
        );

        $vuelos=$this->reservaModel->buscarDisponibilidad($data);
		$data["mensaje"] = ""; 
		$data["vuelos"] = $vuelos;
		$cantidad=count($vuelos);
		$cabinas=$this->reservaModel->dameCabinas();
		$data["cabinas"] = $cabinas;

		if($cantidad>0){
         echo $this->printer->render("view/seleccionoHorarioView.html", $data);
		}else{
		
		$destinos = $this->reservaModel->dameDestinos();
		$data["destinos"] = $destinos;
		$data["mensaje"] = "No se encontraron vuelos disponibles para los datos ingresados.";
		
         echo $this->printer->render("view/solicitarReservaView.html", $data);			
		}
		
		

    }
	
	
		    public function procesarHorario()
    {
		
         $data = array(
            'vuelo' => $_POST['vuelo'],
            'cabina' => $_POST['cabina'],
             'id_usuario' => $_SESSION["id_usuario"], 
        );

        $cabinasDelVuelo=$this->reservaModel->dameCabinasDelVuelo($data);
        $reservasDeEseVuelo="";
       
		$data["mensaje"] = ""; 
		$data["cabinasDelVuelo"] = $cabinasDelVuelo;
 		 
         echo $this->printer->render("view/seleccionoUbicacionView.html", $data);
	 
		

    }
	
	
	 
}