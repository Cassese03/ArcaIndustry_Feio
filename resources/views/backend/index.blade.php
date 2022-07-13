@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <h1 class="m-0">Bolle Attive <?php echo ($utente->Cd_Terminale != '')?$utente->Cd_Terminale:'' ?></h1>
                    </div><!-- /.col -->
                    <div class="col-md-6">
                        <input id="numero_bolla" class="form-control" type="text" name="numero_bolla" placeholder="Inserisci il Numero di Bolla o la Pedana">
                    </div>
                    <div class="col-md-2">
                        <input type="button" name="Cerca" class="btn btn-success" value="Cerca" onclick="gotobolla()" style="width:100%">
                    </div>



                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="width:100%;">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered datatable" style="width:100%;font-size:20px;">
                                <thead>
                                <tr>
                                    <th style="width:600px;">Bolla</th>
                                    <th>Qta.</th>
                                    <th style="width: 100px">Perc.</th>
                                    <th style="width:100px;"></th>
                                </tr>
                                </thead>
                                <tbody>


                                <?php foreach($bolle as $b){  ?>

                                <?php

                                $percent = $b->PercProdotta;
                                $color = 'warning'; if($percent >= 85) $color='success'; if($percent < 30) $color='danger';
                                ?>

                                <tr>
                                    <td>
                                        Ordine di Lavorazione: <b><?php echo $b->Id_PrOL ?></b> &nbsp;&nbsp;&nbsp;Bolla : <b><?php echo $b->Id_PrBLAttivita ?></b><br>
                                        <small><?php echo $b->Articolo ?></small>
                                    </td>
                                    <td>
                                        <?php echo number_format($b->QuantitaProdotta,4,'.','') ?>/<?php echo number_format($b->Quantita,4,'.','') ?><br>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar bg-<?php echo $color ?>" style="width: <?php echo $percent ?>%"></div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-<?php echo $color ?>"><?php echo $percent ?>%</span></td>
                                    <td>
                                        <a style="width:100%;" href="<?php echo URL::asset('dettaglio_bolla/'.$b->Id_PrBLAttivita) ?>" class="btn btn-success btn-sm" >Dettagli</a>
                                        <a style="width:100%;margin-top:5px;" class="btn btn-primary btn-sm" onclick="versamenti(<?php echo $b->Id_PrBLAttivita ?>)" >Versamenti</a>
                                    </td>
                                </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
            <!-- Main row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>


</div>

<div id="ajax_loader"></div>

@include('backend.common.footer')

<script type="text/javascript">

    function gotobolla(){

        numero_bolla = $('#numero_bolla').val();
        if(numero_bolla != '') {

            $.get("<?php echo URL::asset('ajax/get_bolla') ?>/"+numero_bolla, function( data ) {
                if(data != ''){
                    top.location.href = '<?php echo URL::asset('dettaglio_bolla') ?>/' + data
                }
            });

        }

    }


    $('#numero_bolla').keyup(function(event) {
        if (event.which === 13) {
            gotobolla()
        }
    });

</script>


<style>
    td{
        font-size:11px;
    }
    th{
        font-size:11px;
    }
</style>
