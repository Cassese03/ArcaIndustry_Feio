@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h1 class="m-0">Bolle Da Chiudere Imballaggio</h1>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            <h1>Bolle che si possono chiudere</h1>
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <form method="post" onsubmit="return confirm('Vuoi Chiudere Tutte le Bolle ?')">
                                <input type="submit" name="chiudi_tutte_le_bolle" value="Chiudi Tutte le Bolle" class="btn btn-success" style="float:right;margin-bottom:20px;">
                            </form>

                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th>N. Bolla</th>
                                        <th>Data</th>
                                        <th>Articolo</th>
                                        <th>Qta/Qta Prod.</th>
                                        <th>Progress</th>
                                        <th>Perc</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($bolle_da_chiudere as $b){ ?>

                                <?php

                                $percent = $b->PercProdotta;
                                $color = 'warning'; if($percent >= 85) $color='success'; if($percent < 30) $color='danger';
                                ?>

                                <tr>
                                    <td><?php echo $b->Numero ?></td>
                                    <td><?php echo date('d/m/Y',strtotime($b->Data)) ?></td>
                                    <td><?php echo $b->Articolo ?></td>
                                    <td><?php echo number_format($b->Quantita,2,'.','').'/'.number_format($b->QuantitaProdotta,2,'.','') ?></td>
                                    <td><div class="progress progress-xs">
                                            <div class="progress-bar progress-bar bg-<?php echo $color ?>" style="width: <?php echo $percent ?>%"></div>
                                        </div></td>
                                    <td><span class="badge bg-<?php echo $color ?>"><?php echo $percent ?>%</span></td>

                                    <td>
                                        <form method="post" onsubmit="return confirm('Vuoi Chiudere Questa Bolla ?')">
                                            <input type="hidden" name="Id_PrBLAttivita" value="<?php echo $b->Id_PrBLAttivita ?>">
                                            <input type="submit" name="chiudi_bolla" value="Chiudi Bolla" class="btn btn-success">
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.row -->
    </section>


</div>



@include('backend.common.footer')

<script type="text/javascript">

    function filtra_bolla(){

        Nr_Pedana = $('#numero_bolla').val().replaceAll('.','').replaceAll('P','').toUpperCase();

        if(Nr_Pedana != '') {
            $('.pedana').css('display','none');
            $('div[id*="P'+Nr_Pedana+'"]').css('display','block');

            if($('div[id*="P'+Nr_Pedana+'"]').length == 1){
                $( "#P"+Nr_Pedana ).trigger( "click" );

            }

            localStorage.setItem("filtro_ricerca",Nr_Pedana);

        } else {

            localStorage.setItem("filtro_ricerca","");
            $('.pedana').css('display','none');
        }

    }

    $('#numero_bolla').val(localStorage.getItem("filtro_ricerca"));
    filtra_bolla();

    function gotobolla(){

        numero_bolla = $('#numero_bolla').val();
        if(numero_bolla != '') {

            $.get("<?php echo URL::asset('ajax/get_bolla') ?>/"+numero_bolla, function( data ) {
                if(data != ''){
                    top.location.href = '<?php echo URL::asset('dettaglio_bolla') ?>/' + data
                }
            });


        } else alert('inserire numero bolla');

    }


    function azioni_pedana(id_pedana){

        $('#modal_azioni_pedana_'+id_pedana).on('shown.bs.modal', function () {
            $('#pesolordo_'+id_pedana).focus();
            if($('#pesolordo_'+id_pedana).val() != '') {
                $('#pesolordo_' + id_pedana).trigger($.Event('keypress', {keyCode: 116, which: 116}));
            }
            calcola_pesi();
        });

        $('#modal_azioni_pedana_'+id_pedana).modal('show');

    }


    function rileva_pedana(id_pedana){
        $('#modal_rileva_pedana_'+id_pedana).modal('show');
    }

    function calcola_pesi(id){
        $('#pesolordo_'+id).val($('#pesolordo_'+id).val().replaceAll(',','.'));
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


<style>

    .form-control {
        font-size: 1.5rem;
    }
</style>


