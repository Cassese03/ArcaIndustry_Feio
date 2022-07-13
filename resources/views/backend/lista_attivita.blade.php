@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo ($Cd_Attivita != null)?$Cd_Attivita:'Tutte le Attività' ?></h1>
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
                                        <th>Attività</th>

                                        <th style="width:120px;">Qta.</th>
                                        <th style="width:120px;">Qta Da Rilasciare</th>
                                        <th style="width:100px;">Progress</th>
                                        <th style="width: 100px">Perc.</th>
                                        <th style="width:150px;"></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach($attivita as $a){  ?>

                                        <?php

                                            $percent = $a->PercRilasciata;
                                             $color = 'warning'; if($percent >= 85) $color='success'; if($percent < 30) $color='danger';
                                        ?>

                                        <tr>
                                            <td>
                                                <?php echo $a->Descrizione ?><br>
                                                    <small><?php echo $a->Articolo ?></small>
                                                    <?php if($a->NotePrOLAttivita != ''){ ?>
                                                        <br>------------------<br>
                                                        <small><?php echo $a->NotePrOLAttivita ?></small>
                                                    <?php } ?>
                                            </td>
                                            <td><?php echo $a->Quantita ?></td>
                                            <td><?php echo $a->QuantitaDaRilasciare ?></td>
                                            <td><div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar bg-<?php echo $color ?>" style="width: <?php echo $percent ?>%"></div>
                                                </div></td>
                                            <td><span class="badge bg-<?php echo $color ?>"><?php echo $percent ?>%</span></td>
                                            <td><a style="float:left" href="<?php echo URL::asset('dettaglio_odl/'.$a->Id_PrOLAttivita) ?>" class="btn btn-success btn-sm" >Dettagli</a></td>
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

