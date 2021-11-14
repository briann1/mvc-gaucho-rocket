<?php

class misReservasController{
    private $misReservasModel;
    private $printer;
    private $pdf;
    public function __construct($pdf,$misReservasModel, $printer){
        $this->pdf=$pdf;
        $this->misReservasModel=$misReservasModel;
        $this->printer=$printer;
    }
    public function show(){
        if (isset($_SESSION["id_usuario"])){
            $data["reservas"]=$this->misReservasModel->misReservas($_SESSION["id_usuario"]);
            echo $this->printer->render("view/misReservasView.html", $data);
        }else{
            header("Location: /mvc-gaucho-rocket/login");
        }
    }
	
	
	    public function pdf(){
			$id_reserva=$_GET["id_reserva"];
        if (isset($_SESSION["id_usuario"])){
            $data["reservas"]=$this->misReservasModel->miReservas($id_reserva);
             
			echo $this->printer->render("view/imprimirComprobanteView.html", $data);
			 $this->pdf->generarPdf();
        }else{
            header("Location: /mvc-gaucho-rocket/login");
        }
		}
	
	
	
	
}