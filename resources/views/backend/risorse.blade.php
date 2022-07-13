@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Risorse</h1>
                </div>

            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <?php foreach($risorse as $r){ ?>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?php echo $r->Cd_PrRisorsa ?></h3>
                                <small><?php echo $r->Descrizione ?></small>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo URL::asset('risorse/'.$r->Cd_PrRisorsa) ?>" class="small-box-footer">Maggiori Info<i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>

</div>

@include('backend.common.footer')

