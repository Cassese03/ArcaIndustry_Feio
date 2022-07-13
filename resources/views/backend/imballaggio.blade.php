@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-4">
                    <h1 class="m-0">Sezione Imballaggio</h1>
                </div><!-- /.col -->
                <div class="col-md-6">
                    <input id="numero_bolla" onchange="filtra_bolla()" onkeyup="filtra_bolla()" class="form-control keyboard_num" type="text" name="numero_bolla" placeholder="Inserisci il Numero di Bolla o la Pedana">
                </div>
                <div class="col-md-2">
                    <input type="button" name="Cerca" class="btn btn-success" value="Cerca" onclick="gotobolla()" style="width:35%">
                    <input type="button" name="Crea Pedana" class="btn btn-success" value="Crea Pedana" onclick="creapedana()" style="width:60%;background-color: blue">
                </div>


            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <?php foreach($pedane as $p){ ?>
                <div class="col-lg-3 col-6 pedana ol_<?php echo $p->Id_PrOL ?> <?php echo $p->Nr_Pedana ?>" style="cursor:pointer;color:white;" id="<?php echo str_replace('.','',$p->Nr_Pedana) ?>" onclick="<?php echo ($p->Id_PrRLAttivita != '')?'azioni_pedana':'rileva_pedana' ?>(<?php echo $p->Id_xWPPD ?>)" >
                    <!-- small box -->
                    <div class="small-box bg-<?php echo ($p->Id_PrRLAttivita != '')?'green':'yellow' ?>">
                        <div class="inner">
                            <b style="font-size:20px;margin:0;display:block;"><?php echo $p->cliente ?></b>
                            <small><?php echo $p->Nr_Pedana ?> (<?php echo $p->NumeroColli ?> Colli) OL <?php echo $p->Id_PrOL ?></small><br>
                            <small style="font-size:20px;">
                                Peso Lordo: <?php echo number_format($p->PesoLordo,2,'.','') ?> Kg<br>
                                Peso Netto: <?php echo number_format($p->PesoNetto,2,'.','') ?> Kg<br>
                                Peso Nettissimo: <?php echo number_format($p->PesoNettissimo,2,'.','') ?> Kg<br>
                            </small>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a class="small-box-footer">Azioni Pedana<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <?php } ?>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <h1>Pedane Versate nelle ultime 24h</h1>
            <div class="row">

                <?php foreach($pedane_imballate as $p){ ?>

                <div class="col-lg-3 col-6 pedana ol_<?php echo $p->Id_PrOL ?> <?php echo $p->Nr_Pedana ?>" style="cursor:pointer;color:white;" id="<?php echo str_replace('.','',$p->Nr_Pedana) ?>" onclick="azioni_pedana(<?php echo $p->Id_xWPPD ?>)" >
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <b style="font-size:20px;margin:0;display:block;"><?php echo $p->cliente ?></b>
                            <small><?php echo $p->Nr_Pedana ?> (<?php echo $p->NumeroColli ?> Colli) OL <?php echo $p->Id_PrOL ?></small><br>
                            <small style="font-size:20px;">
                                Peso Lordo: <?php echo number_format($p->PesoLordo,2,'.','') ?> Kg<br>
                                Peso Netto: <?php echo number_format($p->PesoNetto,2,'.','') ?> Kg<br>
                                Peso Nettissimo: <?php echo number_format($p->PesoNettissimo,2,'.','') ?> Kg<br>
                            </small>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a class="small-box-footer">Azioni Pedana<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <?php } ?>
            </div>

        </div>
    </section>

</div>

<div id="ajax_loader2"></div>
<form method="post">
    <div class="modal fade" id="modal_crea_pedana">
        <div class="modal-dialog modal-lg" style="width:90%!important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Crea Pedana</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label>Inserisci Bolla</label>
                        <input type="text" class="form-control keyboard" name="Id_PRBLAttivita" required>
                        <div class="col-md-6">
                            <br>
                            <label>Pedana Epal?</label><br>
                            <label>Si</label>
                            <input type="radio"  name="Cd_xPD" value="05.00001" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>No</label>
                            <input type="radio"  name="Cd_xPD" value=" " required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <input type="submit" name="crea_pedana" value="Crea pedana" class="btn btn-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>


@include('backend.common.footer')


