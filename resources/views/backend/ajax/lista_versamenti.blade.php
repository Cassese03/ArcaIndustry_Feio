


<form method="post">

    <div class="modal fade" id="modal_lista_versamenti">
        <div class="modal-dialog modal-lg" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Versamenti Attivita <?php echo $id_PrBlAttivita ?></h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">


                    <table id="lista_versamenti" class="table table-bordered table-striped datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Risorsa</th>
                                <th>Operatore</th>
                                <th>Quantita Versata</th>

                                <th>Scarto</th>
                                <th>Attrezzaggio</th>
                                <th>Esecuzione</th>
                                <th>Fermo</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($versamenti as $v)

                            <tr>
                                <td class="no-sort"><?php echo $v->Id_PrVRAttivita ?></td>
                                <td class="no-sort"><?php echo $v->Cd_PrRisorsa ?></td>
                                <td class="no-sort"><?php echo $v->Cd_Operatore ?></td>
                                <td class="no-sort"><?php echo $v->Quantita ?></td>
                                <td class="no-sort"><?php echo $v->Quantita_Scar ?></td>
                                <td class="no-sort"><?php echo $v->Attrezzaggio ?></td>
                                <td class="no-sort"><?php echo $v->Esecuzione ?></td>
                                <td class="no-sort"><?php echo $v->Fermo ?></td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</form>

<script type="text/javascript">

    $('#lista_versamenti').dataTable({

        language: {
            url: '/backend/plugins/datatables/Italian.json'
        }

    });


</script>

