<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

/**
 * Controller principale del webticket
 * Class HomeController
 * @package App\Http\Controllers
 */

class AjaxController extends  Controller{

    public function lista_versamenti($id_PrBlAttivita){
        $versamenti = DB::select('SELECT * from PrVRAttivitaEx Where Id_PrBLAttivita = '.$id_PrBlAttivita);
        return View::make('backend.ajax.lista_versamenti', compact('versamenti','id_PrBlAttivita'));
    }

    public function dettagli_versamenti($id_PrVrAttivita){
        $versamenti = DB::select('SELECT * from PrVRAttivitaEx Where Id_PrVRAttivita = '.$id_PrVrAttivita);
        if(sizeof($versamenti) > 0) {
            $versamento = $versamenti[0];
            return View::make('backend.ajax.dettagli_versamento', compact('versamento'));
        }
    }

    public function controlla_lotto($lotto){
        ?>
        <script type="text/javascript">
            $('#articoli_lotto').html('');
            $('#magazzini_lotto').html('');
            $('#articoli_um').html('');
        </script>
        <?php
        $articoli = DB::select('SELECT AR.Cd_AR,AR.Descrizione from AR JOIN ARLotto ON AR.Cd_AR = ARLotto.Cd_AR and ARLotto.Cd_ARLotto = \''.$lotto.'\'');
        if(sizeof($articoli) == 0){ ?>
            <script type="text/javascript">
                $('#articoli_lotto').append('<option value="">Inserire Lotto</option>');
                $('#magazzini_lotto').append('<option value="">Magazzini Lotto</option>');
                $('#articoli_um').append('<option value="">Inserire Lotto</option>');
            </script>
        <?php } else {

            $ararmisura = DB::select('SELECT * from ARARMisura Where Cd_AR  = \''.$articoli[0]->Cd_AR.'\''); ?>
            <script type="text/javascript">
                <?php foreach ($ararmisura as $misura) { ?>
                $('#articoli_um').append('<option value="<?php echo $misura->Cd_ARMisura ?>" <?php echo ($misura->DefaultMisura == 1)?'selected':'' ?>><?php echo $misura->Cd_ARMisura ?></option>');
                <?php } ?>
            </script>

            <?php foreach ($articoli as $a) { ?>
                <script type="text/javascript">
                    $('#articoli_lotto').append('<option value="<?php echo $a->Cd_AR ?>"><?php echo $a->Cd_AR ?> - <?php echo $a->Descrizione ?></option>');
                    $('#inserisci_tipo_materiale').val(2)
                </script>
            <?php }

            $magazzini = DB::select('SELECT distinct Cd_MG from MGMov Where Cd_ARLotto = \''.$lotto.'\'');
            foreach($magazzini as $m){ ?>
                <script type="text/javascript">
                    $('#magazzini_lotto').append('<option value="<?php echo $m->Cd_MG ?>" <?php echo ($m->Cd_MG == '00009')?'selected':'' ?>><?php echo $m->Cd_MG ?></option>');
                </script>
            <?php }

        }


        $colli = DB::select('SELECT * from xWPCollo Where Nr_Collo = \''.$lotto.'\'');
        if(sizeof($colli) > 0){ ?>
            <script type="text/javascript">

                $('#articoli_lotto').html('');
                $('#magazzini_lotto').html('');
                $('#articoli_um').html('');

                $('#articoli_lotto').append('<option value="">SemiLavorato</option>');
                $('#magazzini_lotto').append('<option value="">SemiLavorato</option>');
                $('#articoli_um').append('<option value="<?php echo $colli[0]->Cd_ARMisura ?>"><?php echo $colli[0]->Cd_ARMisura ?></option>');


                $('#quantita_inserisci_materiale').val(<?php echo $colli[0]->QtaProdotta ?>)
                $('#inserisci_tipo_materiale').val(3)
            </script>
        <?php }
    }

    public function visualizza_file($id_dms){

        $dms = DB::select('SELECT * from DmsDocument Where Id_DmsDocument = '.$id_dms);
        if(sizeof($dms) > 0){
            $path = $dms[0]->FilePath.'\\'.$dms[0]->FileName;
            if($path) {
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=filename.pdf");
                @readfile($path);
            }
        }
    }
    public function load_colli($attivita_bolla){
        $attivita_bolla = DB::SELECT('SELECT * from PrBLAttivitaEx Where Id_PrBLAttivita ='.$attivita_bolla)[0];
        $attivita_bolla->pedane = DB::select('SELECT p.*,AR.PesoNetto as peso_pedana from xWPPD p LEFT JOIN AR ON AR.Cd_AR = p.Cd_xPD Where p.Id_PrOL = ' . $attivita_bolla->Id_PrOL . ' order by p.Id_xWPPD DESC');
        $attivita_bolla->colli = DB::select('SELECT * from xWPCollo Where Id_PrBLAttivita =  ' . $attivita_bolla->Id_PrBLAttivita . ' order by Id_xWPCollo DESC');
        return View::make('backend.ajax.colli_bolla', compact('attivita_bolla'));

    }

