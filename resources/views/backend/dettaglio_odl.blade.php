@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ODL: <?php echo $ordine->Numero ?> DEL <?php echo date('d/m/Y',strtotime($ordine->Data)) ?></h1>
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
                            <table class="table table-bordered">
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

                                    <tr <?php echo ($id_attivita == $b->Id_PrOLAttivita)?'style="background:rgba(46, 204, 113,0.2)"':'' ?>>
                                        <td>
                                            Bolla: <b><?php echo $b->Id_PrBL ?></b> &nbsp;&nbsp;&nbsp;Attivita: <b><?php echo $b->Id_PrBLAttivita ?></b><br>
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
    <!-- /.content -->

</div>

@include('backend.common.footer')

