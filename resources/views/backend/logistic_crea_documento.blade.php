@include('backend.common.header')
@include('backend.common.sidebar')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Carico di Magazzino</h1>
                </div>

            </div>
        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->

                <div class="card card-danger">
                    <div class="card-body">
                        <div class="col-md-12" style="float:left">
                            <input class="form-control form-control-lg" type="text" placeholder="Inserisci il Barcode">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Articoli Caricati</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width:50px">Codice</th>
                                <th style="width:50px">Descrizione</th>
                                <th>Quantità</th>
                                <th style="width:150px">Lotto</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php for($i=1;$i<5;$i++){  ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>XXX</td>
                                        <td>10</td>
                                        <td>XXX</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="clearfix" style="margin-bottom:20px;"></div>
                        <a style="float:right" href="#" class="btn btn-danger pull-right btn-lg" >CONFERMA</a>
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

