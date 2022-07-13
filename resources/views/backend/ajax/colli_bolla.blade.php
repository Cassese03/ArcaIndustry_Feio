

    <?php
        foreach($attivita_bolla->colli as $c){
            if($c->NC == 0){
                $background = ($c->Id_PrVrAttivita != null && $c->NC == 0)?'green':'yellow';
            } else {
                $background = ($c->Id_PrVrAttivita != null && $c->NC == 1)?'cyan':'red';
            }
    ?>


        <div class="col-lg-2 col-6 collo" style="cursor:pointer;color:white!important;" onclick="azioni_collo(<?php echo $c->Id_xWPCollo ?>)" id="collo_<?php echo $c->Id_xWPCollo ?>">
            <!-- small box -->
            <div class="small-box bg-<?php echo $background ?>">
                <div class="inner">
                    <b style="font-size:19px;">Collo <?php echo ($c->NC == 1)?'NC':'' ?>: <?php echo $c->Descrizione ?></b><br>
                    <small style="font-size:18px;">
                        <?php if($c->Nr_Pedana != ''){ ?>Pedana: <?php echo $c->Nr_Pedana ?><br><?php } ?>
                        <?php if($c->NC == 1){ ?>Causale: <?php echo $c->Cd_PRCausaleScarto ?><br><?php } ?>
                        <?php if($c->Id_PrVrAttivita != ''){ ?>Ver: <?php echo $c->Id_PrVrAttivita ?><br><?php } ?>
                        Qta: <?php echo number_format($c->QtaProdotta,2,'.','') ?> <?php echo $c->Cd_ARMisura ?>
                    </small>
                </div>
            </div>
        </div>


    <form method="post">
        <div class="row form_colli" id="form_collo_<?php echo $c->Id_xWPCollo ?>"  style="z-index:1000;display:none;border:1px solid #dee2e6;padding:10px;background:#f4f6f9;" >

            <div class="col-md-12">
                <h4 style="float:left;" >Azioni Collo <?php echo $c->Nr_Collo ?></h4>

                <button style="float:right;font-size: 40px;margin-top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.form_colli').hide();">
                    <span aria-hidden="true">×</span></button>
            </div>

            <div class="col-md-6">
                <label>Qta Prodotta (<?php echo $c->Cd_ARMisura ?>)</label>
                <input class="form-control keyboard_num" type="text" step="0.1" name="QtaProdotta" value="<?php echo number_format($c->QtaProdotta,1,'.','') ?>">
                <?php if($c->QtaProdottaUmFase != $c->QtaProdotta){ ?>
                <small>Corrisponde a <?php echo number_format($c->QtaProdottaUmFase,3,'.','') ?> <?php echo $attivita_bolla->Cd_ARMisura ?></small>
                <?php } ?>
            </div>

            <div class="col-md-6">
                <label>Copie</label>
                <input class="form-control keyboard_num" type="text" step="1" min="1" max="10" name="Copie" value="<?php echo $c->Copie ?>">
            </div>

            <div class="col-md-12">
                <label>Nr_Pedana</label>
                <select name="Nr_Pedana_Collo" class="form-control">
                    <?php foreach($attivita_bolla->pedane as $p) { ?>
                    <option value="<?php echo $p->Nr_Pedana ?>" <?php echo ($p->Nr_Pedana == $c->Nr_Pedana)?'selected':'' ?>><?php echo $p->Nr_Pedana ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6">
                <label>Bobina Madre 1</label>
                <input class="form-control keyboard" type="text" name="Rif_Nr_Collo" value="<?php echo $c->Rif_Nr_Collo ?>">
            </div>


            <div class="col-md-6">
                <label>Bobina Madre 2</label>
                <input class="form-control keyboard" type="text" name="Rif_Nr_Collo2" value="<?php echo $c->Rif_Nr_Collo2 ?>">
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <input type="hidden" name="Id_xWPCollo" value="<?php echo $c->Id_xWPCollo ?>">
                <input type="hidden" name="Nr_Collo" value="<?php echo $c->Nr_Collo ?>">
                <input type="hidden" name="Cd_ARMisura" value="<?php echo $c->Cd_ARMisura ?>">

                <div class="row">

                    <div class="col-md-6">
                        <input style="width:100%;" type="submit" name="modifica_collo" value="Salva" class="btn btn-primary">
                    </div>

                    <div class="col-md-6">
                        <input style="width:100%;" type="submit" name="elimina_collo" value="Elimina" class="btn btn-danger pull-left">
                    </div>

                    <div class="col-md-6" style="margin-top:5px;">
                        <input style="width:100%;" type="submit" name="stampa_collo" value="Stampa Collo" class="btn btn-success">
                    </div>

                    <div class="col-md-6" style="margin-top:5px;">
                        <input style="width:100%;" type="submit" name="stampa_collo_qualita" value="Stampa Qualità" class="btn btn-success">
                    </div>

                    <?php if($c->NC == 0){ ?>
                        <div class="col-md-12" style="margin-top:5px;">
                            <a style="width:100%;color:white;"  class="btn btn-warning" onclick="non_conforme(<?php echo $c->Id_xWPCollo ?>,'<?php echo $c->Nr_Collo ?>')">Collo non Conforme</a>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>
    </form>


    <?php } ?>


    <script type="text/javascript">

        $('.keyboard_num:not(readonly)').keyboard({ layout: 'num',   visible: function(e, keyboard, el) {
                keyboard.$preview[0].select();
            } });
        $('.keyboard:not(readonly)').keyboard({ layout: 'qwerty' });

        $('form').submit(function(){
            $('#ajax_loader').fadeIn();
        });

    </script>
