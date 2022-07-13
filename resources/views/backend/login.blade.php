<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arca Industry | <?php echo ((isset($_GET['risorsa'])))?$_GET['risorsa']:''  ?></title>
    <link rel="icon" href="<?php echo URL::asset('img/ico.png') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?php echo URL::asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo URL::asset('backend/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?php echo URL::asset('img/logo.png') ?>" style="width:100%">
        </div>
        <div class="card-body">
            <p class="login-box-msg">
                <?php  if(isset($_GET['reparto'])){ ?>
                    <b><?php echo $_GET['reparto']; ?></b><br>
                <?php } ?>
                Effettua il Login
            </p>

            <form method="post">
                <div class="input-group mb-3">

                    <label style="width:100%">Reparto</label>
                    <select id="reparto" name="Reparto" class="form-control" onchange="top.location.href='/login?reparto='+$(this).val()" <?php echo ((isset($_GET['reparto'])))?'disabled':''  ?> ?>
                            <option value="">Seleziona un Reparto</option>
                        <?php foreach($reparti as $rep){ ?>
                            <option value="<?php echo trim($rep->Cd_PRReparto) ?>" <?php echo ((isset($_GET['reparto'])) && trim($rep->Cd_PRReparto) == $_GET['reparto'])?'selected':''  ?>><?php echo trim($rep->Cd_PRReparto) ?></option>
                        <?php } ?>
                    </select>

                    <?php  if(isset($_GET['reparto'])){ ?>

                        <label style="width:100%">Risorsa</label><br>
                        <select name="risorsa" class="form-control" onchange="top.location.href='/login?reparto='+$('#reparto').val()+'&risorsa='+$(this).val()">
                            <option value="">Seleziona una Risorsa</option>
                            <?php foreach($risorse as $ris){ ?>
                                <option value="<?php echo $ris->Cd_PrRisorsa ?>" <?php echo ((isset($_GET['risorsa'])) && trim($ris->Cd_PrRisorsa) == $_GET['risorsa'])?'selected':''  ?>><?php echo $ris->Cd_PrRisorsa ?></option>
                            <?php } ?>
                        </select>

                        <label style="width:100%">Operatore</label><br>
                        <select name="Id_Operatore" class="form-control">
                            <?php foreach($operatori as $o){ ?>
                            <option value="<?php echo $o->Id_Operatore ?>"><?php echo $o->Cd_Operatore ?></option>
                            <?php } ?>
                        </select>

                        <?php if(isset($_GET['reparto']) && ($_GET['reparto'] == 'ESTRUSORI' || $_GET['reparto'] == 'ESTRUSIONE')){ ?>

                            <label style="width:100%">Assistente</label><br>
                            <select name="Id_Operatore2" class="form-control" style="width:100%">
                                <option value="0">Nessun Operatore</option>
                                <?php foreach($operatori as $o){ ?>
                                 <option value="<?php echo $o->Id_Operatore ?>"><?php echo $o->Cd_Operatore ?></option>
                                <?php } ?>
                            </select>
                            <small>Opzionale</small>

                        <?php } else { ?>
                            <input type="hidden" name="Id_Operatore2" value="0">
                        <?php } ?>

                    <?php } ?>

                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <?php  if(isset($_GET['risorsa'])){ ?>
                            <button type="submit" name="login" value="Login" class="btn btn-danger btn-block">Login</button>
                        <?php } ?>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row" style="padding-left:10px;">
                    <?php echo 'Ditta: '.env('DB_DATABASE', 'forge') ?>
                </div>
            </form>

            <!-- /.social-auth-links -->

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<script src="<?php echo URL::asset('backend/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo URL::asset('backend/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>


<style>
    .card-primary.card-outline {
        border: none;
    }
</style>

