<?php

namespace App\Controllers;

use App\Libraries\fpdf183\fpdf;

# Library personalization 
class PDF extends FPDF {
	function Header() {
		$this->image('https://wizardcalculator.com/Installations/installationsHeader.png',0,0,$this->GetPageWidth());
		$this->Ln(20);
	}

	function Footer() {
		$this->SetY(-24);
		$this->SetFont('Times','',9);
		$this->Cell(0,5,'Client Initial __________________',0,1,'C');
		$this->SetY(-13);
		$this->Cell(0,5, $this->PageNo(),0,0,'C');
	}
}

class PdfGenerator extends BaseController {

    private $proposal;
    private $pdf;

    public function __construct($proposal) {
        $this->proposal = $proposal;
    }

    public function printPDF() {
        $this->pdf = new PDF();
        $this->pdf->setAutoPageBreak(true,27);
        $this->pdf->addPage();

        $saunas = $this->proposal->getSaunas();
        if(!empty($saunas)) {
            $this->pdf->SetFont('Times','B',12);
            $this->pdf->Cell(0,10,$this->proposal->getPrjName() . ' Proposal for Commercial Sauna Room(s)',0,1,'C');
            
            $this->pdf->SetFont('Times','B',9);
            $this->pdf->SetX(25);
            $this->pdf->Cell(55,8,'  Project Name: ' . $this->proposal->getPrjName(),1,0);
            $this->pdf->Cell(55,8,'  Shipping Address: ' . $this->proposal->getShippingAddress(),1,0);
            $this->pdf->Cell(55,8,'  Zip code: ' . $this->proposal->getZip(),1,1);
            $this->pdf->SetX(25);
            $this->pdf->Cell(55,8,'  Bid Date: ' . $this->proposal->getDate(),1,0);
            $this->pdf->Cell(55,8,'  Expires 30 days from Bid Date',1,0);
            $this->pdf->Cell(55,8,'  Quote by: ' . $this->proposal->getAuthor(),1,1);
            $this->pdf->Ln(10);
            $this->pdf->SetFont('Times','',9);
            
            foreach($saunas as $sauna) {
                $this->printSaunaRoomAndEquipmentTable($sauna);
                
                $upgrades = $sauna->getAccessories();
                if(!empty($upgrades)) {
                    $this->pdf->Cell(100,5,':)',0,0);
                    $this->printSelectedUpgradesTable($upgrades);
                }
                
                //$this->printsaunaTotalTable($sauna);
            }
            $this->printAllSaunasTotalTable();
        }

        $this->printTermsAndConditions();

        $this->pdf->Output();
    }

