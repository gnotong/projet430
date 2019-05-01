<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>UY1 | Panneau d'administration</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?= base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"
  />
  <link href="<?= base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">
        <b>PROJET 430</b>
      </a> <br>
        <h3 class="text-primary text-bold">Université de Yaoundé 1</h3>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Gession des ressources</p>
      <?php $this->load->helper('form'); ?>
      <div class="row">
        <div class="col-md-12">
          <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
        </div>
      </div>
      <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $error; ?>
        </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
        <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?= $success; ?>
        </div>
        <?php } ?>

        <form action="<?= base_url(); ?>login" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" required />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="mot de passe" name="password" required />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <!-- <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>  -->
            </div>
            <div class="col-xs-4">
              <input type="submit" class="btn btn-primary btn-block btn-flat" value="Connexion" />
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