<script type="text/javascript">

    function errore(){
        alert('Impossibile creare la pedana');
    }
    $('.keyboard_num:not(readonly)').keyboard({ layout: 'num',   visible: function(e, keyboard, el) {
            keyboard.$preview[0].select();
        } });
    $('.keyboard:not(readonly)').keyboard({ layout: 'qwerty' });

    function filtra_bolla(){

        Nr_Pedana = $('#numero_bolla').val().replaceAll('.','').replaceAll('P','').toUpperCase();

        if(Nr_Pedana != '') {
            $('.pedana').css('display','none');
            $('div[id*="P'+Nr_Pedana+'"]').css('display','block');
            $('div[class*="bl_'+Nr_Pedana+'"]').css('display','block');
            $('div[class*="ol_'+Nr_Pedana+'"]').css('display','block');

            if($('div[id*="P'+Nr_Pedana+'"]').length == 1){
                $( "#P"+Nr_Pedana ).trigger( "click" );
            }

            localStorage.setItem("filtro_ricerca",Nr_Pedana);

        } else {
            localStorage.setItem("filtro_ricerca","");
        }

    }

    $('#numero_bolla').val(localStorage.getItem("filtro_ricerca"));
    filtra_bolla();

    function gotobolla(){
        top.location.href= '<?php echo URL::asset("imballaggio")?>'
    }
    function creapedana(){
        $('#modal_crea_pedana').modal('show');
    }

    function azioni_pedana(id_pedana){

        $.get('<?php echo URL::asset('ajax/modifica_pedana_imballaggio') ?>/'+id_pedana, function( data ) {
            $('#ajax_loader2').html(data);

            $('#modal_azioni_pedana_'+id_pedana).on('shown.bs.modal', function () {
                $('#pesolordo_'+id_pedana).focus()
            })

            $('#modal_azioni_pedana_'+id_pedana).modal('show');
        });



    }

    function rileva_pedana(id_pedana){

        $.get('<?php echo URL::asset('ajax/modifica_pedana_imballaggio') ?>/'+id_pedana, function( data ) {
            $('#ajax_loader2').html(data);

            $('#modal_rileva_pedana_' + id_pedana).modal('show');
            localStorage.setItem("filtro_ricerca", $('#Nr_Pedana_' + id_pedana).val());
        });
    }

    function calcola_pesi(id){
        peso_lordo = $('#pesolordo_'+id).val()
        peso_bobina = $('#pesobobina_'+id).val()
        peso_anima = $('#pesoanima_'+id).val()
        numero_colli = $('#numerocolli_'+id).val()
        peso_pedana = $('#pesopedana_'+id).val()
        $('#pesonetto_'+id).val(parseFloat(parseFloat(peso_lordo) - parseFloat(peso_pedana)).toFixed(2));
        $('#pesotara2_'+id).val(0);
//        $('#pesotara2_'+id).val(parseFloat(parseFloat(peso_anima) * parseFloat(numero_colli)).toFixed(2));
        $('#pesotara_'+id).val(parseFloat(parseFloat(peso_pedana)).toFixed(2));
        $('#pesonettissimo_'+id).val(parseFloat(parseFloat(peso_lordo) - parseFloat(peso_pedana) - (parseFloat(peso_anima) * parseFloat(numero_colli))).toFixed(2));
    }

    function cambia_peso_pedana(id){

        $('#pesopedana_'+id).val($('#pedana_'+id).find(':selected').attr('peso'));
        calcola_pesi(id);
    }

</script>

<?php if(isset($_GET['stampa'])){ ?>

<script type="text/javascript">

    <?php $stampe = explode(',',$_GET['stampa']); ?>
        pdf = [
        <?php foreach($stampe as $st) echo "'".URL::asset('upload/'.$st.'.pdf')."'," ?>
    ];

    function stampa(pos) {

        if (pdf[pos]) {

            var wnd = window.open(pdf[pos]);
            wnd.print();
            wnd.print();
            timer = setTimeout(closewindow, 5000);

            $.get("<?php echo URL::asset('ajax/set_stampato') ?>/"+pdf[pos].substring(pdf[pos].lastIndexOf('/')+1), function( data ) {});

            function closewindow() {
                clearTimeout(timer);
                wnd.close();
                newpos = parseInt(pos) + 1
                stampa(newpos);
            }
            var wnd = window.open(pdf[pos]);
            wnd.print();
            timer = setTimeout(closewindow, 5000);

            $.get("<?php echo URL::asset('ajax/set_stampato') ?>/"+pdf[pos].substring(pdf[pos].lastIndexOf('/')+1), function( data ) {});

            function closewindow() {
                clearTimeout(timer);
                wnd.close();
                newpos = parseInt(pos) + 1
                stampa(newpos);
            }

        } else {

            localStorage.setItem("filtro_ricerca","");
            top.location.href = "<?php echo URL::asset('imballaggio') ?>";
        }
    }


    stampa(0);

</script>

<?php } ?>