    private function printSaunaRoomAndEquipmentTable($sauna) {
        //------------------ Table header ------------------
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(0,10,'SAUNA ROOM AND EQUIPMENT',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Model', 1, 0);
        $this->pdf->Cell(15,8,'  Qty', 1, 0);
        $this->pdf->Cell(80,8,'  Description', 1, 0);
        $this->pdf->Cell(30,8,'  Price', 1, 1);
        //--------------------------------------------------
        //------------------ PC ------------------
        $description = $this->getPcDescription($sauna);
        $description_substrs = str_split($description, 57);
        $cell_height = count($description_substrs) * 5;
        $this->pdf->SetX(25);
        $this->pdf->SetFont('Times','',9);
        $this->pdf->Cell(40,$cell_height,'  ' . $sauna->getPc(), 1, 0);
        $this->pdf->Cell(15,$cell_height,'  1', 1, 0);
        $y_pos = $this->pdf->getY();
        $this->pdf->Cell(80,$cell_height,'', 1, 0);
        $this->pdf->SetY($y_pos);
        for($i=0; $i<count($description_substrs); $i++) {
            $line = $description_substrs[$i];
            if($i+1 < count($description_substrs)) {
                $next_line = $description_substrs[$i+1];
            }
            if(ctype_alpha($line[strlen($line) - 1]) && ctype_alpha($next_line[0])) {
                $line .= '-';
            }
            $this->pdf->SetX(80);
            $this->pdf->Cell(80,5,'  ' . $line, 0, 1);
        }
        $this->pdf->SetY($y_pos);
        $this->pdf->setX(160);
        $this->pdf->Cell(30,$cell_height,'  $' . number_format($sauna->getInitPrice()), 1, 1);
        //----------------------------------------
        //------------------ Door ------------------
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,10,'  Door', 1, 0);
        $this->pdf->Cell(15,10,'  1', 1, 0);
        $y_pos = $this->pdf->GetY();
        $this->pdf->Cell(80,10,'', 1, 0);
        $this->pdf->SetY($y_pos);
        $this->pdf->SetX(80);
        $this->pdf->Cell(80,5,'  36" x 80" cedar framed door w/26" x 61" glass with rough',0,1);
        $this->pdf->SetX(80);
        $this->pdf->Cell(80,5,'  opening - 38" x 82".',0,1);
        $this->pdf->SetY($y_pos);
        $this->pdf->SetX(160);
        $this->pdf->Cell(30,10,'  included', 1, 1);
        //------------------------------------------
        //------------------ Heater ------------------
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,15,'  Heater ' . $sauna->getPc(), 1, 0);
        $this->pdf->Cell(15,15,'  1', 1, 0);
        $y_pos = $this->pdf->GetY();
        $this->pdf->Cell(80,15,'', 1, 0);
        $this->pdf->SetY($y_pos);
        $this->pdf->SetX(80);
        $this->pdf->Cell(80,5,'  Ultra-Sauna heater model ' . $sauna->getHeaterWatt() . '208/240v, 1/3 phase, 100%',0,1);
        $this->pdf->SetX(80);
        $this->pdf->Cell(80,5,'  stainless steel with solid rock-tray allows water to be poured',0,1);
        $this->pdf->SetX(80);
        $this->pdf->Cell(80,5,'  over rocks without damaging elements.',0,1);
        $this->pdf->SetY($y_pos);
        $this->pdf->SetX(160);
        $this->pdf->Cell(30,15,'  included', 1, 1);
        //--------------------------------------------
        //------------------ Control ------------------
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Control', 1, 0);
        $this->pdf->Cell(15,8,'  1', 1, 0);
        $this->pdf->Cell(80,8,'  Sauna control box w/60 minute timer.', 1, 0);
        $this->pdf->Cell(30,8,'  included', 1, 1);
        //---------------------------------------------
        //------------------ Accessories ------------------
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Accessories', 1, 0);
        $this->pdf->Cell(15,8,'  1', 1, 0);
        $this->pdf->Cell(80,8,'  Bucket, Ladle, Thermometer and Light Fixture.', 1, 0);
        $this->pdf->Cell(30,8,'  included', 1, 1);
        //-------------------------------------------------
        //------------------ Subtotal ------------------
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(135,8,'  Subtotal - Sauna Room and Equipment:',1,0);
        $this->pdf->Cell(30,8,'  $' . number_format($sauna->getInitPrice()),1,1);
        //----------------------------------------------
        $this->pdf->Ln(10);
    }

    private function printSelectedUpgradesTable($upgrades) {
        //------------------ Table header ------------------
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(0,10,'Selected Upgrades',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Product Name', 1, 0);
        $this->pdf->Cell(10,8,'  Qty', 1, 0);
        $this->pdf->Cell(55,8,'  Description', 1, 0);
        $this->pdf->Cell(30,8,'  Price E/A', 1, 0);
        $this->pdf->Cell(30,8,'  Total', 1, 1);
        $this->pdf->SetFont('Times','',9);
        $table_content_start_y_pos = $this->pdf->GetY();
        //--------------------------------------------------
        foreach($upgrades as $upgrade) {
            $description = $upgrade->getDescription();
            $description_lines = str_split($description,40);
            $price_ea = round($upgrade->getPrice() / $upgrade->getQty());
            if(count($description_lines) == 1) {
                $cell_height = 8;
            }
            else {
                $cell_height = count($description_lines) * 5;
            }
            $this->pdf->SetX(25);
            $this->pdf->Cell(40,$cell_height,'  ' . $upgrade->getName(), 1, 0);
            $this->pdf->Cell(10,$cell_height,'  ' . $upgrade->getQty(), 1, 0);
            $y_pos = $this->pdf->GetY();
            $this->pdf->Cell(55,$cell_height,'',1,0);
            $this->pdf->Cell(30,$cell_height,'  $' . number_format($price_ea),1,0);
            $this->pdf->Cell(30,8,'  $' . number_format($upgrade->getPrice()), 1, 1);

        }

        
    }

    private function printsaunaTotalTable($sauna) {

    }

    private function printAllSaunasTotalTable() {

    }

    private function printTermsAndConditions(){

    }

    private function getPcDescription($sauna) {
        $description = 'Pre Cut for interior room size ' . $sauna->getWidth() . ' w x' . $sauna->getLength() . ' d x' . $sauna->getHeight() . ' h includes T&G vertically run, ';
        
        switch($sauna->getUpgrade()) {
            case 'ecosauna':
                $description .= 'upgraded to eco-sauna, ';
            break;
            case 'handfinish':
                $description .= 'upgraded hand finish design, ';
            break;
            case 'modular':
                $description .= 'upgraded to modular sauna, ';
            break;
            default:
                $description .= 'western red cedar, euro-trim, ';
        }
        if($sauna->getHasFullLengthBoard()) {
            $description .= 'upgraded full length boards, ';
        }
        
        $description .= 'vapor barrier, one tier back and side wall bench construction with 1x4 rails and tops fastened with stainless steel screws and cedar heater guard rail.';

        if($sauna->getIsCondominium()) {
            $description .= ' Give service to oil the Sauna.';
        }
        
        return $description;
    }

    
}
?>