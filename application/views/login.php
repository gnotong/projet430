
<?php
    $error = $this->session->flashdata('error');
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#" class="text-aqua">
            <b>PROJET 430</b>
        </a> <br>
        <h3 class="text-primary text-bold">Université de Yaoundé 1</h3>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Gession des ressources</p>
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?= $error; ?>
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