<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des utilisateurs
            <small>Ajouter / Modifier</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations de l'utilisateur</h3>
                    </div>
                    <form role="form" action="<?php echo base_url() ?>edit_user/<?php echo $userInfo->userId; ?>" method="post"
                          id="editUser" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Nom</label>
                                        <input type="text" class="form-control" id="fname" placeholder="Full Name"
                                               name="fname" value="<?php echo $userInfo->name; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $userInfo->userId; ?>" name="userId" id="userId"/>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email"
                                               name="email" value="<?php echo $userInfo->email; ?>"
                                               maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Mot de passe</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password"
                                               name="password" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Vérifier le mot de passe</label>
                                        <input type="password" class="form-control" id="cpassword"
                                               placeholder="Vérifier le mot de passe" name="cpassword" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Numéro de téléphone</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Mobile Number"
                                               name="mobile" value="<?php echo $userInfo->mobile; ?>"
                                               maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rôle</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="0">Sélectionner un rôle</option>
                                            <?php if (!empty($roles)): ?>
                                                <?php foreach ($roles as $rl): ?>
                                                        <option value="<?php echo $rl->roleId; ?>" <?php if ($rl->roleId == $userInfo->roleId) {
                                                            echo "selected=selected";
                                                        } ?>>
                                                            <?php echo $rl->role ?>
                                                        </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Valider"/>
                            <input type="reset" class="btn btn-default" value="Annuler"/>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>