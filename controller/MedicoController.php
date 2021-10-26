<?php

class MedicoController{
    private $medicoModel;
    private $printer;
	
    public function __construct($medicoModel,$printer){
		$this->medicoModel = $medicoModel;
        $this->printer=$printer;
    }

    public function show(){

        if(isset ($_SESSION["id_usuario"])){
            $turno=$this->medicoModel->tieneTurnoActual($_SESSION["id_usuario"], "fecha actual");
            if ($turno!=[]){
                if ($turno[0]["estado"]=="En espera"){
                    //Realizar chequeo
                    $this->realizarChequeo();
                }elseif ($turno[0]["estado"]=="Chequeo realizado"){
                    //Mostrar vista de chequeo realizado con el codigo de viajero=columna 'nivel' de la tabla turnos
                    $this->chequeoRealizado();
                }
            }else{
                //solicitar turno
                $this->solicitarTurno();
            }
        }
        else{
            header("Location: /mvc-gaucho-rocket/login");
        }
    }
   
   
   public function turno(){
	   /*este metodo se remplazo por solicitarTurno() */
		$centrosMedicos = $this->medicoModel->dameCentros();
		$data["centrosMedicos"] = $centrosMedicos;
		$data["mensaje"] = "";
		
         echo $this->printer->render("view/turnoView.html", $data);
    }
	
	
	   public function resultadoChequeo(){
		$resultado = $this->medicoModel->dameTurno($_GET['id_turno']);
		$data["resultado"] = $resultado;
		$data["mensaje"] = "";
		
         echo $this->printer->render("view/resultadoView.html", $data);
    }
	
	
	
	    public function procesarTurno()
    {
		
         $data = array(
            'id_centro' => $_POST['id_centro'],
            'fecha' => $_POST['fecha'], 
            'id_usuario' => $_SESSION["id_usuario"], 
        );

        $id_turno=$this->medicoModel->crearTurno($data);
		$data["mensaje"] = "";
	 
		$data["id_turno"] = $id_turno;

         echo $this->printer->render("view/linkEmailTurnoView.html", $data);

    }
	
	
		
	    public function confirmarTurno()
    {
		$id_turno=$_POST['id_turno'] ;
         $data = array(
            'id_turno' => $id_turno
        );

        $turno=$this->medicoModel->dameTurno($id_turno);
		$data["mensaje"] = "Turno realizado con éxito.";
		$data["turno"] =  $turno;
		$data["nombre"] = $_SESSION["nombre"];
		$data["apellido"] = $_SESSION["apellido"];
		$data["email"] = $_SESSION["email"];
		
         echo $this->printer->render("view/turnoConfirmadoView.html", $data);

    }
	
	


    /*Metodos de MedicoController.php*/
    public function solicitarTurno(){

	$centrosMedicos = $this->medicoModel->dameCentros();
		$data["centrosMedicos"] = $centrosMedicos;
		$data["mensaje"] = "";

		$data=$this->dameDatosUsuario($data);
         echo $this->printer->render("view/turnoView.html", $data);

	}


	function dameDatosUsuario($data){
		$data["nombre"] = $_SESSION["nombre"];
		$data["apellido"] = $_SESSION["apellido"];
		$data["email"] = $_SESSION["email"];
		return $data;
	}

    public function realizarChequeo(){
        echo "realizarChequeo";
    }
    public function chequeoRealizado(){
        echo "chequeoRealizado";
    }
	
	
	
	
}