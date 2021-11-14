<?php

class ReservaController{
    private $reservaModel;
    private $createMedicoModel;
    private $printer;
	
	
    public function __construct($createMedicoModel,$reservaModel,$printer){
		$this->createMedicoModel = $createMedicoModel;
		$this->reservaModel = $reservaModel;
        $this->printer=$printer;
    }

    public function show(){
        if (isset($_SESSION["id_usuario"])) {
			
			$dameNivel = $this->createMedicoModel->dameNivel($_SESSION["id_usuario"]);
			if(count($dameNivel)>0){
            $this->solicitarReserva();
			}else{
			 header("Location: /mvc-gaucho-rocket/medico");
			}
			
        }else{
            header("Location: /mvc-gaucho-rocket/login");
        }
    }
    public function solicitarReserva(){
		$destinos = $this->reservaModel->dameDestinos();
		$data["destinos"] = $destinos;
		$data["mensaje"] = "";
		echo $this->printer->render("view/solicitarReservaView.html", $data);
	}
	public function procesarDisponibilidad(){
            $data=$this->reservaModel->buscarDisponibilidadDeVuelo($_GET["origen"],$_GET["destino"]);
			$nivel=$this->createMedicoModel->dameNivel($_SESSION["id_usuario"]);
            if ($data!=[]){
                $data["vuelos"]=$data;
                $data["titulo"]=$this->titulo("Vuelos disponibles", $_GET["origen"], $_GET["destino"]);
				$data["nivel"]=$nivel;

                echo $this->printer->render("view/vuelosView.html", $data);
            }else{
                $data["titulo"]=$this->titulo("No hay disponibilidad", $_GET["origen"], $_GET["destino"]);
                $data["vuelos"]=$this->reservaModel->vuelosDisponibles();
                $data["vuelosDisponibles"]="Vuelos disponibles";
								$data["nivel"]=$nivel;

                echo $this->printer->render("view/vuelosView.html", $data);
            }
    }
    public function titulo($titulo, $origen, $destino){
        $data["titulo"]=$titulo;
        $data["origenDestino"]=$this->reservaModel->nombreDestino($origen)." - ".$this->reservaModel->nombreDestino($destino);
        $data["idOrigen"]=$origen;
        $data["idDestino"]=$destino;
        return $data;
    }
    public function seleccionarCabinas(){
        $equipo=$this->reservaModel->datosVuelo($_POST["vuelo"]);
        $data["cabina"]=$this->reservaModel->dameCabinas();
        $data["servicio"]=$this->reservaModel->dameServiciosDeABordo();
        $data["vuelo"]=$_POST["vuelo"];
        echo $this->printer->render("view/seleccionarCabinaView.html", $data);
    }
    public function seleccionarAsiento(){
		 
            $this->mostrarAsientos($_POST["vuelo"],$_POST["cabina"],$_POST["servicio"], "");
    }
    public function mostrarAsientos($vuelo,$cabina,$servicio,$msg){
        $data["mensaje"]=$msg;
        $data["vuelo"] =$this->reservaModel->datosVuelo($vuelo);
        $data["cabina"]=$this->reservaModel->cabina($cabina);
        $data["servicio"] =$this->reservaModel->servicio($servicio);
        $data["asientos"]=$this->reservaModel->asientos($vuelo, $cabina);
		var_dump($data["asientos"]);
         echo $this->printer->render("view/seleccionarAsientoView.html", $data);
    }

    public function realizarReserva(){
        $disponible=$this->reservaModel->estadoAsiento($_POST["asiento"]);
        if ($disponible[0]["estado"]=="disponible"){
			$nivel=$this->createMedicoModel->dameNivel($_SESSION["id_usuario"]);
			$nivelVuelo=$nivel[0]["nivel"];
            $vuelo=$this->reservaModel->datosVuelo($_POST["vuelo"]);
            $codigoReserva=time();

            $data = array(
                'fecha' => $vuelo[0]["fecha"],
                'usuario' => $_SESSION["id_usuario"],
                'idVuelo' => $_POST["vuelo"],
                'idCabina' => $_POST["cabina"],
                'codigoReserva' => $codigoReserva,
                'asiento' => $_POST["asiento"],
                'idServicio' => $_POST["servicio"],    
				'nivel' => $nivelVuelo
            );

            $this->reservaModel->realizarReserva($data);
            header("Location: /mvc-gaucho-rocket/misReservas");
        }else{
            $msg="El asiento no esta disponible.";
            $this->mostrarAsientos($_POST["vuelo"],$_POST["cabina"],$_POST["servicio"], $msg);
        }
    }
}