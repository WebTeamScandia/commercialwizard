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
            
            for($i=0;$i<count($saunas);$i++) {
                $sauna = $saunas[$i];
                $this->printSaunaRoomAndEquipmentTable($sauna, $i+1);
                
                $upgrades = $sauna->getAccessories();
                if(!empty($upgrades)) {
                    $this->printSelectedUpgradesTable($upgrades, $i+1);
                }
                //-------------------- Subtotal with selected upgrades --------------------start
                $this->pdf->SetFont('Times','B',9);
                $this->pdf->SetX(25);
                $this->pdf->Cell(105,8,'  Subotal - Sauna Room with selected options:',1,0);
                $this->pdf->Cell(60,8,'$' . number_format($sauna->getPrice()) . '  ',1,1,'R');
                $this->pdf->SetFont('Times','',9);
                //-------------------- Subtotal with selected upgrades --------------------end
                $this->pdf->Ln(10);
            }
            $this->printAllSaunasTotalTable();
        }

        $this->printTermsAndConditions();

        $this->pdf->Output();
    }

    private function printSaunaRoomAndEquipmentTable($sauna, $index) {
        //------------------ Table header ------------------start
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(0,10,'SAUNA ROOM #'. $index .' EQUIPMENT',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Model', 1, 0);
        $this->pdf->Cell(15,8,'  Qty', 1, 0);
        $this->pdf->Cell(80,8,'  Description', 1, 0);
        $this->pdf->Cell(30,8,'  Price', 1, 1);
        //------------------ Table header ------------------end
        //------------------ PC ------------------start
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
        //------------------ PC ------------------end
        //------------------ Door ------------------start
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
        //------------------ Door ------------------end
        //------------------ Heater ------------------start
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
        //------------------ Heater ------------------end
        //------------------ Control ------------------start
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Control', 1, 0);
        $this->pdf->Cell(15,8,'  1', 1, 0);
        $this->pdf->Cell(80,8,'  Sauna control box w/60 minute timer.', 1, 0);
        $this->pdf->Cell(30,8,'  included', 1, 1);
        //------------------ Control ------------------end
        //------------------ Accessories ------------------start
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Accessories', 1, 0);
        $this->pdf->Cell(15,8,'  1', 1, 0);
        $this->pdf->Cell(80,8,'  Bucket, Ladle, Thermometer and Light Fixture.', 1, 0);
        $this->pdf->Cell(30,8,'  included', 1, 1);
        //------------------ Accessories ------------------end
        //------------------ Subtotal ------------------start
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(135,8,'  Subtotal - Sauna Room and Equipment:',1,0);
        $this->pdf->Cell(30,8,'  $' . number_format($sauna->getInitPrice()),1,1);
        //------------------ Subtotal ------------------end
        $this->pdf->Ln(10);
    }

    private function printSelectedUpgradesTable($upgrades, $index) {
        //------------------ Table header ------------------start
        $this->pdf->SetFont('Times','B',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(0,10,'Selected Upgrades for Sauna Room #' . $index,0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(40,8,'  Product Name', 1, 0);
        $this->pdf->Cell(10,8,'  Qty', 1, 0);
        $this->pdf->Cell(55,8,'  Description', 1, 0);
        $this->pdf->Cell(30,8,'  Price E/A', 1, 0);
        $this->pdf->Cell(30,8,'  Total', 1, 1);
        $this->pdf->SetFont('Times','',9);
        //------------------ Table header ------------------end
        foreach($upgrades as $upgrade) {
            //-------------------- Getting Cell Height --------------------
            $description = $upgrade->getDescription();
            $description_lines = str_split($description,35);
            if(count($description_lines) < 2) {
                $cell_height_desc = 8;
            }
            else {
                $cell_height_desc = count($description_lines) * 5;
            }

            $name = $upgrade->getName();
            $last_word = '';
            if(strlen($name) > 25) {
                $words = explode(' ',$name);
                $last_word = array_pop($words);
                $name = implode(' ', $words);
                $cell_height_name = 10;
            }
            else {
                $cell_height_name = 8;
            }

            if($cell_height_desc >= $cell_height_name) {
                $cell_height = $cell_height_desc;
            }
            else {
                $cell_height = $cell_height_name;
            }
            //-------------------- Getting Cell Height --------------------end
            //-------------------- Upgrade Name --------------------start
            if(!empty($last_word)) {
                $this->pdf->SetX(25);
                $this->pdf->Cell(40,$cell_height,'', 1, 0);
                $name_pos_y = $this->pdf->getY();

                $this->pdf->SetX(25);
                $this->pdf->Cell(40,5,'  ' . $name, 0, 1);
                $this->pdf->SetX(25);
                $this->pdf->Cell(40,5,'  ' . $last_word, 0, 1);
                $this->pdf->SetY($name_pos_y);
            }
            else {
                $this->pdf->SetX(25);
                $this->pdf->Cell(40,$cell_height,'  ' . $name, 1, 0);
            }
            //-------------------- Upgrade Name --------------------end
            //-------------------- Upgrade Qty --------------------start
            $this->pdf->SetX(65);
            $this->pdf->Cell(10,$cell_height,'  ' . $upgrade->getQty(), 1, 0);
            //-------------------- Upgrade Qty --------------------end
            //-------------------- Upgrade Description --------------------start
            # draw full description cell
            $desc_pos_y = $this->pdf->GetY();
            $this->pdf->Cell(55,$cell_height,'',1,0);
            # description lines were stores in $description_lines when getting cell height
            for($i=0; $i<count($description_lines); $i++) {
                $line = $description_lines[$i];
                # if a word gets cut in the middle, we add a '-' to the end of the line
                if($i+1 < count($description_lines)) {
                    $next_line = $description_lines[$i+1];
                }
                if(ctype_alpha($line[strlen($line) - 1]) && ctype_alpha($next_line[0])) {
                    $line .= '-';
                }
                $this->pdf->SetX(75);
                $this->pdf->Cell(55,5,'  ' . $line,0,1);
            }
            # setting the Y and X coordinates to how they should be if it wasn't necessary to do such a desmother to fit the text to a cell.
            $this->pdf->SetY($desc_pos_y);
            $this->pdf->SetX(130);
            //-------------------- Upgrade Description --------------------end
            //-------------------- Upgrade Price --------------------start
            $price = $upgrade->getPrice();
            $price_ea = round($price / $upgrade->getQty());
            if($price == 0) {
                $this->pdf->Cell(30,$cell_height,'  included',1,0);
                $this->pdf->Cell(30,$cell_height,'  included', 1, 1);
            }
            else {
                $this->pdf->Cell(30,$cell_height,'  $' . number_format($price_ea),1,0);
                $this->pdf->Cell(30,$cell_height,'  $' . number_format($price), 1, 1);
            }
            //-------------------- Upgrade Price --------------------end
        }
        
    }

    private function printAllSaunasTotalTable() {
        $saunas = $this->proposal->getSaunas();
        $saunas_total = 0;
        for($i=0;$i<count($saunas);$i++){
            $sauna = $saunas[$i];
            $this->pdf->SetX(25);
            $this->pdf->Cell(90,8,'  Sauna #' . ($i+1) . ' total:',1,0);
            $this->pdf->Cell(40,8,'  $' . number_format($sauna->getPrice()) . '  ',1,1,'R');
            $saunas_total += $sauna->getPrice();
        }

        $discount_total = round($saunas_total * $this->proposal->getDiscount() / 100);
        $this->pdf->SetX(25);
        $this->pdf->Cell(90,8,'  Discount Amount (' . $this->proposal->getDiscount() . '%):',1,0);
        $this->pdf->Cell(40,8,'-$' . number_format($discount_total) . '  ',1,1,'R');

        $tax_total = round($saunas_total * $this->proposal->getSalesTax() / 100);
        $this->pdf->SetX(25);
        $this->pdf->Cell(90,8,'  Sales Tax Amount (' . $this->proposal->getSalesTax() . '%):',1,0);
        $this->pdf->Cell(40,8,'$' . number_format($tax_total) . '  ',1,1,'R');

        $shipping_total = round(count($saunas) * $saunas[0]->getShippingCost());
        $this->pdf->SetX(25);
        $this->pdf->Cell(90,8,'  Shipping Amount ($' . number_format($saunas[0]->getShippingCost()) . ' per Sauna Room):',1,0);
        $this->pdf->Cell(40,8,'$' . number_format($shipping_total) . '  ',1,1,'R');

        $proposal_total = $saunas_total - $discount_total + $tax_total + $shipping_total;
        $this->pdf->SetX(25);
		$this->pdf->SetFont('Times','B',9);
        $this->pdf->Cell(90,8,'  Total Amount with Options & Shipping: ',1,0);
        $this->pdf->Cell(40,8,'$' . number_format($proposal_total) . '  ',1,1,'R');

        # saunas notes box
        $this->pdf->SetX(25);
        $pos_y = $this->pdf->GetY();
        $this->pdf->Cell(130,45,'',1,1);
        $this->pdf->SetY($pos_y);
        $this->pdf->SetX(25);

        # sauna notes content
        $this->pdf->Cell(130,5,'',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  Important Payment Terms and Conditions',0,1);
		$this->pdf->SetFont('Times','',9);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  *50% deposit required to begin production',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  *Balance due prior to shipping.',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  *Sales tax and shipping subject to change upon final approval.',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  *Includes One-Year Warranty on all heater parts installed in a commercial environment',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  one year from the date final payment has been received.',0,1);
        $this->pdf->SetX(25);
        $this->pdf->Cell(130,5,'  *Product proposal excludes Am-Finn Set-Up Services.',0,1);

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