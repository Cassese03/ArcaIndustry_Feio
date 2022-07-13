<?php $utente = session('utente'); ?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!--
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" style="color:red;font-weight:bold;">Note Da Condividere con tutti gli operatori</a>
        </li>-->

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    </ul>
</nav>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">

        <img src="<?php echo URL::asset('img/logo.png') ?>" alt="AdminLTE Logo" class="brand-image elevation-3" style="width:100%;margin-top:10px;">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">

                <a class="d-block" style="text-align: left">Benvenuto <?php echo $utente->Cd_Operatore ?></a>
                <?php if($utente->Cd_Operatore2 != ''){ ?>
                    <a class="d-block" style="text-align: left">Assistente <?php echo $utente->Cd_Operatore2 ?></a>
                <?php } ?>
                <a class="d-block" style="text-align: left">Reparto <?php echo $utente->Cd_PRRiparto ?></a>
                <a class="d-block" style="text-align: left">Risorsa <?php echo $utente->Cd_PRRisorsa ?></a>
                <a class="d-block" style="text-align: left">Ditta <?php echo env('DB_DATABASE', 'forge') ?></a>

            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->


                <li class="nav-item">
                    <a href="<?php echo URL::asset('') ?>" class="nav-link">
                        <i class="nav-icon fa fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!--

                <li class="nav-item">
                    <a href="<?php echo URL::asset('statistiche') ?>" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Statistiche</p>
                    </a>
                </li>

                -->


                <li class="nav-item">
                    <a href="<?php echo URL::asset('operatori') ?>" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Operatori</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo URL::asset('gruppi_risorse') ?>" class="nav-link">
                        <i class="nav-icon fas fa-network-wired"></i>
                        <p>Risorse</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas  fa-cubes"></i>
                        <p>
                            Imballaggio
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo URL::asset('imballaggio') ?>" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>Gestione Pedane</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo URL::asset('imballaggio_bolle_da_chiudere') ?>" class="nav-link">
                                <i class="nav-icon fas fa-cubes"></i>
                                <p>Gestione Bolle</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item">
                    <a href="<?php echo URL::asset('lista_attivita') ?>" class="nav-link">
                        <i class="nav-icon fab fa-buffer"></i>
                        <p>Attività</p>
                    </a>
                </li>
                <!--
                <li class="nav-item">
                    <a href="<?php echo URL::asset('tracciabilita') ?>" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Tracciabilità</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="<?php echo URL::asset('odl') ?>" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Ordini di Lavorazione</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="<?php echo URL::asset('carico_merce') ?>" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Carico Merce</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo URL::asset('trasferimento_merce') ?>" class="nav-link">
                        <i class="nav-icon fas fa-arrows-alt"></i>
                        <p>Trasf. Merce</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo URL::asset('calendario') ?>" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Calendario</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo URL::asset('logistic_offline') ?>" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Mockup Logistic Offline</p>
                    </a>
                </li>
-->
                <li class="nav-item">
                    <a href="<?php echo URL::asset('logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
