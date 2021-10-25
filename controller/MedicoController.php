<?php

class MedicoController{
    private $medicoModel;
    private $printer;
	
    public function __construct($medicoModel,$printer){
		$this->medicoModel = $medicoModel;
        $this->printer=$printer;
    }

    public function show(){
        echo $this->printer->render("view/registroView.html");
    }
   
   
   public function turno(){
		$centrosMedicos = $this->medicoModel->dameCentros();
		$data["centrosMedicos"] = $centrosMedicos;
		$data["mensaje"] = "";
		
         echo $this->printer->render("view/turnoView.html", $data);
    }
	
	
	    public function procesarTurno()
    {
		
		
         $data = array(
            'id_centro' => $_POST['id_centro'],
            'fecha' => $_POST['fecha'], 
            'id_usuario' => $_SESSION["id_usuario"], 
        );

        $this->medicoModel->crearTurno($data);
	$data["mensaje"] = "Turno solicitado Correctamente";
		$centrosMedicos = $this->medicoModel->dameCentros();
		$data["centrosMedicos"] = $centrosMedicos;

         echo $this->printer->render("view/turnoView.html", $data);

    }
	
	
	
	
}