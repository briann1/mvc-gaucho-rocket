<?php

class RegistroController{
    private $registroModel;
    private $printer;
	
    public function __construct($registroModel,$printer){
		$this->registroModel = $registroModel;
        $this->printer=$printer;
    }

    public function validar(){
		 $data["codigo_alta"] = $_GET["codigo_alta"];
         echo $this->printer->render("view/validarView.html", $data);
    }
	
	
	    public function verificacion(){
		        $data["codigo_alta"] = $_GET["codigo_alta"];
         echo $this->printer->render("view/verificacionView.html", $data);
    }
	
	public function resultadoVerificacion(){
		        $data["pass"] = $_POST["pass"];
		        $data["email"] = $_POST["email"];
				$data["codigo_alta"] = $_POST["codigo_alta"];
				$valido = $this->registroModel->getValidoCodigoAlta($data["codigo_alta"],$data["email"],$data["pass"]);
				if(!$valido){
				$data["mensaje"] = "Ingreso algun dato incorrecto";
 				}else{
				$data["muestroForm"] ="NO";
				$idUsuario=$valido[0]["id"] ;
				$actualicoCodigoAlta = $this->registroModel->getactualicoCodigoAlta($idUsuario);
 				$data["mensaje"] = "Felicitaciones,ya puede ingresar al sistema.";


				}
         echo $this->printer->render("view/verificacionView.html", $data);
    }
}