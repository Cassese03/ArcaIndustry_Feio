@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo ($Cd_Attivita != null)?'Bolle Attive Attività "'.$Cd_Attivita.'"':'Tutte le Bolle Attive' ?></h1>
                </div>

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered datatable">
                                <thead>

                                    <tr>
                                        <th>Id</th>
                                        <th style="width:120px;">Qta.</th>
                                        <th style="width:120px;">Qta Prodotta</th>
                                        <th style="width:100px;">Progress</th>
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
                                                Bolla: <b><?php echo $b->Id_PrBL ?></b> &nbsp;&nbsp;&nbsp;Attivita: <b><?php echo $b->Id_PrBLAttivita ?></b><br>
                                                    <small><?php echo $b->Articolo ?></small>
                                                    <?php if($b->NotePrBLAttivita != ''){ ?>
                                                        <br>------------------<br>
                                                        <small><?php echo $b->NotePrBLAttivita ?></small>
                                                    <?php } ?>
                                            </td>
                                            <td><?php echo $b->Quantita ?></td>
                                            <td><?php echo $b->QuantitaProdotta ?></td>
                                            <td><div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar bg-<?php echo $color ?>" style="width: <?php echo $percent ?>%"></div>
                                                </div></td>
                                            <td><span class="badge bg-<?php echo $color ?>"><?php echo $percent ?>%</span></td>
                                            <td>
                                                <a style="width:100%;" href="<?php echo URL::asset('dettaglio_bolla/'.$b->Id_PrBL) ?>" class="btn btn-success btn-sm" >Dettagli</a>
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
    <!-- /.content -->

</div>

@include('backend.common.footer')

<div id="ajax_loader"></div>

<script type="text/javascript">


    function versamenti(id_prblattivita){

        $.get('<?php echo URL::asset('ajax/lista_versamenti') ?>/'+id_prblattivita, function( data ) {
            $('#ajax_loader').html(data);
            $('#modal_lista_versamenti').modal('show');
        });
    }

</script>
