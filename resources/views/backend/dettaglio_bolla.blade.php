@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Attivita Bolla <?php echo $attivita_bolla->Id_PrBLAttivita ?> (<small>Bolla <?php echo $bolla->Id_PrBL ?></small> <small>OL <?php echo $OLAttivita->Id_PrOL  ?></small>) <span style="font-size:18px;color:red"><?php echo $stato_attuale ?> <small id="time"></small></span></h1>

                    <?php if(sizeof($attivita_bolla->CF) > 0){
                        echo $attivita_bolla->CF[0]->Descrizione.' - ';
                    } ?>

                    <?php echo $articolo->Cd_AR  ?> - <?php echo $attivita_bolla->Descrizione ?> - <?php echo $attivita_bolla->Articolo ?><br>


                    <?php if(trim($bolla->NotePrBL) != ''){ ?>
                    <h3 style="color:red;"><?php echo nl2br($bolla->NotePrBL) ?></h3>
                    <?php } ?>

                </div>

                <div class="col-md-5">

                    <div class="row" style="margin-top:5px;">

                        <?php if($stato_attuale == 'FE'){ ?>



                        <?php if(sizeof($attivita_bolla->versamenti) > 0){ ?>
                        <div class="col-md-6">
                            <a class="btn btn-success" style="width:100%;height:70px;font-size:20px;float:left" onclick="chiudi_bolla();">Chiudi<br>Bolla</a>
                        </div>
                        <div class="col-md-6">
                            <form method="post" onsubmit="return confirm('Vuoi far partire la rilevazione dell\'attrezzaggio ? ')">
                                <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                                <button type="submit" name="inizio_attrezzaggio" value="Inizio Attrezzaggio" class="btn btn-primary" style="width:100%;height:70px;font-size:20px;float:left">Inizio<br>Attrezzaggio</button>
                            </form>
                        </div>
                        <?php } else { ?>

                        <div class="col-md-12">
                            <form method="post" onsubmit="return confirm('Vuoi far partire la rilevazione dell\'attrezzaggio ? ')">
                                <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                                <button type="submit" name="inizio_attrezzaggio" value="Inizio Attrezzaggio" class="btn btn-primary" style="width:100%;height:70px;font-size:20px;float:left">Inizio<br>Attrezzaggio</button>
                            </form>
                        </div>
                        <?php } ?>




                        <?php } else if($stato_attuale == 'IA'){ ?>

                        <div class="col-md-12">
                            <a onclick="fine_attrezzaggio()" class="btn btn-primary" style="width:100%;height:70px;font-size:20px;float:left">Fine<br>Attrezzaggio</a>
                        </div>

                        <?php } else if($stato_attuale == 'FA'){ ?>

                        <?php if(sizeof($attivita_bolla->versamenti) > 0){ ?>
                        <div class="col-md-6">
                            <a class="btn btn-success" style="width:100%;height:70px;font-size:20px;float:left" onclick="chiudi_bolla();">Chiudi<br>Bolla</a>
                        </div>

                        <div class="col-md-6">
                            <form method="post" onsubmit="return confirm('Vuoi far partire la rilevazione dell\'esecuzione ? ')">
                                <button type="submit" name="inizio_esecuzione" value="Inizio Attrezzaggio" class="btn btn-primary" style="width:100%;height:70px;font-size:20px;float:left">Inizio<br>Esecuzione</button>
                            </form>
                        </div>

                        <?php } else { ?>

                        <div class="col-md-12">
                            <form method="post" onsubmit="return confirm('Vuoi far partire la rilevazione dell\'esecuzione ? ')">
                                <button type="submit" name="inizio_esecuzione" value="Inizio Attrezzaggio" class="btn btn-primary" style="width:100%;height:70px;font-size:20px;float:left">Inizio<br>Esecuzione</button>
                            </form>
                        </div>

                        <?php } ?>

                        <?php } else if($stato_attuale == 'IE'){ ?>

                        <div class="col-md-3">
                            <a class="btn btn-warning" style="width:100%;height:70px;font-size:16px;float:left" onclick="invia_segnalazione();">Invia<br>Segnalazione</a>
                        </div>

                        <div class="col-md-3">
                            <a class="btn btn-danger" style="width:100%;height:70px;font-size:16px;float:left" onclick="invia_fermo();">Invia<br>Fermo</a>
                        </div>
                        <?php /*
                        <div class="col-md-3">
                            <a onclick="inserisci_contatore()" class="btn btn-primary" style="width:100%;height:70px;font-size:16px;float:left">Inserisci<br>Contatore</a>
                        </div>
*/?>
                        <div class="col-md-3">
                            <a onclick="fine_lavorazione()" class="btn btn-success" style="width:100%;height:70px;font-size:16px;float:left">Fine<br>Esecuzione</a>
                        </div>


                        <?php } else if($stato_attuale == 'IF'){ ?>

                        <div class="col-md-12">
                            <a onclick="fine_fermo()" class="btn btn-success" style="width:100%;height:70px;font-size:20px;float:left">Fine<br>Fermo</a>
                        </div>

                        <?php } ?>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <section class="content">


        <div class="row">
            <div class="col-12">
                <!-- /.card -->

                <form method="post">

                    <div class="card">
                        <!-- /.card-header -->

                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-1">
                                    <label>U.M.</label>
                                    <?php if($OLAttivita->Cd_PrAttivita == 'SALDATURA' || $OLAttivita->Cd_PrAttivita == 'TAGLIO'){ ?>
                                    <select id="cd_armisura_top" name="Cd_ARMisura" class="form-control select2">
                                        <?php foreach($articolo->UM as $um){ $um_default = $um->TipoARMisura; ?>
                                        <?php if(sizeof($attivita_bolla->colli) > 0) $um_default = $attivita_bolla->colli[0]->Cd_ARMisura ?>
                                        <option value="<?php echo $um->Cd_ARMisura ?>" <?php echo ($um->Cd_ARMisura == $um_default)?'selected':'' ?>><?php echo $um->Cd_ARMisura ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } else { ?>
                                    <select id="cd_armisura_top" name="Cd_ARMisura" class="form-control select2">
                                        <option value="<?php echo $attivita_bolla->Cd_ARMisura ?>"><?php echo $attivita_bolla->Cd_ARMisura ?></option>
                                    </select>
                                    <?php } ?>


                                    <?php if($OLAttivita->Cd_PrAttivita == 'STAMPA'||$OLAttivita->Cd_PrAttivita == 'RISTAMPA'){ ?>
                                    <script type="text/javascript">
                                        $('#cd_armisura_top').val('mt');
                                    </script>
                                    <?php } ?>


                                </div>

                                <div class="col-md-2">
                                    <label>Pedana</label>
                                    <?php if(sizeof($attivita_bolla->pedane) > 0 && $crea_pedana == 1){ ?>
                                    <select id="Nr_Pedana" name="Nr_Pedana" class="form-control select2">
                                        <?php foreach($attivita_bolla->pedane as $p){ ?>
                                        <option value="<?php echo $p->Nr_Pedana ?>"><?php echo $p->Nr_Pedana ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } else { ?>
                                    <br><b>Nessuna Pedana</b>
                                    <?php } ?>
                                </div>

                                <div class="col-md-2">
                                    <label>Qta. Prodotta</label>
                                    <?php $qta_colli = 0; ?>

                                    <?php foreach($attivita_bolla->colli as $colli) if($colli->Stampato == 1) $qta_colli+= $colli->QtaProdotta; ?>

                                    <input type="text" id="quantita_prodotta_ss" name="Quantita" step="0.1" min="0.1" class="form-control keyboard_num" value="" readonly onkeydown="abilita_stampa()" onchange="abilita_stampa()">
                                </div>

                                <div class="col-md-1">
                                    <label>Colli</label>
                                    <select id="esemplari" name="esemplari" class="form-control">
                                        <?php for($i = 1;$i<=9;$i++){ ?>
                                        <option value="<?php echo $i ?>" <?php echo (strpos($attivita_bolla->Cd_PrRisorsa,'TG') !== false && sizeof($cliche) > 0 && $cliche[0]->xCLPiste == $i)?'selected':'' ?>><?php echo $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-5">


                                    <input type="hidden" name="Id_prBLAttivita" value="<?php echo $attivita_bolla->Id_PrBLAttivita ?>">


                                    <?php if($stato_attuale == 'IE'){ ?>

                                    <?php if(sizeof($attivita_bolla->colli) > 0 && $attivita_bolla->colli[0]->QtaProdotta == 0){ ?>

                                    <?php if(sizeof($attivita) > 0 && $attivita[0]->xTFRichiediRif == 1){ ?>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label>Bobina Madre 1</label>
                                            <input type="text" name="Rif_Nr_Collo_Ultimo"  value="<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Rif_Nr_Collo:'' ?>" class="form-control" disabled>
                                        </div>

                                        <?php if(sizeof($attivita) > 0 &&  $attivita[0]->Cd_PrAttivita == 'ACCOPPIAMENTO'){ ?>

                                        <div class="col-md-6">
                                            <label>Bobina Madre 2</label>
                                            <input type="text" name="Rif_Nr_Collo2_Ultimo"  value="<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Rif_Nr_Collo2:'' ?>" class="form-control" disabled>
                                        </div>

                                        <?php } ?>

                                    </div>
                                    <div class="clearfix" style="margin-bottom:10px;"></div>

                                    <?php } else { ?>
                                    <label>&nbsp;</label><br>
                                    <?php } ?>


                                    <input type="hidden" name="Id_xWPCollo" value="<?php echo $attivita_bolla->colli[0]->Id_xWPCollo ?>">
                                    <button type="submit" name="start" value="start" class="btn btn-success" style="font-size:20px;float:left;" disabled>NUOVO</button>
                                    <button type="submit" name="stop" value="stop" class="btn btn-primary" style="font-size:20px;float:left;margin-left:5px;">STAMPA</button>
                                    <div class="clearfix"></div>

                                    <script type="text/javascript">
                                        $('#quantita_prodotta_ss').removeAttr('readonly');
                                        $('#quantita_prodotta_ss').attr('required',true);
                                    </script>

                                    <?php } else { ?>

                                    <?php if(sizeof($attivita) > 0 && $attivita[0]->xTFRichiediRif == 1){ ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Bobina Madre</label>
                                            <input type="text" name="Rif_Nr_Collo_Ultimo"  value="<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Rif_Nr_Collo:'' ?>" class="form-control keyboard" required>
                                        </div>

                                        <?php if(sizeof($attivita) > 0 &&  $attivita[0]->Cd_PrAttivita == 'ACCOPPIAMENTO'){ ?>

                                        <div class="col-md-6">
                                            <label>Bobina Madre 2</label>
                                            <input type="text" name="Rif_Nr_Collo2_Ultimo"  value="<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Rif_Nr_Collo2:'' ?>" class="form-control keyboard" required>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix" style="margin-bottom:10px;"></div>

                                    <?php } else { ?>
                                    <label>&nbsp;</label><br>
                                    <?php } ?>

                                    <div class="row">

                                        <?php if($crea_pedana == 1){ ?>

                                        <?php if(sizeof($attivita_bolla->pedane) > 0){ ?>
                                        <div class="col-md-3">
                                            <button id="bottone_nuovo" type="submit" name="start" value="start" class="btn btn-success" style="width:100%;font-size:18px;float:left;" onclick="nuovo()">NUOVO</button>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="bottone_stampa" type="submit" name="stop" value="stop" class="btn btn-primary" style="width:100%;font-size:18px;float:left;margin-left:5px;" disabled>STAMPA</button>
                                        </div>

                                        <?php } ?>

                                        <div class="col-md-6">
                                            <a onclick="aggiungi_pedana()" name="crea_pedana" value="Crea Pedana" class="btn btn-primary" style="width:100%;font-size:18px;float:left;margin-left:10px;">CREA PEDANA</a>
                                        </div>

                                        <?php } else {  ?>

                                        <div class="col-md-3">
                                            <button id="bottone_nuovo" name="start" value="start" class="btn btn-success" style="width:100%;font-size:18px;float:left;"  onclick="nuovo()">NUOVO</button>
                                        </div>

                                        <div class="col-md-3">
                                            <button id="bottone_stampa" type="submit" name="stop" value="stop" class="btn btn-primary" style="width:100%;font-size:18px;float:left;margin-left:5px;" disabled>STAMPA</button>
                                        </div>

                                        <?php } ?>

                                    </div>

                                    <?php } ?>

                                    <?php } ?>

                                </div>

                            </div>

                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-12">

                                    <div class="card">
                                        <div class="card-body" style="padding:0;">
                                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                                <li class="nav-item"><a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Generali</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Colli (<?php echo sizeof($attivita_bolla->colli) ?>)</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab3" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Pedane  (<?php echo sizeof($attivita_bolla->pedane) ?>)</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab4" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Materiale</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab5" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Segnalazioni (<?php echo sizeof($attivita_bolla->segnalazioni) ?>)</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab6" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Clichè (<?php echo sizeof($attivita_bolla->cliche) ?>)</a></li>
                                                <li class="nav-item"><a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#tab7" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Moduli Qualit&agrave; (<?php echo sizeof($attivita_bolla->moduli_qualita) ?>)</a></li>
                                            </ul>
                                            <div class="tab-content" id="custom-content-below-tabContent">
                                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                    <textarea class="form-control form-control-lg" type="text" placeholder="Note Attività" style="height:250px;font-size:16px;" readonly><?php echo $attivita_bolla->NotePrBLAttivita ?></textarea>
                                                </div>
                                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                                                    <button type="submit" name="stampa_tutti_colli" value="stampa_tutti" class="btn btn-success btn-sm" style="float:right;margin:10px;">Stampa Tutti Colli</button>
                                                    <button type="submit" name="stampa_tutte_etichette" value="stampa_tutte_etichette" class="btn btn-success btn-sm" style="float:right;margin:10px;">Stampa Tutte Etichette</button>
                                                    <?php if(sizeof($stampe_libere) > 0){ ?>
                                                    <button type="button" class="btn btn-success btn-sm" style="float:right;margin:10px;" onclick="stampe_libere();">Stampe Libere</button>
                                                    <?php } ?>

                                                    <div class="clearfix"></div>

                                                    <section class="content">
                                                        <div class="container-fluid">

                                                            <div id="ajax_loader_colli" class="row">


                                                            </div>

                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                                    <table id="lista_materiali_bolla" class="table table-bordered table-striped" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Descrizione</th>
                                                            <th style="width:250px;">Peso</th>
                                                            <th>NumeroColli</th>
                                                            <th>Versamento</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($attivita_bolla->pedane as $p) { ?>

                                                        <tr  <?php echo ($p->Confermato == 1)?'style="background:rgba(46, 204, 113,0.2)"':'' ?>>
                                                            <td class="no-sort"><?php echo $p->Nr_Pedana ?></td>
                                                            <td class="no-sort">
                                                                Peso Lordo: <?php echo $p->PesoLordo  ?><br>
                                                                Peso Netto: <?php echo $p->PesoNetto  ?><br>
                                                                Peso Nettissimo: <?php echo $p->PesoNettissimo  ?><br>
                                                                Peso Tara: <?php echo $p->PesoTara  ?><br>
                                                                Peso Tara2: <?php echo $p->PesoTara2  ?><br>
                                                                Qta. Prod: <?php echo $p->QuantitaProdotta ?><br>
                                                                Pedana: <?php echo $p->Cd_xPD ?>
                                                            </td>
                                                            <td class="no-sort"><?php echo $p->NumeroColli ?></td>
                                                            <td class="no-sort"><?php echo $p->Id_PrVrAttivita ?></td>
                                                            <td class="no-sort">

                                                                <a class="btn btn-primary btn-sm" onclick="azioni_pedana(<?php echo $p->Id_xWPPD ?>)">Azioni</a>
                                                                <?php if($p->Confermato == 0 && $p->NumeroColli > 0){ ?>
                                                                <form method="post" onsubmit="return confirm('Vuoi Confermare questa Pedana ?')">
                                                                    <input type="hidden" name="Id_xWPPD" value="<?php echo $p->Id_xWPPD ?>">
                                                                    <input type="submit" name="conferma_pedana" value="Conferma" class="btn btn-success btn-sm">
                                                                </form>
                                                                <?php } ?>
                                                            </td>

                                                        </tr>

                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="custom-content-below-profile-tab" style="padding:10px;">

                                                    <a onclick="aggiungi_materiali()" class="btn btn-success" style="float:right;margin-top:10px;margin-bottom:10px;">Aggiungi</a>
                                                    <table id="lista_materiali_bolla" class="table table-bordered table-striped" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Cd_AR</th>
                                                            <th>Consumo</th>
                                                            <th>MAG</th>
                                                            <th>Ubicazione</th>
                                                            <th>Lotto Consigliato</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php  $i = 0; ?>
                                                        <?php foreach($attivita_bolla->materiali as $m) { ?>

                                                        <tr>
                                                            <td class="no-sort">
                                                                <?php echo $m->Cd_AR ?><br>
                                                                <small><?php echo $m->NotePrBLMateriale ?></small>
                                                            </td>
                                                            <td class="no-sort"><?php echo $m->Consumo ?> <?php echo $m->Cd_ARMisura ?>
                                                                <?php if($m->FattoreToUM1 < 1){ ?>
                                                                <br>UM Fatt: (<?php echo number_format($m->FattoreToUM1,6,'.','') ?>)
                                                                <?php } ?>
                                                            </td>
                                                            <td class="no-sort"><?php echo $m->Cd_MG ?></td>
                                                            <td class="no-sort"><?php echo $m->Cd_MGUbicazione ?></td>
                                                            <td class="no-sort"><?php echo $m->Cd_ARLotto ?></td>
                                                            <td>
                                                                <a style="float:left;margin-left:5px;" class="btn btn-danger btn-sm" onclick="elimina_materiale(<?php echo $m->Id_PrBLMateriale ?>,'<?php echo $m->Cd_AR ?>')">Elimina</a>
                                                            </td>

                                                        </tr>

                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                                                    <table id="lista_segnalazioni" class="table table-bordered table-striped" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th style="width:100px;">Data Ora</th>
                                                            <th style="width:100px;">Operatore</th>
                                                            <th>Segnalazione</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>


                                                        <?php foreach($attivita_bolla->segnalazioni as $c) { ?>

                                                        <tr>
                                                            <td class="no-sort"><?php echo date('d/m/Y\<\b\r\>H:i:s',strtotime($c->TimeIns)) ?></td>
                                                            <td class="no-sort"><?php echo $c->Cd_Operatore ?></td>
                                                            <td class="no-sort"><?php echo $c->Messaggio ?></td>
                                                        </tr>

                                                        <?php } ?>
                                                        </tbody>
                                                    </table>

                                                </div>


                                                <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="custom-content-below-profile-tab" style="padding:10px;">

                                                    <div class="row">
                                                        <div class="col-md-8">

                                                            <h2 style="padding:10px;">Allegati</h2>
                                                            <table id="lista_materiali_bolla" class="table table-bordered table-striped" style="width:100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Articolo</th>
                                                                    <th>Nome File</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach($attivita_bolla->cliche as $all) { ?>
                                                                <tr>
                                                                    <td class="no-sort"><?php echo $all->EntityId ?></td>
                                                                    <td class="no-sort"><?php echo urldecode($all->FileName) ?></td>
                                                                    <td class="no-sort"><a href="<?php echo $all->FilePath.'\\'.$all->FileName ?>" target="_blank" class="btn btn-sm btn-success">Visualizza</td>
                                                                </tr>
                                                                <?php } ?>

                                                                </tbody>
                                                            </table>

                                                            <?php if(sizeof($cliche) > 0){ ?>
                                                            <textarea class="form-control" disabled style="height:150px;"><?php echo $cliche[0]->xCLdesColori ?></textarea>
                                                            <?php } ?>
                                                        </div>

                                                        <div class="col-md-4">

                                                            <?php if(sizeof($cliche) > 0){ ?>
                                                            <table id="lista_moduli_qualita" class="table table-bordered table-striped" style="width:100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nr.</th>
                                                                    <th>Gomma</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $i = 1; foreach($cliche[0]->gomme as $gomma){ ?>
                                                                <tr>
                                                                    <td><?php echo $i ?></td>
                                                                    <td><?php echo $gomma->Cd_AR ?></td>
                                                                </tr>
                                                                <?php $i++;} ?>
                                                                </tbody>
                                                            </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                                                    <a onclick="aggiungi_qualita()" class="btn btn-success" style="float:right;margin-top:10px;margin-bottom:10px;">Aggiungi</a>
                                                    <table id="lista_moduli_qualita" class="table table-bordered table-striped" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Cd_Operatore</th>
                                                            <th>Note</th>
                                                            <th>Data</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($attivita_bolla->moduli_qualita as $q) { ?>

                                                        <tr>
                                                            <td class="no-sort"><?php echo $q->Cd_Operatore ?></td>
                                                            <td class="no-sort"><?php echo $q->Note ?></td>
                                                            <td class="no-sort"><?php echo date('d/m/Y',strtotime($q->TimeIns)) ?></td>
                                                            <td>
                                                                <a style="float:left;margin-left:5px;" class="btn btn-primary btn-sm" target="_blank" href="<?php echo URL::asset('stampa/qualita/'.$q->Id_xFormQualita) ?>">Stampa</a>
                                                                <a style="float:left;margin-left:5px;" class="btn btn-danger btn-sm" onclick="elimina_qualita(<?php echo $q->Id_xFormQualita ?>)">Elimina</a>

                                                            </td>
                                                        </tr>

                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-custom-content">


                                                <?php if(sizeof($attivita_bolla->gruppo_lavoro) > 0){ ?>


                                                <table id="lista_gruppo_lavoro" class="table table-bordered table-striped" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Operatore</th>
                                                        <th>Funzione</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>


                                                    <tr>
                                                        <td class="no-sort"><?php echo $utente->Cd_Operatore ?></td>
                                                        <td class="no-sort">Capoturno</td>
                                                    </tr>


                                                    <?php foreach($attivita_bolla->gruppo_lavoro as $gl) { ?>

                                                    <?php
                                                    $gruppo = 'Capo Reparto';
                                                    if($gl->Funzione == 'A') $gruppo = 'Assistente';
                                                    if($gl->Funzione == 'R') $gruppo = 'Responsabile';
                                                    ?>

                                                    <tr>
                                                        <td class="no-sort"><?php echo $gl->Cd_Operatore ?></td>
                                                        <td class="no-sort"><?php echo $gruppo ?></td>
                                                        <td class="no-sort">
                                                            <form method="post" onsubmit="return confirm('vuoi eliminare questo operatore ?')">
                                                                <input type="hidden" name="Id_xwpGruppiLavoro" value="<?php echo $gl->Id_xwpGruppiLavoro ?>">
                                                                <input type="submit" name="elimina_utente_gruppo" class="btn btn-danger btn-sm" value="Elimina">
                                                            </form>
                                                        </td>

                                                    </tr>

                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                                <?php } ?>


                                                <?php $qta_colli = 0; ?>
                                                <?php foreach($attivita_bolla->colli as $colli) if($colli->NC == 0 and $colli->Id_PrVrAttivita == null) $qta_colli+= $colli->QtaProdottaUmFase; ?>

                                                <h3 style="font-size:18px;padding-left:10px;">Prodotto <?php echo number_format($qta_colli,2,'.','')?> di <?php echo number_format($attivita_bolla->QuantitaDaProdurre,2,'.','') ?> <?php echo $attivita_bolla->Cd_ARMisura ?> su <?php echo number_format($attivita_bolla->Quantita,2,'.','') ?> <?php echo $attivita_bolla->Cd_ARMisura ?></h3>
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>

                                </div>
                                <div class="col-md-4" style="margin-top:10px;">


                                </div>


                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Operatore</label>
                                    <input class="form-control form-control-lg" type="text" placeholder="Cd_Operatore" value="<?php echo $utente->Cd_Operatore ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label>Risorsa</label>

                                    <?php if(sizeof($ultima_rilevazione) > 0 && $ultima_rilevazione[0]->InizioFine == 'I'){ ?>
                                    <select name="Cd_PrRisorsa" class="form-control select2" readonly>
                                        <option value="<?php echo $ultima_rilevazione[0]->Cd_PrRisorsa ?>"><?php echo $ultima_rilevazione[0]->Cd_PrRisorsa ?></option>
                                    </select>
                                    <?php } else { ?>
                                    <select name="Cd_PrRisorsa" class="form-control select2">
                                        <?php foreach($risorse as $r){ ?>
                                        <option value="<?php echo $r->Cd_PrRisorsa ?>" <?php echo ($attivita_bolla->Cd_PrRisorsa == $r->Cd_PrRisorsa)?'selected':''  ?>><?php echo $r->Cd_PrRisorsa ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>

                                </div>
                                <div class="col-md-2">
                                    <label>Terminale</label>
                                    <select name="Terminale" class="form-control select2" readonly>
                                        <option value="<?php echo $utente->Cd_Terminale ?>"><?php echo $utente->Cd_Terminale ?></option>
                                    </select>
                                </div>
                                <div class="col-md-3" >
                                    <label>Attività</label>
                                    <input class="form-control form-control-lg" type="text" placeholder="Id_PrBLAttivita" value="<?php echo $attivita_bolla->Id_PrBLAttivita ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>

        <div class="row">

            <div class="col-12">

                <!-- /.card -->
                <div class="card card-danger">
                    <div class="card-body">

                        <h3>Versamenti su Questa Bolla</h3>




                        <table id="lista_versamenti" class="table table-bordered table-striped datatable" style="width:100%">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Data</th>
                                <th>Risorsa</th>
                                <th>Operatore</th>
                                <th>Quantita Versata</th>
                                <th>Scarto</th>
                                <th>Attrezzaggio</th>
                                <th>Esecuzione</th>
                                <th>Fermo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($attivita_bolla->versamenti as $v)

                                <tr>
                                    <td class="no-sort"><?php echo isset($v->Id_PrVRAttivita)?$v->Id_PrVRAttivita:$v->Id_PRVRAttivita  ?></td>
                                    <td class="no-sort"><small><?php echo trim($v->NotePRVRAttivita) ?></small><br><?php echo $v->Data ?></td>
                                    <td class="no-sort"><?php echo isset($v->Cd_PrRisorsa)?$v->Cd_PrRisorsa:$v->Cd_PRRisorsa  ?></td>
                                    <td class="no-sort"><?php echo $v->Cd_Operatore ?></td>
                                    <td class="no-sort"><?php echo $v->Quantita ?></td>
                                    <td class="no-sort"><?php echo $v->Quantita_Scar ?></td>
                                    <td class="no-sort"><?php echo $v->Attrezzaggio ?></td>
                                    <td class="no-sort"><?php echo $v->Esecuzione ?></td>
                                    <td class="no-sort"><?php echo $v->Fermo ?></td>
                                </tr>

                                <?php if($v->UltimoVR == 1){ ?>

                                <script type="text/javascript">
                                    alert('Questa Bolla è stata chiusa in precedenza');
                                    top.location.href='/';
                                </script>
                                <?php } ?>
                            @endforeach
                            </tbody>
                        </table>
                        </table>
                    </div>
                </div>
            </div>

            <?php if(sizeof($contatori) > 0){ ?>
            <div class="col-12">

                <!-- /.card -->
                <div class="card card-danger">
                    <div class="card-body">

                        <h3>Contatori su Questa Bolla</h3>

                        <table id="lista_contatori" class="table table-bordered table-striped datatable" style="width:100%">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Data</th>
                                <th>Operatore</th>
                                <th>Contatore</th>
                                <th>Collo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contatori as $c)

                                <tr>
                                    <td class="no-sort"><?php echo $c->Id_xContatore  ?></td>
                                    <td class="no-sort"><?php echo date('d/m/Y H:i:s',strtotime($c->TimeIns))  ?></td>
                                    <td class="no-sort"><?php echo $c->Cd_Operatore  ?></td>
                                    <td class="no-sort"><?php echo $c->contatore  ?></td>
                                    <td class="no-sort"><?php echo $c->xWPCollo  ?></td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                        </table>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <!-- /.row -->
    </section>
</div>


<div class="modal fade" id="modal_scegli_um">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Scegli Unità di Misura Per la Saldatura</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <select id="cd_armisura_modal" class="form-control select2">
                            <?php foreach($articolo->UM as $um){ ?>
                            <option value="<?php echo $um->Cd_ARMisura ?>"><?php echo $um->Cd_ARMisura ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>


            <div class="modal-footer">
                <div class="modal-footer">
                    <button type="submit" data-dismiss="modal" class="btn btn-primary" onclick="$('#cd_armisura_top').val($('#cd_armisura_modal').val())">Salva</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php if(($OLAttivita->Cd_PrAttivita == 'SALDATURA' || $OLAttivita->Cd_PrAttivita == 'TAGLIO') && sizeof($attivita_bolla->colli) == 0 && sizeof($attivita_bolla->pedane) > 0 && $stato_attuale == 'IE'){ ?>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#modal_scegli_um').modal('show');
    });
</script>
<?php } ?>

<form method="post">

    <div class="modal fade" id="modal_fine_lavorazione">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fine Lavorazione</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <?php $qta_colli = 0;$qta_colli_nc = 0; ?>
                        <?php foreach($attivita_bolla->colli as $colli) if($colli->NC == 0 && $colli->Id_PrVrAttivita == null) $qta_colli+= $colli->QtaProdotta; ?>
                        <?php foreach($attivita_bolla->colli as $colli_nc) if($colli_nc->NC == 1) $qta_colli_nc += $colli_nc->QtaProdotta; ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Qta Dei Colli (<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Cd_ARMisura:'' ?>)</label>
                                <input id="quantita_totale" name="quantita_totale" type="number" step="1" min="0" value="<?php echo $qta_colli ?>" class="form-control" readonly onkeyup="calcola_scarto()">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantità Contatore (<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Cd_ARMisura:'' ?>)</label>
                                <input id="quantita_rilevata" name="quantita_contatore" type="text" step="1" min="0" value="<?php echo ($OLAttivita->Cd_PrAttivita == 'SALDATURA')?$qta_colli:'' ?>"  onkeyup="calcola_scarto()"  onchange="calcola_scarto()" class="form-control keyboard_num" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Scarto Contatore (<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Cd_ARMisura:'' ?>)</label>
                                <input id="quantita_scarto" type="number" step="1" min="0" value="0" class="form-control" name="quantita_scarto" readonly onkeyup="calcola_scarto()">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Scarto N.C. (<?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Cd_ARMisura:'' ?>)</label>
                                <input id="quantita_scarto_nc" type="number" step="1" min="0"  class="form-control" name="quantita_scarto_nc" value="<?php echo $qta_colli_nc ?>" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label>U.M.</label>
                            <?php if($OLAttivita->Cd_PrAttivita == 'SALDATURA'){ ?>
                            <select name="xCd_ARMisura" class="form-control select2" readonly>
                                <?php foreach($articolo->UM as $um){ ?>
                                <option value="<?php echo $um->Cd_ARMisura ?>" <?php echo ($um->TipoARMisura == 'V')?'selected':'' ?>><?php echo $um->Cd_ARMisura ?></option>
                                <?php } ?>
                            </select>
                            <?php } else { ?>
                            <select name="xCd_ARMisura" class="form-control select2" readonly>
                                <option value="<?php echo $attivita_bolla->Cd_ARMisura ?>"><?php echo $attivita_bolla->Cd_ARMisura ?></option>
                            </select>
                            <?php } ?>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Scarto Versamento (<?php echo $attivita_bolla->Cd_ARMisura ?>)</label>
                                <input id="quantita_scarto_vr" type="number" step="1" min="0"  class="form-control" name="quantita_scarto_vr" value="<?php echo $qta_colli_nc ?>" readonly>
                                <small>Fattore di Conversione <?php echo (sizeof($attivita_bolla->colli) > 0)?$attivita_bolla->colli[0]->Cd_ARMisura:'' ?> -> <?php echo $attivita_bolla->Cd_ARMisura ?> =<b id="umfatt"></b></small>
                            </div>
                        </div>



                        <div class="col-md-12" style="margin-top:10px;">
                            <h2>Vuoi Chiudere la Bolla ?</h2>
                        </div>

                        <div class="col-md-4">
                            <input style="width: 100%;display: block;font-size: 70px;margin: 20px auto auto auto;" type="submit" name="fine_lavorazione_si" value="SI" class="btn btn-success">
                        </div>
                        <div class="col-md-4">
                            <input style="width: 100%;display: block;font-size: 70px;margin: 20px auto auto auto;"  type="submit" name="fine_lavorazione_no" value="NO" class="btn btn-primary">
                        </div>
                        <div class="col-md-4">
                            <button style="width: 100%;display: block;line-height:105px;font-size: 30px;margin: 20px auto auto auto;"  type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div class="modal-footer">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</form>

<form method="post">

    <div class="modal fade" id="modal_inserisci_contatore">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Contatore</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Inserisci Contatore</label>
                                <input id="contatore" name="contatore" type="text" step="1" min="0" value="" class="form-control keyboard_num">
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top:10px;text-align: center">
                            <h2>Vuoi inserire il contatore ?</h2>
                        </div>

                        <div class="col-md-6" style="text-align: center ">
                            <input style="width: 100%;display: block;font-size: 70px;" type="submit" name="xcontatore" class="btn btn-success" value="SI">
                        </div>

                        <div class="col-md-6">
                            <input style="width: 100%;display: block;font-size: 70px;" type="submit" name="xcontatore" class="btn btn-danger" value="NO">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</form>

<form method="post">

    <div class="modal fade" id="modal_chiudi_bolla">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vuoi Chiudere la Bolla ?</h4>
                    modal_fine_lavorazione
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <b>Chiudendo la Bolla non Potrai più riaprirla, vuoi proseguire ?</b>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input type="submit" name="chiudi_bolla" value="Chiudi Bolla" class="btn btn-success">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</form>

<form method="post">
    <div class="modal fade" id="modal_fine_attrezzaggio">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fine Attrezzaggio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <?php /*
                    <div class="row">
                        <?php foreach($causali_scarto as $cs){ ?>
                        <div class="col-lg-3 col-6" style="cursors:pointer" onclick="$('#causale_scarto_attrezzaggio').val('<?php echo $cs->Cd_PRCausaleScarto ?>')">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p><?php echo $cs->Descrizione ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
 */ ?>
                    <?php if ($OLAttivita->Cd_PrAttivita != 'SALDATURA') { ?>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Causale di Scarto</label>
                                <input id="causale_scarto_attrezzaggio" type="text" class="form-control keyboard">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Quantita di Scarto</label>
                                <input id="quantita_scarto_attrezzaggio" type="text" class="form-control keyboard_num">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <a class="form-control btn btn-success" onclick="aggiungi_scarto_attrezzaggio()">Aggiungi Scarto</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($OLAttivita->Cd_PrAttivita == 'STAMPA') { ?>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Operatore Montaclichè</label>
                                <select name="Cd_Operatore2" class="form-control select2" required>
                                    <option value="">Seleziona un Operatore</option>
                                    <?php foreach($operatori_montacliche as $o){ ?>
                                    <option value="<?php echo $o->Cd_Operatore ?>"><?php echo $o->Descrizione ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <?php } ?>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                    <input type="submit" name="fine_attrezzaggio" value="Fine Attrezzaggio" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">
    <div class="modal fade" id="modal_collo_non_conforme">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Collo Non Conforme <span id="nr_collo_non_conforme"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <?php foreach($causali_scarto as $cs){ ?>
                        <div class="col-lg-3 col-6" style="cursors:pointer" onclick="$('#causale_scarto_non_conforme').val('<?php echo $cs->Cd_PRCausaleScarto ?>')">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p><?php echo $cs->Descrizione ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Causale di Scarto</label>
                                <input id="causale_scarto_non_conforme" type="text" name="Cd_PRCausaleScarto" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="id_collo_non_conforme" name="Id_xWPCollo" value="">
                    <input type="submit" name="collo_non_conforme" value="Salva" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">

    <div class="modal fade" id="modal_invia_segnalazione">
        <div class="modal-dialog modal-lg" style="width:90%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Invia Segnalazione</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <?php foreach($anomalie_fermo as $af){ ?>
                        <div class="col-lg-3 col-6" style="cursors:pointer" onclick="$('#causale_segnalazione').val('<?php echo $af->Descrizione ?>');$('#modal_invia_segnalazione').animate({scrollTop:$('#causale_segnalazione').position().top+600}, 'slow');">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p><?php echo $af->Descrizione ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>


                    <div class="row">

                        <div class="col-md-12">
                            <label>Segnalazione</label>
                            <textarea id="causale_segnalazione" class="form-control form-control-lg keyboard" type="text" name="Messaggio" placeholder="Messaggio" style="height:300px;font-size:18px;" required></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                    <input type="submit" name="invia_segnalazione" value="Invia Segnalazione" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</form>

<form method="post">
    <div class="modal fade" id="modal_inizia_fermo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Inizio Fermo Macchina</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <b style="padding:10px;">Confermi l'inizio del fermo macchina ?</b>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                    <input type="submit" name="inizio_fermo" value="Inizio Fermo" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">
    <div class="modal fade" id="modal_fine_fermo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fine Fermo Macchina</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <?php foreach($causali_fermo as $cf){ ?>
                        <div class="col-lg-3 col-6" style="cursors:pointer" onclick="$('#causale_fermo').val('<?php echo $cf->Cd_PRCausaleFermo ?>')">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p><?php echo $cf->Descrizione ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> Causale del Fermo <b style="color:red">*</b></label>
                                <select id="causale_fermo" name="Cd_PRCausaleFermo" class="form-control select2" required>
                                    <option value="">Scegli una Causale</option>
                                    <?php foreach($causali_fermo as $cf){ ?>
                                    <option value="<?php echo $cf->Cd_PRCausaleFermo ?>"><?php echo $cf->Cd_PRCausaleFermo ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control select2" onchange="$('#note_fermo').val($('#note_fermo').val()+$('option:selected',this).text()+'\n');">
                                    <option value="Scegli una Causale di Fermo">Scegli una Causale di Fermo</option>
                                    <?php foreach($anomalie_fermo as $af){ ?>
                                    <option value="<?php echo $af->Descrizione  ?>"><?php echo $af->Descrizione  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea id="note_fermo" name="NotePrRLAttivita" style="height:200px;" class="form-control keyboard" placeholder="Inserisci una nota Libera"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                    <input type="submit" name="fine_fermo" value="Fine Fermo" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">
    <div class="modal fade" id="modal_aggiungi_pedana" >
        <div class="modal-dialog modal-lg" style="width:90%!important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Aggiungi Pedana</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <p style="padding:20px;">
                            Vuoi Creare una Pedana Nuova Confermando le pedane precedentemente caricate ?<br>
                        </p>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">

                    <input type="hidden" name="Cd_xPD" value="">
                    <input type="hidden" name="Cd_ARMisura" value="<?php echo $attivita_bolla->Cd_ARMisura ?>">
                    <input type="hidden" name="Cd_PrRisorsa" value="<?php echo $attivita_bolla->Cd_PrRisorsa ?>">
                    <input type="submit" name="crea_pedana" value="Crea pedana" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">
    <div class="modal fade" id="modal_aggiungi_utente" >
        <div class="modal-dialog modal-lg" style="width:90%!important;">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Aggiungi Utente Gruppo</h4>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Operatore</label>
                                <select name="Cd_Operatore" class="form-control select2">
                                    <?php foreach($operatori as $o){ ?>
                                    <?php if($o->Cd_Operatore != $utente->Cd_Operatore ){?>
                                    <option value="<?php echo $o->Cd_Operatore ?>" <?php echo (trim($o->Cd_Operatore) == trim($utente->Cd_Operatore2))?'selected':'' ?>><?php echo $o->Descrizione ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Funzione</label>
                                <select id="funzione" name="Funzione" class="form-control select2">
                                    <option value="C">Capo Reparto</option>
                                    <option value="A" selected>Assistente</option>
                                    <option value="R">Responsabile</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">

                    <input type="submit" id="bottone_aggiungi_utente_gruppo" name="aggiungi_utente_gruppo" value="Aggiungi Utente" class="btn btn-primary">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<form method="post">

    <div class="modal fade" id="modal_aggiungi_qualita">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Aggiungi Modulo di Qualita</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <label>Temperatura Bruciatore B1</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Temperatura Bruciatore B2</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Temperatura Tunnel</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Temperatura Gruppo Stampa</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <hr>

                        <div class="col-md-6">
                            <label>Temperatura Svolgitore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Temperatura Avvolgitore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Calanadra Alimentatore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Calandra Traino</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Trattamento Macchina</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Potenza Applicata</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Fornitore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Etichetta Fornitore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Tipo Materiale</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Trattamento</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Num Dyne</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Spessore Materiale</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Fascia Materiale</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Lotto Materiale</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Tipologia di Stampa</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="0">Interno</option>
                                <option value="1">Esterno</option>
                            </select>
                        </div>

                        <div class="clearfix"></div>

                        <?php for($i=1;$i<=10;$i++) { ?>
                        <hr>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?></label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Anilox</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Viscosita</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Bioadesivo</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Delta Colore</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Metri Verifica</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <div class="col-md-6">
                            <label>Colore<?php echo $i ?> Metri Annotazioni</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>
                        <?php } ?>


                        <div class="col-md-6">
                            <label>Verifica Congruenza PDF</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Presenza Riferimenti Stampa</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Presenze Tirelle</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Passo Stampa e Cilindro</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Di Svolgimento</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Adesioni Inchiostri</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Verifica Adesione Vernice / Mattatura</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="col-md-6">
                            <label>Test Residuo Solventi</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="0">Interno</option>
                                <option value="1">Esterno</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Valore Riscontrato</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>


                        <div class="col-md-6">
                            <label>Verifica Lettura Codice a Barre</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Test Asedione Inchiostro</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="1">Positivo</option>
                                <option value="0">Negativo</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Lavoro Completato</label>
                            <select name="json_dati[]" class="form-control select2">
                                <option value="1">SI</option>
                                <option value="0">NO</option>
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label>Quantità Lavorata</label>
                            <input type="text" class="form-control" name="json_dati[]" value="">
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label>Note Varie</label>
                            <input type="text" class="form-control" name="Note" value="">
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_Operatore" value="<?php echo $utente->Cd_Operatore ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:right;" type="submit" name="aggiungi_qualita" value="Aggiungi" class="btn btn-primary">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</form>

<form method="post">

    <div class="modal fade" id="modal_aggiungi_materiale">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Aggiungi Materiale</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label>Lotto</label>
                            <input class="form-control" type="text" name="Cd_ARLotto" placeholder="Lotto Materiale" onkeyup="controlla_lotto($(this).val())" required>
                        </div>
                        <div class="col-md-12">
                            <label>Cd_AR</label>
                            <select name="Cd_AR" class="form-control" id="articoli_lotto">
                                <option value="">Codice Articolo</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Quantità</label>
                            <input class="form-control" type="number" step="0.1" id="quantita_inserisci_materiale" name="Quantita" placeholder="Qta" min="0" required>
                        </div>


                        <div class="col-md-6">
                            <label>UM</label>
                            <select name="Cd_ARMisura" class="form-control" id="articoli_um">
                                <option value="">Inserisci Lotto</option>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label>Magazzino</label>
                            <select name="Cd_MG" class="form-control" id="magazzini_lotto">
                                <option value="">Inserire Lotto</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Ubicazione</label>
                            <input class="form-control" type="text" name="Cd_MGUbicazione" value="">
                        </div>

                        <div class="col-md-4">
                            <label>Tipo</label>
                            <input id="inserisci_tipo_materiale" class="form-control" type="text" name="Tipo" value="2" readonly>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_Operatore" value="<?php echo $utente->Cd_Operatore ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:left;" class="btn btn-primary" type="submit" name="aggiungi_materiale" value="Aggiungi Materiale">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</form>

<form method="post">

    <div class="modal fade" id="modal_elimina_materiale">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Materiale</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <p style="padding:10px;">Vuoi Eliminare il Materiale <b id="cd_ar_elimina_materiale"></b> dalla bolla ?</p>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="Cd_Operatore" value="<?php echo $utente->Cd_Operatore ?>">
                    <input type="hidden" id="input_elimina_id_materiale" name="Id_PrBLMateriale" value="" required>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:left;" class="btn btn-primary" type="submit" name="elimina_materiale" value="Elimina Materiale">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</form>

<form method="post">

    <div class="modal fade" id="modal_elimina_qualita">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Elimina Modulo di Qualita</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <b>Vuoi Eliminare questo Modulo di Qualità ?</b>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="id_elimina_qualita" name="Id_xFormQualita">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:right;" type="submit" name="elimina_qualita" value="Elimina" class="btn btn-primary">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</form>

<?php foreach($attivita_bolla->pedane as $p) { ?>


<form method="post">
    <div class="modal fade" id="modal_azioni_pedana_<?php echo $p->Id_xWPPD ?>" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Azioni Pedana <?php echo $p->Nr_Pedana ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Peso Lordo</label>
                            <input type="text" id="pesolordo_<?php echo $p->Id_xWPPD ?>" name="PesoLordo" value="<?php echo number_format($p->PesoLordo,2,'.','') ?>" class="form-control" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)">
                        </div>

                        <div class="col-md-4">
                            <label>Peso Netto</label>
                            <input type="text" id="pesonetto_<?php echo $p->Id_xWPPD ?>" name="PesoNetto" value="<?php echo number_format($p->PesoNetto,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Peso Nettissimo</label>
                            <input type="text" id="pesonettissimo_<?php echo $p->Id_xWPPD ?>" name="PesoNettissimo" value="<?php echo number_format($p->PesoNettissimo,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Peso Bobina</label>
                            <input type="text" id="pesobobina_<?php echo $p->Id_xWPPD ?>" value="<?php echo number_format($articolo->xPesobobina,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <?php
                        $peso_mt = 0;
                        if(sizeof($mandrini) > 0) $peso_mt = $mandrini[0]->xPesoalmt * ($articolo->xBase/1000);
                        ?>

                        <div class="col-md-4">
                            <label>Numero Colli</label>
                            <input id="numerocolli_<?php echo $p->Id_xWPPD ?>" type="number" step="1" name="NumeroColli" value="<?php echo $p->NumeroColli ?>" class="form-control" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)">
                        </div>

                        <div class="col-md-4">
                            <label>Peso Anima</label>
                            <input id="pesoanima_<?php echo $p->Id_xWPPD ?>" type="number" step="1" value="<?php echo number_format($peso_mt,4,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Peso Pedana</label>
                            <input id="pesopedana_<?php echo $p->Id_xWPPD ?>" type="text" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Peso Tara (Bobina + Pedana)</label>
                            <input id="pesotara_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Peso Tara2 (Anima * Colli)</label>
                            <input id="pesotara2_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara2" value="<?php echo number_format($peso_mt * $p->NumeroColli ,2,'.','') ?>" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <h3 style="margin-top:20px;">Colli Associati</h3>
                    <div class="items-collection">
                        <div class="row">

                            <?php foreach($attivita_bolla->colli as $c){ ?>

                            <?php if($c->NC == 0){ ?>

                            <div class="col-md-3">
                                <div class="info-block block-info">
                                    <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                        <label class="btn btn-default">
                                            <div class="itemcontent">
                                                <input type="checkbox" name="colli_associati[]" autocomplete="off" value="<?php echo $c->Id_xWPCollo ?>" <?php echo ($c->Nr_Pedana == $p->Nr_Pedana)?'checked="checked"':'' ?> style="position: absolute;clip: rect(0,0,0,0);pointer-events: none;">
                                                <h5><?php echo $c->Nr_Collo ?><br>
                                                    <small><?php echo number_format($c->QtaProdotta,2,'.','') ?> <?php echo $c->Cd_ARMisura ?><br><?php echo $c->Nr_Pedana ?></small>
                                                </h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="display:block;">
                    <input type="hidden" name="Id_xWPPD" value="<?php echo $p->Id_xWPPD ?>">
                    <input type="hidden" name="Nr_Pedana" value="<?php echo $p->Nr_Pedana ?>">
                    <button style="float:right;" type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:right;" type="submit" name="modifica_pedana" value="Modifica" class="btn btn-primary">

                    <input style="float:left;" type="submit" name="stampa_etichetta_pedana" value="Stampa Etichetta" class="btn btn-success">
                    <input style="float:left;margin-left:5px;" type="submit" name="stampa_foglio_pedana" value="Stampa Foglio" class="btn btn-success">


                    <?php if($p->NumeroColli == 0){ ?>
                    <input style="float:left;" type="submit" name="elimina_pedana" value="Elimina" class="btn btn-danger pull-left">
                    <?php } ?>


                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<?php } ?>


@include('backend.common.footer')

<?php if($stato_attuale == 'IA' || $stato_attuale == 'IE' || $stato_attuale == 'IF'){ ?>


<script type="text/javascript">

    setInterval(function() {
        var timespan = countdown(new Date("<?php echo $ultima_rilevazione[0]->DataOra ?>"), new Date());
        var div = document.getElementById('time');
        div.innerHTML = '('+parseInt(timespan.hours)+":"+parseInt(timespan.minutes)+":"+parseInt(timespan.seconds)+')'
    }, 2000);


</script>

<?php } ?>

<form method="post">
    <div class="modal fade" id="modal_stampe_libere">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Stampe Libere</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">

                            <?php foreach($stampe_libere as $sl){ ?>
                            <a class="btn btn-primary" style="float:left;" target="_blank" href="<?php echo URL::asset('stampa_libera/'.$attivita_bolla->Id_PrBLAttivita.'/'.urlencode($sl->RI_COLLO)) ?>"><?php echo $sl->Descrizione ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <!-- /.modal-dialog -->
    </div>
</form>



<?php foreach($attivita_bolla->segnalazioni as $c) { ?>
<?php if($c->Id_PrBLAttivita == $attivita_bolla->Id_PrBLAttivita){ ?>

<form method="post">
    <div class="modal fade" id="modal_alert_segnalazione_<?php echo $c->Id_xWPSegnalazione ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Alert Segnalazione</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">
                            <label>Segnalazione del <?php echo date('d/m/Y H:i:s',strtotime($c->TimeIns)) ?></label>
                            <textarea class="form-control form-control-lg" type="text" name="Messaggio" placeholder="Messaggio" style="height:300px;font-size:18px;" readonly><?php echo $c->Messaggio ?></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <!-- /.modal-dialog -->
    </div>
</form>

<div id="ajax_loader"></div>

<script type="text/javascript">
    //$('#modal_alert_segnalazione_<?php echo $c->Id_xWPSegnalazione ?>').modal('show');
</script>
<?php } ?>
<?php } ?>

<script type="text/javascript">

    id_riga_scarto_attrezzaggio = 1;
    qta_ultimo_collo = 0;
    umfatt = 1;

    <?php foreach($articolo->UM as $um){ ?>
        <?php if($um->TipoARMisura == 'V'){ ?>
        umfatt = <?php echo $um->UMFatt ?>
    <?php } ?>
    <?php } ?>

    $('#umfatt').html(umfatt);



    <?php if(sizeof($attivita_bolla->colli) > 0) { ?>
        qta_ultimo_collo = <?php echo $attivita_bolla->colli[0]->QtaProdotta; ?>
        <?php } ?>


        function stampe_libere(){

            $('#modal_stampe_libere').modal('show');
        }

    function calcola_scarto(){
        quantita_rilevata = $('#quantita_rilevata').val();
        quantita_totale = $('#quantita_totale').val();
        quantita_scarto = parseFloat(quantita_rilevata) - parseFloat(quantita_totale);
        quantita_scarto_nc = parseFloat($('#quantita_scarto_nc').val());
        $('#quantita_scarto').val(quantita_scarto);
        $('#quantita_scarto_vr').val(parseFloat((quantita_scarto + quantita_scarto_nc)).toFixed(2));
    }

    function controlla_lotto(lotto){
        $.get('<?php echo URL::asset('ajax/controlla_lotto') ?>/'+lotto, function( data ) {
            $('#ajax_loader').html(data);
        });
    }

    function aggiungi_qualita(){

        $('#modal_aggiungi_qualita').modal('show');
    }

    function aggiungi_materiali(){

        $('#modal_aggiungi_materiale').modal('show');
    }

    function elimina_materiale(id_materiale,cd_ar){

        $('#cd_ar_elimina_materiale').html(cd_ar);
        $('#input_elimina_id_materiale').val(id_materiale);
        $('#modal_elimina_materiale').modal('show');

    }

    function modifica_qualita(id){

        alert("Modifica qualità");
    }

    function elimina_qualita(id){

        $('#id_elimina_qualita').val(id);
        $('#modal_elimina_qualita').modal('show');
    }

    function elimina_scarto_attrezzaggio(id){
        $('#id_riga_scarto_attrezzaggio_'+id).remove();
    }

    function aggiungi_scarto_attrezzaggio(){

        $('#tabella_scarti').append('<div class="row" id="id_riga_scarto_attrezzaggio_'+id_riga_scarto_attrezzaggio+'"></div>');
        $('#id_riga_scarto_attrezzaggio_'+id_riga_scarto_attrezzaggio).append('<div class="col-md-5"><input type="text" name="Cd_PRCausaleScarto[]" value="'+$('#causale_scarto_attrezzaggio').val()+'" class="form-control" readonly></div>');
        $('#id_riga_scarto_attrezzaggio_'+id_riga_scarto_attrezzaggio).append('<div class="col-md-5"><input type="text" name="Quantita[]" value="'+$('#quantita_scarto_attrezzaggio').val()+'" class="form-control" readonly></div>');
        $('#id_riga_scarto_attrezzaggio_'+id_riga_scarto_attrezzaggio).append('<div class="col-md-2"> <a class="form-control btn btn-success" onclick="elimina_scarto_attrezzaggio('+id_riga_scarto_attrezzaggio+')">Elimina Scarto</a></div>');

        id_riga_scarto_attrezzaggio = parseInt(id_riga_scarto_attrezzaggio)+1;
        $('#quantita_scarto_attrezzaggio').val('');
        $('#causale_scarto_attrezzaggio').val('');
    }

    function azioni_collo(id_collo){
        $('.form_colli').hide();
        $('#form_collo_'+id_collo).show();
        $('#form_collo_'+id_collo).css('position','fixed');
        $('#form_collo_'+id_collo).css('top','200px');
        $('#form_collo_'+id_collo).css('right','20px');
        $('#form_collo_'+id_collo).css('width','28%');

        //$("html, body").animate({ scrollTop: 0 })
    }

    function aggiungi_pedana(){
        $('#modal_aggiungi_pedana').modal('show');
    }

    function azioni_pedana(id_pedana){
        $('#modal_azioni_pedana_'+id_pedana).modal('show');;
    }

    function fine_lavorazione(){

        $('#modal_fine_lavorazione').modal('show');
        calcola_scarto();
    }
    function inserisci_contatore(){

        $('#modal_inserisci_contatore').modal('show');
    }

    function fine_attrezzaggio(){

        $('#modal_fine_attrezzaggio').modal('show');
    }

    function chiudi_bolla(){

        $('#modal_chiudi_bolla').modal('show');
    }

    function premi_tasto(character) {

        quantita = $('#quantita_prodotta_ss').val();
        $('#quantita_prodotta_ss').val(quantita+character);
    }


    function invia_segnalazione(){

        $('#modal_invia_segnalazione').modal('show');
    }

    function invia_fermo(){

        $('#modal_inizia_fermo').modal('show');
    }

    function fine_fermo(){

        $('#modal_fine_fermo').modal('show');
    }

    function aggiungi_utente(){

        $('#modal_aggiungi_utente').modal('show');
    }

    function nuovo(){
        $('#quantita_prodotta_ss').removeAttr('readonly');
        $('#bottone_nuovo').attr('disabled',true);
        $('#quantita_prodotta_ss').val(qta_ultimo_collo);

        abilita_stampa();

        if(qta_ultimo_collo == 0) $('#quantita_prodotta_ss').focus();
    }

    function calcola_pesi(id){
        peso_lordo = $('#pesolordo_'+id).val()
        peso_bobina = $('#pesobobina_'+id).val()
        peso_anima = $('#pesoanima_'+id).val()
        numero_colli = $('#numerocolli_'+id).val()
        peso_pedana = $('#pesopedana_'+id).val()
        $('#pesonetto_'+id).val(parseFloat(parseFloat(peso_lordo) - parseFloat(peso_pedana)).toFixed(2));
        $('#pesotara2_'+id).val(parseFloat(parseFloat(peso_anima) * parseFloat(numero_colli)).toFixed(2));
        $('#pesotara_'+id).val(parseFloat(parseFloat(peso_pedana)).toFixed(2));
        $('#pesonettissimo_'+id).val(parseFloat(parseFloat(peso_lordo) - parseFloat(peso_pedana) - (parseFloat(peso_anima) * parseFloat(numero_colli))).toFixed(2));
    }


    $('.keyboard_num:not(readonly)').keyboard({ layout: 'num',   visible: function(e, keyboard, el) {
            keyboard.$preview[0].select();
        } });
    $('.keyboard:not(readonly)').keyboard({ layout: 'qwerty' });


    if(window.location.hash != '') {
        $(".nav-link[href*='"+window.location.hash+"']").click();
    }

    <?php if($OLAttivita->Cd_PrAttivita == 'ESTRUSIONE' && sizeof($attivita_bolla->gruppo_lavoro) == 0) { ?>
    $('#modal_aggiungi_utente').modal('show');
    <?php if($utente->Cd_Operatore2 > 0){ ?>
    $('#bottone_aggiungi_utente_gruppo').click();
    <?php } ?>
    <?php } ?>

    function abilita_stampa(){

        numero = parseInt($('#quantita_prodotta_ss').val())
        if(numero > 0){
            $('#quantita_prodotta_ss').removeAttr('readonly');
            $('#bottone_nuovo').attr('disabled',true);
            $('#bottone_stampa').removeAttr('disabled');
        } else {
            if(qta_ultimo_collo > 0) {
                $('#quantita_prodotta_ss').attr('readonly', true);
                $('#bottone_nuovo').removeAttr('disabled');
                $('#bottone_stampa').attr('disabled', true);
            }
        }
    }

    function non_conforme(id_collo,Nr_Collo){

        $('#modal_collo_non_conforme').modal('show');
        $('#id_collo_non_conforme').val(id_collo);
        $('#nr_collo_non_conforme').html(Nr_Collo);
    }


    $.ajax({
        url: "<?php echo URL::asset('ajax/load_colli') ?>/<?php echo $attivita_bolla->Id_PrBLAttivita ?>"
    }).done(function (result) {
        $('#ajax_loader_colli').html(result);
    });


</script>

<?php if(isset($_GET['stampa'])){ ?>

<script type="text/javascript">

    <?php $stampe = explode(',',$_GET['stampa']); ?>
        pdf = [
        <?php foreach($stampe as $st) echo "'".URL::asset('upload/'.$st.'.pdf')."'," ?>
    ];


    function stampav2(pos) {

        if (pdf[pos]) {

            printJS(pdf[pos]);
            $.get("<?php echo URL::asset('ajax/set_stampato') ?>/"+pdf[pos].substring(pdf[pos].lastIndexOf('/')+1), function( data ) {});
            timer = setTimeout(stampaprintjs, 7500);

            function stampaprintjs() {

                newpos = parseInt(pos) + 1
                stampav2(newpos);
            }

        } else {
            clearInterval(timer);
            top.location.href = "<?php echo URL::asset('dettaglio_bolla/' . $attivita_bolla->Id_PrBLAttivita) ?>#tab2";
        }
    }

    function stampa(pos) {

        if (pdf[pos]) {

            var wnd = window.open(pdf[pos]);
            wnd.print();
            timer = setTimeout(closewindow, 7500);


            $.get("<?php echo URL::asset('ajax/set_stampato') ?>/"+pdf[pos].substring(pdf[pos].lastIndexOf('/')+1), function( data ) {});

            function closewindow() {
                clearTimeout(timer);
                wnd.close();
                newpos = parseInt(pos) + 1
                stampa(newpos);
            }

        } else {
            top.location.href = "<?php echo URL::asset('dettaglio_bolla/' . $attivita_bolla->Id_PrBLAttivita) ?>";
        }
    }


    stampav2(0);




</script>

<?php } ?>


<style>
    #search {
        width:90%;
    }

    .searchicon {
        color:#5CB85C;
    }

    .items-collection{
        margin:5px 0 0 0;
    }
    .items-collection label.btn-default.active{
        background-color:#007ba7;
        color:#FFF;
    }
    .items-collection label.btn-default{
        width:100%;
        border:1px solid #305891;
        border-radius: 17px;
        color: #305891;
    }
    .items-collection label .itemcontent{
        width:100%;
    }
    .items-collection .btn-group{
        width:100%
    }
</style>

