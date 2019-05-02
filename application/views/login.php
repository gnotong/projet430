<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>UY1 | Panneau d'administration</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?= base_url(); ?>assets/dist/js/html5shiv.min.js"></script>
    <script src="<?= base_url(); ?>assets/dist/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-page">
<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <b>PROJET 430</b>
        </a> <br>
        <h3 class="text-primary text-bold">Université de Yaoundé 1</h3>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Gession des ressources</p>
        <div class="row">
            <div class="col-md-12">
                <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $error; ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $success; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url(); ?>login" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" required/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="mot de passe" name="password" required/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                </div>
                <div class="col-xs-4">
                    <input type="submit" class="btn btn-primary btn-block btn-flat" value="Connexion"/>
                </div>
            </div>
        </form>

        <a href="<?= base_url() ?>forgotPassword">Mot de passe oublié</a>
        <br>

    </div>
</div>


<script src="<?= base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
<script src="<?= base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>