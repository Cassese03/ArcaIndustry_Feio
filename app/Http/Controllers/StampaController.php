<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\TemplateProcessor;
use Spatie\GoogleCalendar\Event;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/**
 * Controller principale del webticket
 * Class HomeController
 * @package App\Http\Controllers
 */

class StampaController extends Controller{


    public function qualita($Id_xFormQualita){

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0]); //use this customization
        $form = DB::select('SELECT * from xFormQualita Where Id_xFormQualita='.$Id_xFormQualita);
        if(sizeof($form)> 0) {
            $form = $form[0];

            $clienti = DB::select('SELECT top 1 CF.* from PRBLAttivita
                LEFT JOIN PROLAttivita ON PROLAttivita.Id_PrOLAttivita = PRBLAttivita.Id_PrOLAttivita
                LEFT Join PrOL On PROLAttivita.Id_PrOL=PrOL.Id_PrOL
                LEFT JOIN PROLDoRig ON PROLDoRig.Id_PrOL = PROL.Id_PrOL
                LEFT JOIN DORig on DORig.Id_DORig = PROLDoRig.Id_DoRig
                LEFT JOIN CF ON CF.Cd_CF = DORig.Cd_CF where PRBLAttivita.Id_PrBLAttivita='.$form->Id_PrBLAttivita);

            if(sizeof($clienti) > 0) {

                $cliente = $clienti[0];
                $mpdf->showImageErrors = true;
                $mpdf->SetTitle('Modulo di Qualita Bolla ' . $form->Id_PrBLAttivita);
                $html = View::make('stampa.qualita', compact('form','cliente'));
                $mpdf->WriteHTML($html);
                $mpdf->Output('test.pdf', 'I');

            }
        }
    }
}
