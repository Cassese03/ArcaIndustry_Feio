@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Documenti di Carico</h1>
                </div>

            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">

                            <a href="<?php echo URL::asset('logistic_crea_documento') ?>" class="btn btn-success" style="width:100%">Crea Documento</a>
                            <div class="clearfix" style="margin-bottom:20px;"></div>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Codice</th>
                                    <th>Numero</th>
                                    <th>Data</th>
                                    <th>Cliente</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 1;$i<=30;$i++){ ?>
                                        <tr style="cursor:pointer;" onclick="top.location.href='<?php echo URL::asset('logistic_evadi_documento') ?>'">
                                            <td>OAF</td>
                                            <td><?php echo $i ?></td>
                                            <td>11-7-2014</td>
                                            <td>Cliente XXX</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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

