@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Carico Merce</h1>
                </div>

            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width:50px">Numero</th>
                                <th style="width:50px">Tipo</th>
                                <th>Data</th>
                                <th style="width:150px">Fornitore</th>
                                <th>Data di Consegna</th>
                                <th style="width:100px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for($i=1;$i<20;$i++){  ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><span class="badge bg-blue">OAF</span></td>
                                <td>Fornitore</td>
                                <td><?php echo date('d/m/Y') ?></td>
                                <td><?php echo date('d/m/Y') ?></td>
                                <td>
                                    <a style="float:left" href="#" class="btn btn-success btn-sm" >CONFERMA</a>
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
        <!-- /.row -->
    </section>
</div>

@include('backend.common.footer')

