
<?php if($p->Imballato == 0){ ?>
    <form method="post">
    <div class="modal fade" id="modal_azioni_pedana_<?php echo $p->Id_xWPPD ?>" >
        <div class="modal-dialog modal-lg" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Azioni Pedana <?php echo $p->Nr_Pedana.' ('.$p->Descrizione_Articolo.')' ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">
                            <label>Peso Lordo</label>
                            <input type="text" id="pesolordo_<?php echo $p->Id_xWPPD ?>" name="PesoLordo" value="<?php echo ($p->PesoLordo > 0)?number_format($p->PesoLordo,2,'.',''):'' ?>" class="form-control keyboard_num" onchange="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)">
                        </div>

                        <div class="col-md-4">
                            <label>Numero Copie</label>
                            <input id="numerocolli_<?php echo $p->Copie ?>" type="text" step="1" name="Copie" value="<?php echo $p->Copie ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Numero Colli</label>
                            <input id="numerocolli_<?php echo $p->Id_xWPPD ?>" type="text" step="1" name="NumeroColli" value="<?php echo $p->NumeroColli ?>" class="form-control keyboard_num" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Peso Bobina</label>
                            <input type="text" id="pesobobina_<?php echo $p->Id_xWPPD ?>" value="<?php echo number_format($p->xPesobobina,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Peso Netto</label>
                            <input type="text" id="pesonetto_<?php echo $p->Id_xWPPD ?>" name="PesoNetto" value="<?php echo number_format($p->PesoNetto,2,'.','') ?>" class="form-control" readonly required>
                        </div>

                        <?php
                        $peso_mt = 0;
                        if(sizeof($p->mandrini) > 0) $peso_mt = $p->mandrini[0]->xPesoalmt * ($p->xBase/1000);
                        ?>

                        <div class="col-md-3">
                            <label>Peso Anima</label>
                            <input id="pesoanima_<?php echo $p->Id_xWPPD ?>" type="number" step="1" value="0" class="form-control" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Peso Nettissimo</label>
                            <input type="text" id="pesonettissimo_<?php echo $p->Id_xWPPD ?>" name="PesoNettissimo" value="<?php echo number_format($p->PesoNettissimo,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Peso Pedana</label>
                            <input id="pesopedana_<?php echo $p->Id_xWPPD ?>" type="text" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control keyboard_num" onchange="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)">
                        </div>

                        <div class="col-md-4">
                            <label>Peso Tara (Bobina + Pedana)</label>
                            <input id="pesotara_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Peso Tara2 (Anima * Colli)</label>
                            <input id="pesotara2_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara2" value="<?php echo number_format($peso_mt * $p->NumeroColli ,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-12">
                            <label>Pedana Epal ?</label>
                            <select id="pedana_<?php echo $p->Id_xWPPD ?>" name="Cd_xPD" class="form-control select2" required style="height:50px;" required>
                                <option value="">Nessuna Pedana Selezionata</option>
                                <option value="05.00001" <?php echo ($p->Cd_xPD == '05.00001')?'selected':'' ?>>SI</option>
                                <option value="0" <?php echo ($p->Cd_xPD == '0')?'selected':'' ?>>NO</option>
                            </select>
                        </div>


                    <?php if(isset($p->colli)){ ?>
                        <h3 style="margin-top:20px;">Colli Associati</h3>
                        <div class="items-collection">
                            <div class="row">
                                <?php foreach($p->colli as $c){ ?>
                                    <?php if($c->NC == 0){ ?>
                                        <div class="col-md-2">
                                            <div class="info-block block-info">
                                                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                                    <label class="btn btn-default <?php echo ($c->Nr_Pedana == $p->Nr_Pedana)?'active':'' ?>">
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
                        <?php } ?>

                        <div class="col-md-12">
                            <label>Note</label>
                            <textarea class="form-control keyboard" disabled style="height:300px;"><?php echo $p->NotePrBLAttivita  ?></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer" style="display:block;">
                    <input type="hidden" name="Id_xWPPD" value="<?php echo $p->Id_xWPPD ?>">
                    <input type="hidden" name="Nr_Pedana" value="<?php echo $p->Nr_Pedana ?>">
                    <input type="hidden" name="Id_PrOL" value="<?php echo $p->Id_PrOL ?>">
                    <input type="hidden" name="Id_PrBLAttivita" value="<?php echo $p->Id_PrBLAttivita ?>">
                    <input type="hidden" name="Id_PrRLAttivita" value="<?php echo $p->Id_PrRLAttivita ?>">
                    <input type="hidden" name="Id_PrVRAttivita" value="<?php echo $p->Id_PrVrAttivita ?>">
                    <button style="float:right;" type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:right;" type="submit" name="modifica_pedana_stampa_versa" value="Modifica,Stampa e Versa" class="btn btn-primary">

                    <input style="float:left;color:white;" type="submit" name="stampa_etichetta_pedana" value="Stampa Etichetta" class="btn btn-primary">
                    <input style="float:left;margin-left:5px;color:white;" type="submit" name="stampa_foglio_pedana" value="Stampa Foglio" class="btn btn-primary">

                    <?php if($p->PesoLordo > 0){ ?>
                     <input style="float:left;margin-left:5px;" type="submit" name="versa_pedana" value="Effettua Versamento" class="btn btn-success">
                    <?php } ?>

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
    <form method="post">
    <div class="modal fade" id="modal_rileva_pedana_<?php echo $p->Id_xWPPD ?>" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Inizio Rilevazione Pedana <?php echo $p->Nr_Pedana ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label>Vuoi Iniziare la Rilevazione di della Pedana <?php echo $p->Nr_Pedana ?> ?</label>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer" style="display:block;">
                    <input type="hidden" name="Id_xWPPD" value="<?php echo $p->Id_xWPPD ?>">
                    <input type="hidden" id="Nr_Pedana_<?php echo $p->Id_xWPPD ?>" name="Nr_Pedana" value="<?php echo $p->Nr_Pedana ?>">
                    <input type="hidden" name="Id_PrBLAttivita" value="<?php echo $p->Id_PrBLAttivita ?>">
                    <button style="float:right;" type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                    <input style="float:right;" type="submit" name="inizio_rilevazione" value="Inizia Rilevazione" class="btn btn-primary">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<?php } else { ?>
    <form method="post">
    <div class="modal fade" id="modal_azioni_pedana_<?php echo $p->Id_xWPPD ?>" >
        <div class="modal-dialog modal-lg" style="max-width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Azioni Pedana <?php echo $p->Nr_Pedana ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Peso Lordo</label>
                            <input type="text" id="pesolordo_<?php echo $p->Id_xWPPD ?>" name="PesoLordo" value="<?php echo ($p->PesoLordo > 0)?number_format($p->PesoLordo,2,'.',''):'' ?>" class="form-control" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Numero Copie Di Stampa</label>
                            <input id="numerocolli_<?php echo $p->Copie ?>" type="number" step="1" name="Copie" value="<?php echo $p->Copie ?>" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Numero Colli</label>
                            <input id="numerocolli_<?php echo $p->Id_xWPPD ?>" type="number" step="1" name="NumeroColli" value="<?php echo $p->NumeroColli ?>" class="form-control" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Peso Bobina</label>
                            <input type="text" id="pesobobina_<?php echo $p->Id_xWPPD ?>" value="<?php echo number_format($p->xPesobobina,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Peso Netto</label>
                            <input type="text" id="pesonetto_<?php echo $p->Id_xWPPD ?>" name="PesoNetto" value="<?php echo number_format($p->PesoNetto,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <?php
                        $peso_mt = 0;
                        if(sizeof($p->mandrini) > 0) $peso_mt = $p->mandrini[0]->xPesoalmt * ($p->xBase/1000);
                        ?>

                        <div class="col-md-3">
                            <label>Peso Anima</label>
                            <input id="pesoanima_<?php echo $p->Id_xWPPD ?>" type="number" step="1" value="<?php echo number_format($peso_mt,4,'.','') ?>" class="form-control" readonly>
                        </div>


                        <div class="col-md-3">
                            <label>Peso Nettissimo</label>
                            <input type="text" id="pesonettissimo_<?php echo $p->Id_xWPPD ?>" name="PesoNettissimo" value="<?php echo number_format($p->PesoNettissimo,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Peso Pedana</label>
                            <input id="pesopedana_<?php echo $p->Id_xWPPD ?>" type="text" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control keyboard_num" onchange="calcola_pesi(<?php echo $p->Id_xWPPD ?>)" onkeyup="calcola_pesi(<?php echo $p->Id_xWPPD ?>)">
                        </div>

                        <div class="col-md-4">
                            <label>Peso Tara (Bobina + Pedana)</label>
                            <input id="pesotara_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara" value="<?php echo number_format($p->PesoTara,2,'.','') ?>" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Peso Tara2 (Anima * Colli)</label>
                            <input id="pesotara2_<?php echo $p->Id_xWPPD ?>" type="text" name="PesoTara2" value="<?php echo number_format($peso_mt * $p->NumeroColli ,2,'.','') ?>" class="form-control" readonly>
                        </div>

                        <div class="col-md-12">
                            <label>Pedana Epal ?</label>
                            <select id="pedana_<?php echo $p->Id_xWPPD ?>" name="Cd_xPD" class="form-control select2" required style="height:50px;" required>
                                <option value="">Nessuna Pedana Selezionata</option>
                                <option value="05.00001" <?php echo ($p->Cd_xPD == '05.00001')?'selected':'' ?>>SI</option>
                                <option value="0" <?php echo ($p->Cd_xPD == '0')?'selected':'' ?>>NO</option>
                            </select>
                        </div>

                        <?php if(isset($p->colli)){ ?>
                            <h3 style="margin-top:20px;">Colli Associati</h3>
                            <div class="items-collection">
                                <div class="row">
                                    <?php foreach($p->colli as $c){ ?>

                                        <?php if($c->NC == 0){ ?>

                                            <div class="col-md-2">
                                                <div class="info-block block-info">
                                                    <div data-toggle="buttons" class="btn-group bizmoduleselect">
                                                        <label class="btn btn-default <?php echo ($c->Nr_Pedana == $p->Nr_Pedana)?'active':'' ?>">
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
                        <?php } ?>

                        <div class="col-md-12">
                            <label>Note</label>
                            <textarea class="form-control" disabled style="height:300px;"><?php echo $p->NotePrBLAttivita  ?></textarea>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer" style="display:block;">
                    <input type="hidden" name="Id_xWPPD" value="<?php echo $p->Id_xWPPD ?>">
                    <input type="hidden" name="Nr_Pedana" value="<?php echo $p->Nr_Pedana ?>">
                    <input type="hidden" name="Id_PrOL" value="<?php echo $p->Id_PrOL ?>">
                    <input type="hidden" name="Id_PrBLAttivita" value="<?php echo $p->Id_PrBLAttivita ?>">
                    <input type="hidden" name="Id_PrRLAttivita" value="<?php echo $p->Id_PrRLAttivita ?>">
                    <input type="hidden" name="Id_PrVRAttivita" value="<?php echo $p->Id_PrVrAttivita ?>">
                    <button style="float:right;" type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>

                    <input style="float:right;" type="submit" name="elimina_versamento" value="Elimina Versamento" class="btn btn-danger">

                    <input style="float:left;color:white;" type="submit" name="stampa_etichetta_pedana" value="Stampa Etichetta" class="btn btn-primary">
                    <input style="float:left;margin-left:5px;color:white;" type="submit" name="stampa_foglio_pedana" value="Stampa Foglio" class="btn btn-primary">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>
<?php } ?>

<script type="text/javascript">

    $('.keyboard_num:not(readonly)').keyboard({ layout: 'num',   visible: function(e, keyboard, el) {
            keyboard.$preview[0].select();
        } });
    $('.keyboard:not(readonly)').keyboard({ layout: 'qwerty' });

</script>


<style>

    .form-control {
        font-size: 1.5rem;
    }
</style>



<style>
    #search {
        width:90%;
    }

    .searchicon {
        color:#5CB85C;
    }

    .items-collection{
        margin:5px 0 0 0;
        width:100%;
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


