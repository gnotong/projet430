<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/dist/css/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .error {
            color: red;
            font-weight: normal;
        }
    </style>
    <script type="text/javascript">
        var baseURL = "<?= base_url(); ?>";
    </script>
    <script src="<?= base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?= base_url(); ?>assets/dist/js/html5shiv.min.js"></script>
    <script src="<?= base_url(); ?>assets/dist/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="<?= base_url(); ?>" class="logo">
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
                <ul class="nav navbar-nav">
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-history"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"> Dernière connexion :
                                <i class="fa fa-clock-o"></i>
                                <?= empty($last_login) ? "İlk Giriş" : $last_login; ?>
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
            </div>
        </nav>
    </header>

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
                <?php if ($role == ROLE_ADMIN || $role == ROLE_MANAGER): ?>
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

                <?php if ($role == ROLE_ADMIN): ?>
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
                <?php endif; ?>

                <?php if ($role == ROLE_EMPLOYEE): ?>
                    <li class="treeview">
                        <a href="<?= base_url(); ?>eresource">
                            <i class="fa fa-tasks"></i>
                            <span>Ressources</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
    </aside>