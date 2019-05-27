<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?= base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/dist/css/datatables.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- datetime picker-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/fullcalendar/datetimepicker/jquery.datetimepicker.min.css"/>
    <!-- Dialog Event calendar -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <style>
        .error {
            color: red;
            font-weight: normal;
        }
        .hiddenField {
            display: none;
        }
    </style>
    <script type="text/javascript">
        var baseURL = "<?= base_url(); ?>";
    </script>
    <script src="<?= base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url(); ?>assets/fullcalendar/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url(); ?>assets/fullcalendar/jquery-ui/jquery-ui.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?= base_url(); ?>assets/fullcalendar/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url(); ?>assets/fullcalendar//fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>assets/fullcalendar/dist/adminlte.min.js"></script>
    <!-- fullCalendar -->
    <script src="<?= base_url(); ?>assets/fullcalendar/moment/moment.js"></script>
    <script src="<?= base_url(); ?>assets/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?= base_url(); ?>assets/fullcalendar/dist/locale/fr.js"></script>
    <!-- datetime picker-->
    <script type="text/javascript" src="<?= base_url(); ?>assets/fullcalendar/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <!-- Dialog Event calendar -->
    <script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url(); ?>assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <!--[if lt IE 9]>
    <script src="<?= base_url(); ?>assets/dist/js/html5shiv.min.js"></script>
    <script src="<?= base_url(); ?>assets/dist/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="<?= base_url(); ?>home" class="logo">
            <span class="logo-mini">
              <b>UY</b>1</span>
            <span class="logo-lg">
              <b>UY1</b>PROJET430
            </span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">

                <?php if ($isLoggedIn): ?>
                    <ul class="nav navbar-nav">
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-history"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"> Dernière connexion :
                                    <i class="fa fa-clock-o"></i>
                                    <?= empty($last_login) ? "Première connexion" : $last_login; ?>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user text-yellow"></i>
                                <span class="hidden-xs">
                          <?= $name; ?>
                        </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <i class="fa fa-user fa-4x text-yellow"></i>
                                    <p>
                                        <?= $name; ?>
                                        <small>
                                            <?= $role_text; ?>
                                        </small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= base_url(); ?>user_edit_profile" class="btn btn-default btn-flat">
                                            <i class="fa fa-key"></i> Paramètres</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= base_url(); ?>logout" class="btn btn-danger btn-flat">
                                            <i class="fa fa-sign-out"></i> Déconnexion</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>

            </div>
        </nav>
    </header>

    <?php if ($isLoggedIn): ?>
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header"></li>
                <li class="treeview">
                    <a href="<?= base_url(); ?>dashboard">
                        <i class="fa fa-dashboard"></i>
                        <span>Accueil</span>
                    </a>
                </li>

                <?php if ($role == ROLE_ADMIN): ?>
                    <li class="treeview">
                        <a href="#" class="text-bold text-yellow">
                            <i class="fa fa-warning"></i>Gestion des utilisateurs
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>user_list">
                            <i class="fa fa-users"></i>
                            <span>Les utilisateurs</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>add_user">
                            <i class="fa fa-plus-circle"></i>
                            <span>Ajouter un utilisateur</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#" class="text-bold text-yellow">
                            <i class="fa fa-warning"></i>Gestion des ressources
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>resources">
                            <i class="fa fa-tasks"></i>
                            <span>Ressources</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>add_resource">
                            <i class="fa fa-plus-circle"></i>
                            <span>Ajouter une ressource</span>
                        </a>
                    </li>

                <?php endif; ?>

                <?php if ($role == ROLE_ADMIN || $role == ROLE_TEACHER): ?>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>resource_allocation">
                            <i class="fa fa-arrow-right"></i>
                            <span>Affectation de ressources</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#" class="text-bold text-yellow">
                            <i class="fa fa-warning"></i>Gestion des cours
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>lessons">
                            <i class="fa fa-list"></i>
                            <span>Liste de cours</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role == ROLE_ADMIN): ?>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>semesters">
                            <i class="fa fa-list"></i>
                            <span>Liste des semestres</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>levels">
                            <i class="fa fa-list"></i>
                            <span>Les niveaux d'études</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#" class="text-bold text-yellow">
                            <i class="fa fa-warning"></i>FAKE DATA
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>fake_users">
                            <i class="fa fa-arrow-circle-o-up"></i>
                            <span>Fake users</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>fake_categories">
                            <i class="fa fa-area-chart"></i>
                            <span>Fake resources categories</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>fake_resources">
                            <i class="fa fa-arrow-circle-o-down"></i>
                            <span>Fake resources</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
    </aside>
<?php endif; ?>