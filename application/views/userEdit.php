<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Paramètres du compte
            <small>Modifier vos informations</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez vos informations</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="updateUser" action="<?php echo base_url() ?>updateUser" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Nom</label>
                                        <input type="text" class="form-control required" value="<?php echo $name; ?>" id="fname" name="fname" maxlength="128">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control required email" id="email" value="<?php echo $email; ?>" name="email"
                                            maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="oldpassword">Ancien mot de passe</label>
                                        <input type="password" class="form-control required" placeholder="Ancien mot de passe" id="oldpassword" name="oldpassword" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Nouveau mot de passe</label>
                                        <input type="password" class="form-control required equalTo" placeholder="Nouveau mot de passe" id="cpassword" name="cpassword" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword2">Vérifier le nouveau mot de passe</label>
                                        <input type="password" class="form-control required equalTo" placeholder="Vérifier le nouveau mot de passe" id="cpassword2" name="cpassword2" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Numéro de téléphone</label>
                                        <input type="text" class="form-control required digits" id="mobile" value="<?php echo $mobile; ?>" name="mobile"
                                            maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Valider" />
                            <input type="reset" class="btn btn-default" value="Annuler" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php } ?>
                    <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php } ?>

                    <?php  
                    $noMatch = $this->session->flashdata('nomatch');
                    if($noMatch)
                    {
                ?>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('nomatch'); ?>
                    </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</div>