    public function load_tracciabilita($id_prol){

        $base    = DB::SELECT('SELECT * FROM PRol where Id_PROl = \''.$id_prol.'\'')[0];

        $base1    = DB::SELECT('SELECT PROLDoRig.*,DORig.NumeroDoc,CF.Descrizione,DORig.Cd_DO
        FROM PROLDoRig
        LEFT JOIN DORig ON PROLDoRig.Id_DoRig = DORIG.Id_DORig
        LEFT JOIN CF    ON CF.Cd_CF = DORig.Cd_CF
        where PROLDoRig.Id_PrOL = \''.$id_prol.'\'')[0];

        $id_prol = DB::SELECT('SELECT PRRLAttivita.DataOra,PRRLAttivita.Cd_Operatore,PROLAttivita .*,PRBLAttivita.* FROM PROLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
        LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and DataOra = (SELECT  MIN(DataOra)  FROM PRRLAttivita WHERE PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\')
        WHERE Id_PRol =  \''.$id_prol.'\' ORDER BY PROLAttivita .Id_PrOLAttivita DESC ');

        ?><h3 class="card-title" id="info_ol" style="width: 100%;text-align: center"> <strong>Articolo</strong> : <?php echo $base->Cd_AR; ?> <strong style="margin-left: 40px;">Quantita </strong>: <?php echo number_format($base1->QuantitaUM1_PR,2,',','') ?> <strong style="margin-left: 40px;">Cliente</strong> : <?php echo $base1->Descrizione ?> <strong style="margin-left: 40px;"><?php echo ($base1->Cd_DO== 'OVC') ? 'OVC':'OCL'?>  </strong>: <?php echo $base1->NumeroDoc ?></h3><br><br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a onclick="cerca()">Attività</a></li>
            </ol>
        </nav>
        <table class="table table-bordered dataTable" id="ciao" style="width:100%;font-size:20px;">
            <thead>
            <tr>
                <th style="width:50px;text-align: center">Collo/Bobina</th>
                <th style="width:50px;text-align: center">Operatore</th>
                <th style="width:50px;text-align: center">Risorsa</th>
                <th style="width:50px;text-align: center">Data</th>
                <th style="width:50px;text-align: center">Ora</th>
                <th style="width:50px;text-align: center">Id_Pedana</th>
                <th style="width:50px;text-align: center">Misura</th>
                <th style="width:50px;text-align: center">Qta</th>
                <th style="width:50px;text-align: center">QtaKG</th>
                <!--  <th style="width:50px;text-align: center">QtaEffettiva</th>-->
            </tr>
            </thead>
            <tbody><?php  foreach ($id_prol as $i){?>
                <tr onclick="<?php echo ($i->Cd_PrRisorsa != 'IMBALLATRICI') ? 'cerca1('.$i->Id_PrOLAttivita.')':'cercaimballo('.$i->Id_PrOLAttivita.')'?>">
                    <td>
                        <?php echo $i->Id_PrOLAttivita ?>
                    </td>
                    <td>
                        <?php echo $i->Cd_Operatore ?>
                    </td>
                    <td>
                        <?php echo $i->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($i->DataOra != '')echo date('d/m/Y',strtotime($i->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($i->DataOra != '')echo date('H:i:s',strtotime($i->DataOra) );?>
                    </td>
                    <td style="text-align: center">

                    </td>
                    <td>
                        <?php echo $i->Cd_ARMisura ?>
                    </td>
                    <td>
                        <?php echo number_format($i->Quantita,2,',','') ?>
                    </td>
                    <td>
                        <?php echo number_format($i->Quantita,2,',','') ?>
                    </td>
                    <!--<td><span class="badge bg-<?php /* echo $color ?>"><?php echo $percent */?>%</span></td>-->


                </tr>
                <?php /* $collo = DB::SELECT('SELECT * FROM xWPCollo WHERE IdOrdineLavoro = \''.$i->Id_PrOL.'\' and IdCodiceAttivita = \''.$i->Id_PrOLAttivita.'\' and Rif_Nr_Collo = \'\'');foreach($collo as $c){?>
                    <tr>
                        <td style="text-align: center">
                            <?php echo $c->Nr_Collo ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c->Cd_Operatore ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c->Cd_PrRisorsa ?>
                        </td>
                        <td style="text-align: center">
                            <?php if($i->TimeIns     != '')echo date('d/m/Y',strtotime($i->TimeIns) );?>
                        </td>
                        <td style="text-align: center">
                            <?php if($i->TimeIns != '')echo date('H:i:s',strtotime($i->TimeIns) );?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c->Nr_Pedana ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $c->Cd_ARMisura ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo number_format($c->QtaProdotta,2) ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo number_format($c->QtaProdottaUmFase,2) ?>
                        </td>
                    </tr>
                    <?php $collo1 = DB::SELECT('SELECT * FROM xWPCollo WHERE  Rif_Nr_Collo = \''.$c->Nr_Collo.'\'');foreach($collo1 as $c1){ ?>
                        <tr>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Collo ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_Operatore ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_PrRisorsa ?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('d/m/Y',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('H:i:s',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Pedana ?>
                            </td>

                            <td style="text-align: right">
                                <?php echo $c1->Cd_ARMisura ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdotta,2) ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdottaUmFase,2) ?>
                            </td>
                        </tr>
                    <?php }
                }*/
            }
            ?>
            </tbody>
        </table>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#ciao').DataTable({  "order": [[ 0, 'desc' ]], "pageLength": 50});
            });
            document.getElementById('numero_ol').innerHTML = 'Tracciabilita dell \' OL '+'<?php echo $id_prol[0]->Id_PrOL ?>'
        </script>

        <?php
    }

    public function load_tracciabilita1($id_prol,$prol_attivita){

        $base    = DB::SELECT('SELECT * FROM PRol where Id_PROl = \''.$id_prol.'\'')[0];

        $base1    = DB::SELECT('SELECT PROLDoRig.*,DORig.NumeroDoc,CF.Descrizione,DORig.Cd_DO
        FROM PROLDoRig
        LEFT JOIN DORig ON PROLDoRig.Id_DoRig = DORIG.Id_DORig
        LEFT JOIN CF    ON CF.Cd_CF = DORig.Cd_CF
        where PROLDoRig.Id_PrOL = \''.$id_prol.'\'')[0];

        $id_prblattivita = DB::SELECT('SELECT * FROM PRBLAttivita WHERE Id_PROLAttivita = \''.$prol_attivita.'\' ')[0]->Id_PrBLAttivita;

        $primo = DB::SELECT('SELECT * FROM PROLAttivita WHERE Id_PROL = \''.$id_prol.'\' ORDER BY Id_PROlAttivita DESC')[0];
        if($primo->Cd_PrAttivita != 'ESTRUSIONE')
            $lotto = 1;
        else
            $lotto = 0;
        $fermi = DB::select('SELECT * FROM PRRLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrBLAttivita = PRRLAttivita.Id_PrBLAttivita
        WHERE PRBLAttivita.Id_PrBLAttivita = '.$id_prblattivita.' and PRRLAttivita.TipoRilevazione = \'F\'');

        $id_prol = DB::SELECT('SELECT PRRLAttivita.DataOra,PRRLAttivita.Cd_Operatore,PROLAttivita .*,PRBLAttivita.* FROM PROLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
        LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and DataOra = (SELECT  MIN(DataOra)  FROM PRRLAttivita WHERE PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\')
        WHERE Id_PRol =  \''.$id_prol.'\' ORDER BY PROLAttivita .Id_PrOLAttivita DESC ');
        ?>
        <h3 class="card-title" id="info_ol" style="width: 100%;text-align: center"> <strong>Articolo</strong> : <?php echo $base->Cd_AR; ?> <strong style="margin-left: 40px;">Quantita </strong>: <?php echo number_format($base1->QuantitaUM1_PR,2,',','') ?> <strong style="margin-left: 40px;">Cliente</strong> : <?php echo $base1->Descrizione ?> <strong style="margin-left: 40px;"><?php echo ($base1->Cd_DO == 'OVC') ? 'OVC':'OCL'?>  </strong>: <?php echo $base1->NumeroDoc ?></h3><br><br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a onclick="cerca()">Attività</a></li>
                <li class="breadcrumb-item active"><a onclick="cerca1()">Colli</a></li>
            </ol>
        </nav>
        <table class="table table-bordered dataTable" id="ciao" style="width:100%;font-size:20px;">
            <thead>
            <tr>
                <th style="width:50px;text-align: center">Collo/Bobina</th>
                <th style="width:50px;text-align: center">Operatore</th>
                <th style="width:50px;text-align: center">Risorsa</th>
                <th style="width:50px;text-align: center">Data</th>
                <th style="width:50px;text-align: center">Ora</th>
                <th style="width:50px;text-align: center">Id_Pedana</th>
                <th style="width:50px;text-align: center">Misura</th>
                <th style="width:50px;text-align: center">Qta</th>
                <th style="width:50px;text-align: center">QtaKG</th>
                <!--  <th style="width:50px;text-align: center">QtaEffettiva</th>-->
            </tr>
            </thead>
            <tbody><?php $tot = 0; $tot_KG = 0;$collo = DB::SELECT('SELECT * FROM xWPCollo WHERE IdOrdineLavoro = \''.$id_prol[0]->Id_PrOL.'\' and IdCodiceAttivita = \''.$prol_attivita.'\' ');foreach($collo as $c){?>
                <tr onclick="cerca2(<?php echo $prol_attivita.','.$c->Nr_Collo;?>)">
                    <td>
                        <?php $risorsa = DB::SELECT('SELECT * FROM PrRisorsa where Cd_PrRisorsa = \''.$c->Cd_PrRisorsa.'\'')[0]->Cd_PRReparto;?>
                        <?php if(str_replace(' ','',$risorsa) == str_replace(' ','',$primo->Cd_PrRisorsa)){ ?>
                            <?php if($lotto == 1){ ?>
                                <?php if($c->Rif_Nr_Collo != ''){?>
                                    <a style="text-align: left"><?php echo '('.$c->Rif_Nr_Collo.')' ?></a>
                                    <a style="text-align: center">DCF:<?php $dcf = DB::select('SELECT * FROM DORIG WHERE Cd_DO = \'DCF\' and Cd_ARLotto = '.$c->Rif_Nr_Collo.' ');if(sizeof($dcf)>0)echo $dcf[0]->NumeroDoc ; ?> - </a>
                                    <a style="text-align: right"><?php echo $c->Nr_Collo ?></a>

                                <?php }}}else{ ?>
                            <a style="text-align: center"><?php echo $c->Nr_Collo?> </a>
                        <?php }?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns != '')echo date('d/m/Y',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns != '')echo date('H:i:s',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QtaProdotta,2,',','');$tot = $tot + $c->QtaProdotta; ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QtaProdottaUmFase,2,',',''); $tot_KG = $tot_KG + $c->QtaProdottaUmFase;?>
                    </td>
                </tr>

                <?php
            }?>
            <?php foreach($fermi as $f){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo($f->InizioFine == 'I') ? 'Inizio Fermo Macchina':'Fine Fermo Macchina' ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Terminale ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('d/m/Y',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('H:i:s',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php // echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita,2,',','') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita_Scar,2,',','') ?>
                    </td>
                </tr>
            <?php } ?>
            <?php $segnalazioni = DB::select('SELECT * FROM xWPSegnalazione WHERE Id_PrBLAttivita = '.$id_prblattivita.' ');?>

            <?php foreach($segnalazioni as $s){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo  'Segnalazione';?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('d/m/Y',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('H:i:s',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Messaggio;// echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita,2) ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita_Scar,2) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div style="text-align: right">
            <h5><strong>Totali Colli: </strong><?php echo number_format($tot,2,',','');?></h5>

            <h5><strong>Totali Colli Kg: </strong><?php echo number_format($tot_KG,2,',','');?></h5>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#ciao').DataTable({  "order": [[ 3, 'asc' ],[ 4, 'asc' ]], "pageLength": 50});
            });
            document.getElementById('numero_ol').innerHTML = 'Tracciabilita dell \' OL '+'<?php echo $id_prol[0]->Id_PrOL ?>'
        </script>

        <?php
    }

    public function load_imballo($id_prol,$prol_attivita){

        $base    = DB::SELECT('SELECT * FROM PRol where Id_PROl = \''.$id_prol.'\'')[0];

        $base1    = DB::SELECT('SELECT PROLDoRig.*,DORig.NumeroDoc,CF.Descrizione,DORig.Cd_DO
        FROM PROLDoRig
        LEFT JOIN DORig ON PROLDoRig.Id_DoRig = DORIG.Id_DORig
        LEFT JOIN CF    ON CF.Cd_CF = DORig.Cd_CF
        where PROLDoRig.Id_PrOL = \''.$id_prol.'\'')[0];

        $id_prblattivita = DB::SELECT('SELECT * FROM PRBLAttivita WHERE Id_PROLAttivita = \''.$prol_attivita.'\' ')[0]->Id_PrBLAttivita;
        $fermi = DB::select('SELECT * FROM PRRLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrBLAttivita = PRRLAttivita.Id_PrBLAttivita
        WHERE PRBLAttivita.Id_PrBLAttivita = '.$id_prblattivita.' and PRRLAttivita.TipoRilevazione = \'F\'');

        $id_prol = DB::SELECT('SELECT PRRLAttivita.DataOra,PRRLAttivita.Cd_Operatore,PROLAttivita .*,PRBLAttivita.* FROM PROLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
        LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and DataOra = (SELECT  MIN(DataOra)  FROM PRRLAttivita WHERE PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\')
        WHERE Id_PRol =  \''.$id_prol.'\' ORDER BY PROLAttivita .Id_PrOLAttivita DESC ');
        ?>
        <h3 class="card-title" id="info_ol" style="width: 100%;text-align: center"> <strong>Articolo</strong> : <?php echo $base->Cd_AR; ?> <strong style="margin-left: 40px;">Quantita </strong>: <?php echo number_format($base1->QuantitaUM1_PR,2,',','') ?> <strong style="margin-left: 40px;">Cliente</strong> : <?php echo $base1->Descrizione ?> <strong style="margin-left: 40px;"><?php echo ($base1->Cd_DO == 'OVC') ? 'OVC':'OCL'?> </strong>: <?php echo $base1->NumeroDoc ?></h3><br><br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a onclick="cerca()">Attività</a></li>
                <li class="breadcrumb-item active"><a onclick="">Pedane</a></li>
            </ol>
        </nav>
        <table class="table table-bordered dataTable" id="ciao" style="width:100%;font-size:20px;">
            <thead>
            <tr>
                <th style="width:50px;text-align: center">Numero Colli</th>
                <th style="width:50px;text-align: center">Operatore</th>
                <th style="width:50px;text-align: center">Risorsa</th>
                <th style="width:50px;text-align: center">Data</th>
                <th style="width:50px;text-align: center">Ora</th>
                <th style="width:50px;text-align: center">Id_Pedana</th>
                <th style="width:50px;text-align: center">Misura</th>
                <th style="width:50px;text-align: center">Qta</th>
                <th style="width:50px;text-align: center">QtaKG</th>
                <!--  <th style="width:50px;text-align: center">QtaEffettiva</th>-->
            </tr>
            </thead>
            <tbody><?php /* foreach ($id_prol as $i){ ?>
                <tr>
                    <td>
                        <?php echo $i->Id_PrOLAttivita ?>
                    </td>
                    <td>
                        <?php echo $i->Cd_Operatore ?>
                    </td>
                    <td>
                        <?php echo $i->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($i->DataOra != '')echo date('d/m/Y',strtotime($i->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($i->DataOra != '')echo date('H:i:s',strtotime($i->DataOra) );?>
                    </td>
                    <td style="text-align: center">

                    </td>
                    <td>
                        <?php echo $i->Cd_ARMisura ?>
                    </td>
                    <td>
                        <?php echo number_format($i->Quantita,2) ?>
                    </td>
                    <td>
                        <?php echo number_format($i->Quantita,2) ?>
                    </td>
                    <!--<td><span class="badge bg-<?php /* echo $color ?>"><?php echo $percent *//*?>%</span></td>-->


                </tr>
                <?php */ $collo = DB::SELECT('SELECT PRVRAttivita.Cd_Operatore,PRVRAttivita.Cd_PRRisorsa,* FROM xWPPD
                LEFT JOIN PRVRAttivita ON PRVRAttivita.Id_PRVRAttivita = xWPPD.Id_PrVrAttivita
                WHERE xWPPD.Id_PrOL = \''.$id_prol[0]->Id_PrOL.'\' ');foreach($collo as $c){?>
                <tr onclick="cercaimballo2('<?php echo $prol_attivita?>','<?php echo $c->Nr_Pedana;?>')">
                    <td style="text-align: center">
                        <?php echo $c->NumeroColli?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_PRRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns     != '')echo date('d/m/Y',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns != '')echo date('H:i:s',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QuantitaProdotta,2,',','') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QuantitaProdotta,2,',','') ?>
                        <?php //echo number_format($c->QtaProdottaUmFase,2) ?>
                    </td>
                </tr>
                <?php /*$collo1 = DB::SELECT('SELECT * FROM xWPCollo WHERE  Rif_Nr_Collo = \''.$c->Nr_Collo.'\'');foreach($collo1 as $c1){ ?>
                        <tr>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Collo ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_Operatore ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_PrRisorsa ?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('d/m/Y',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('H:i:s',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Pedana ?>
                            </td>

                            <td style="text-align: right">
                                <?php echo $c1->Cd_ARMisura ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdotta,2) ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdottaUmFase,2) ?>
                            </td>
                        </tr>
                    <?php }
            }*/
            }
            foreach($fermi as $f){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo($f->InizioFine == 'I') ? 'Inizio Fermo Macchina':'Fine Fermo Macchina' ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Terminale ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('d/m/Y',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('H:i:s',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php // echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita,2,',','') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita_Scar,2,',','') ?>
                    </td>
                </tr>
            <?php } ?>
            <?php $segnalazioni = DB::select('SELECT * FROM xWPSegnalazione WHERE Id_PrBLAttivita = '.$id_prblattivita.' ');?>

            <?php foreach($segnalazioni as $s){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo  'Segnalazione';?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('d/m/Y',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('H:i:s',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Messaggio;// echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita,2) ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita_Scar,2) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#ciao').DataTable({  "order": [[ 3, 'asc' ],[ 4, 'asc' ]], "pageLength": 50});
            });
            document.getElementById('numero_ol').innerHTML = 'Tracciabilita dell \' OL '+'<?php echo $id_prol[0]->Id_PrOL ?>'
        </script>

        <?php
    }
    public function load_imballo2($id_prol,$prol_attivita,$Nr_Pedana){

        $base    = DB::SELECT('SELECT * FROM PRol where Id_PROl = \''.$id_prol.'\'')[0];

        $base1    = DB::SELECT('SELECT PROLDoRig.*,DORig.NumeroDoc,CF.Descrizione,DORig.Cd_DO
        FROM PROLDoRig
        LEFT JOIN DORig ON PROLDoRig.Id_DoRig = DORIG.Id_DORig
        LEFT JOIN CF    ON CF.Cd_CF = DORig.Cd_CF
        where PROLDoRig.Id_PrOL = \''.$id_prol.'\'')[0];

        $id_prblattivita = DB::SELECT('SELECT * FROM PRBLAttivita WHERE Id_PROLAttivita = \''.$prol_attivita.'\' ')[0]->Id_PrBLAttivita;
        $fermi = DB::select('SELECT * FROM PRRLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrBLAttivita = PRRLAttivita.Id_PrBLAttivita
        WHERE PRBLAttivita.Id_PrBLAttivita = '.$id_prblattivita.' and PRRLAttivita.TipoRilevazione = \'F\'');

        $id_prol = DB::SELECT('SELECT PRRLAttivita.DataOra,PRRLAttivita.Cd_Operatore,PROLAttivita .*,PRBLAttivita.* FROM PROLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
        LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and DataOra = (SELECT  MIN(DataOra)  FROM PRRLAttivita WHERE PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\')
        WHERE Id_PRol =  \''.$id_prol.'\' ORDER BY PROLAttivita .Id_PrOLAttivita DESC ');
        ?>
        <h3 class="card-title" id="info_ol" style="width: 100%;text-align: center"> <strong>Articolo</strong> : <?php echo $base->Cd_AR; ?> <strong style="margin-left: 40px;">Quantita </strong>: <?php echo number_format($base1->QuantitaUM1_PR,2,',','') ?> <strong style="margin-left: 40px;">Cliente</strong> : <?php echo $base1->Descrizione ?> <strong style="margin-left: 40px;"><?php echo ($base1->Cd_DO == 'OVC') ? 'OVC':'OCL'?> </strong>: <?php echo $base1->NumeroDoc ?></h3><br><br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a onclick="cerca()">Attività</a></li>
                <li class="breadcrumb-item"><a onclick="cercaimballo('<?php echo $id_prol[0]->Id_PrOLAttivita?>')">Pedane</a></li>
                <li class="breadcrumb-item active"><a onclick="">Colli sulla Pedana (<?php echo $Nr_Pedana?>)</a></li>
            </ol>
        </nav>
        <table class="table table-bordered dataTable" id="ciao" style="width:100%;font-size:20px;">
            <thead>
            <tr>
                <th style="width:50px;text-align: center">Numero Colli</th>
                <th style="width:50px;text-align: center">Operatore</th>
                <th style="width:50px;text-align: center">Risorsa</th>
                <th style="width:50px;text-align: center">Data</th>
                <th style="width:50px;text-align: center">Ora</th>
                <th style="width:50px;text-align: center">Id_Pedana</th>
                <th style="width:50px;text-align: center">Misura</th>
                <th style="width:50px;text-align: center">Qta</th>
                <th style="width:50px;text-align: center">QtaKG</th>
                <!--  <th style="width:50px;text-align: center">QtaEffettiva</th>-->
            </tr>
            </thead>
            <tbody><?php  $tot = 0; $tot_KG = 0; $collo = DB::SELECT('SELECT * FROM xWPCollo WHERE Nr_Pedana = \''.$Nr_Pedana.'\'');foreach($collo as $c){?>
                <tr <?php // onclick="cerca2(<?php // echo $prol_attivita.','.$c->Nr_Collo;)"?>>
                    <td style="text-align: center">
                        <?php echo $c->Nr_Collo?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns     != '')echo date('d/m/Y',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c->TimeIns != '')echo date('H:i:s',strtotime($c->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QtaProdotta,2,',','');$tot = $tot + $c->QtaProdotta?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($c->QtaProdotta,2,',','');$tot_KG = $tot_KG + $c->QtaProdotta ?>
                        <?php //echo number_format($c->QtaProdottaUmFase,2) ?>
                    </td>
                </tr>
                <?php /*$collo1 = DB::SELECT('SELECT * FROM xWPCollo WHERE  Rif_Nr_Collo = \''.$c->Nr_Collo.'\'');foreach($collo1 as $c1){ ?>
                        <tr>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Collo ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_Operatore ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Cd_PrRisorsa ?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('d/m/Y',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: center">
                                <?php if($c1->TimeIns != '')echo date('H:i:s',strtotime($c1->TimeIns) );?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $c1->Nr_Pedana ?>
                            </td>

                            <td style="text-align: right">
                                <?php echo $c1->Cd_ARMisura ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdotta,2) ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo number_format($c1->QtaProdottaUmFase,2) ?>
                            </td>
                        </tr>
                    <?php }
            }*/
            } ?>

            <?php
            foreach($fermi as $f){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo($f->InizioFine == 'I') ? 'Inizio Fermo Macchina':'Fine Fermo Macchina' ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Terminale ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('d/m/Y',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('H:i:s',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php // echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita,2,',','') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita_Scar,2,',','') ?>
                    </td>
                </tr>
            <?php } ?>
            <?php $segnalazioni = DB::select('SELECT * FROM xWPSegnalazione WHERE Id_PrBLAttivita = '.$id_prblattivita.' ');?>

            <?php foreach($segnalazioni as $s){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo  'Segnalazione';?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('d/m/Y',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('H:i:s',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Messaggio;// echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita,2) ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita_Scar,2) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div style="text-align: right">
            <h5><strong>Totali Colli: </strong><?php echo number_format($tot,2,',','');?></h5>

            <h5><strong>Totali Colli Kg: </strong><?php echo number_format($tot_KG,2,',','');?></h5>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#ciao').DataTable({  "order": [[ 3, 'asc' ],[ 4, 'asc' ]], "pageLength": 50});
            });
            document.getElementById('numero_ol').innerHTML = 'Tracciabilita dell \' OL '+'<?php echo $id_prol[0]->Id_PrOL ?>'
        </script>

        <?php
    }
    public function load_tracciabilita2($id_prol,$prol_attivita,$Nr_Collo){

        $base    = DB::SELECT('SELECT * FROM PRol where Id_PROl = \''.$id_prol.'\'')[0];

        $base1    = DB::SELECT('SELECT PROLDoRig.*,DORig.NumeroDoc,CF.Descrizione,DORig.Cd_DO
        FROM PROLDoRig
        LEFT JOIN DORig ON PROLDoRig.Id_DoRig = DORIG.Id_DORig
        LEFT JOIN CF    ON CF.Cd_CF = DORig.Cd_CF
        where PROLDoRig.Id_PrOL = \''.$id_prol.'\'')[0];

        $id_prol = DB::SELECT('SELECT PRRLAttivita.DataOra,PRRLAttivita.Cd_Operatore,PROLAttivita .*,PRBLAttivita.* FROM PROLAttivita
        LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
        LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and DataOra = (SELECT  MIN(DataOra)  FROM PRRLAttivita WHERE PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\')
        WHERE Id_PRol =  \''.$id_prol.'\' ORDER BY PROLAttivita .Id_PrOLAttivita DESC ');

        ?><h3 class="card-title" id="info_ol" style="width: 100%;text-align: center"> <strong>Articolo</strong> : <?php echo $base->Cd_AR; ?> <strong style="margin-left: 40px;">Quantita </strong>: <?php echo number_format($base1->QuantitaUM1_PR,2,',','') ?> <strong style="margin-left: 40px;">Cliente</strong> : <?php echo $base1->Descrizione ?> <strong style="margin-left: 40px;"><?php echo ($base1->Cd_DO == 'OVC') ? 'OVC':'OCL'?>  </strong>: <?php echo $base1->NumeroDoc ?></h3><br><br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a onclick="cerca()">Attività</a></li>
                <li class="breadcrumb-item"><a onclick="cerca1(<?php echo $prol_attivita?>)">Colli</a></li>
                <li class="breadcrumb-item active"><a onclick="cerca2(<?php echo $prol_attivita.','.$Nr_Collo?>)">Da Collo Madre (<?php echo $Nr_Collo ?>) </a></li>
            </ol>
        </nav>
        <table class="table table-bordered dataTable" id="ciao" style="width:100%;font-size:20px;">
            <thead>
            <tr>
                <th style="width:50px;text-align: center">Collo/Bobina</th>
                <th style="width:50px;text-align: center">Operatore</th>
                <th style="width:50px;text-align: center">Risorsa</th>
                <th style="width:50px;text-align: center">Data</th>
                <th style="width:50px;text-align: center">Ora</th>
                <th style="width:50px;text-align: center">Id_Pedana</th>
                <th style="width:50px;text-align: center">Misura</th>
                <th style="width:50px;text-align: center">Qta</th>
                <th style="width:50px;text-align: center">QtaKG</th>
                <!--  <th style="width:50px;text-align: center">QtaEffettiva</th>-->
            </tr>
            </thead>
            <tbody><?php $tot = 0; $tot_KG = 0;$collo1 = DB::SELECT('SELECT * FROM xWPCollo WHERE  Rif_Nr_Collo = \''.$Nr_Collo.'\'');foreach($collo1 as $c1){ ?>
                <tr>
                    <td style="text-align: right">
                        <?php echo $c1->Nr_Collo ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo $c1->Cd_Operatore ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo $c1->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c1->TimeIns != '')echo date('d/m/Y',strtotime($c1->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($c1->TimeIns != '')echo date('H:i:s',strtotime($c1->TimeIns) );?>
                    </td>
                    <td style="text-align: right">
                        <?php echo $c1->Nr_Pedana ?>
                    </td>

                    <td style="text-align: right">
                        <?php echo $c1->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($c1->QtaProdotta,2,',',''); $tot = $tot + $c1->QtaProdotta ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format($c1->QtaProdottaUmFase,2,',',''); $tot_KG = $tot_KG + $c1->QtaProdottaUmFase?>
                    </td>
                </tr>
            <?php } ?>


            <?php $id_prblattivita = DB::SELECT('SELECT * FROM xWPCollo WHERE  Rif_Nr_Collo = \''.$Nr_Collo.'\'')[0]->Id_PRBLAttivita;
            $fermi = DB::select('SELECT * FROM PRRLAttivita
                    LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrBLAttivita = PRRLAttivita.Id_PrBLAttivita
                    WHERE PRBLAttivita.Id_PrBLAttivita = '.$id_prblattivita.' and PRRLAttivita.TipoRilevazione = \'F\'');?>

            <?php foreach($fermi as $f){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo($f->InizioFine == 'I') ? 'Inizio Fermo Macchina':'Fine Fermo Macchina' ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $f->Terminale ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('d/m/Y',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($f->DataOra != '')echo date('H:i:s',strtotime($f->DataOra) );?>
                    </td>
                    <td style="text-align: center">
                        <?php // echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita,2,',','') ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo number_format($f->Quantita_Scar,2,',','') ?>
                    </td>
                </tr>
            <?php } ?>
            <?php $segnalazioni = DB::select('SELECT * FROM xWPSegnalazione WHERE Id_PrBLAttivita = '.$id_prblattivita.' ');?>

            <?php foreach($segnalazioni as $s){?>
                <tr onclick="">
                    <td style="text-align: center">
                        <?php echo  'Segnalazione';?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_Operatore ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Cd_PrRisorsa ?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('d/m/Y',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php if($s->TimeIns != '')echo date('H:i:s',strtotime($s->TimeIns) );?>
                    </td>
                    <td style="text-align: center">
                        <?php echo $s->Messaggio;// echo $c->Nr_Pedana ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo $c->Cd_ARMisura ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita,2) ?>
                    </td>
                    <td style="text-align: center">
                        <?php //echo number_format($s->Quantita_Scar,2) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div style="text-align: right">
            <h5><strong>Totali Colli: </strong><?php echo number_format($tot,2,',','');?></h5>

            <h5><strong>Totali Colli Kg: </strong><?php echo number_format($tot_KG,2,',','');?></h5>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#ciao').DataTable({  "order": [[ 3, 'asc' ],[ 4, 'asc' ]], "pageLength": 50});
            });
            document.getElementById('numero_ol').innerHTML = 'Tracciabilita dell \' OL '+'<?php echo $id_prol[0]->Id_PrOL ?>'
        </script>

        <?php
    }

    public function get_bolla($id){

        $utente = session('utente');

        $attivita = DB::select('SELECT * from PRBLAttivita Where Id_PrOLAttivita IN (
                SELECT Id_PrOLAttivita from PROLAttivita Where Cd_PrAttivita = \'IMBALLAGGIO\' and Id_PrOL IN (
                    SELECT Id_PrOL from PROL Where Id_PrOL IN (
                        SELECT Id_PrOL from xWPPD Where Nr_Pedana = \''.trim($id).'\'
                    )
                )
            )');

        if(sizeof($attivita) > 0){
            echo $attivita[0]->Id_PrBLAttivita;
            exit;
        }


        $attivita = DB::select('SELECT * from PRBLAttivita Where Id_PrBLAttivita = '.$id);
        if(sizeof($attivita) > 0){
            echo $attivita[0]->Id_PrBLAttivita;
            exit;
        }
    }


    public function set_stampato($nome_file){

        $stampe = DB::select('SELECT * from xStampeIndustry Where nome_file = \''.$nome_file.'\'');
        if(sizeof($stampe) > 0){
            $stampa = $stampe[0];
            DB::update('update xStampeIndustry set Stampato = 1 Where Id_xStampeIndustry ='.$stampa->Id_xStampeIndustry);

            if($stampa->Collo != ''){
                DB::update('update xWPCollo set Stampato = 1 where  Nr_Collo = \''.$stampa->Collo.'\'');
            }
        }

    }

    public function modifica_pedana_imballaggio($id){


        $pedane = DB::select('
            SELECT p.*,c.Descrizione as cliente,a.Cd_AR,PROL.Id_PrOL,a.Descrizione as Descrizione_Articolo,PRBLAttivita.NotePrBLAttivita,a.xPesobobina,a.xBase,a.PesoNetto as peso_pedana,PRBLAttivita.Id_PrBLAttivita,PRRLAttivita.Id_PrRLAttivita  from xWPPD  p
            LEFT JOIN PROL ON PROL.Id_PrOL = p.Id_PrOL
            LEFT JOIN AR a ON a.Cd_AR = PROL.Cd_AR
            LEFT JOIN PROLDorig ON PROLDorig.Id_PrOL = PROL.Id_PrOL
            LEFT JOIN DOrig d ON d.Id_Dorig = PROLDorig.Id_Dorig
            LEFT JOIN CF c ON c.Cd_CF = d.Cd_CF
            Left JOIN PROLAttivita ON PROLAttivita.Id_PrOL = PROL.Id_PrOL and PROLAttivita.Cd_PrAttivita = \'IMBALLAGGIO\'
            LEFT JOIN PRBLAttivita ON PRBLAttivita.Id_PrOLAttivita = PROLAttivita.Id_PrOLAttivita
            LEFT JOIN PRRLAttivita ON PRRLAttivita.Id_PrBLAttivita = PRBLAttivita.Id_PrBLAttivita and PRRLAttivita.InizioFine = \'I\' and PRRLAttivita.TipoRilevazione = \'E\' and PRRLAttivita.NotePrRLAttivita = p.Nr_Pedana
            where p.Id_xWPPD = '.$id.'
        ');

        if(sizeof($pedane) > 0){
            $p = $pedane[0];
            $p->mandrini = DB::select('SELECT * from AR Where Cd_AR IN (SELECT xMandrino from AR Where Cd_AR = \''.$p->Cd_AR.'\')');
            $p->colli = DB::select('SELECT * from xWPCollo Where IdOrdineLavoro = '.$p->Id_PrOL.' and Id_PRBLAttivita IN (SELECT TOP 1 Id_PRBLAttivita from xWPCollo Where IdOrdineLavoro = '.$p->Id_PrOL.' Order By Id_PRBLAttivita DESC) order by Id_xWPCollo DESC');
            $pallet = DB::select('SELECT * from AR Where Cd_AR LIKE \'05%\'');

            return View::make('backend.ajax.modifica_pedana_imballaggio', compact('p','pallet'));

        }

    }
}
