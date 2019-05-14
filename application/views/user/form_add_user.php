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
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?= base_url() ?>add_user" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Nom</label>
                                        <input type="text" class="form-control required" value="<?= set_value('fname'); ?>" id="fname" name="fname" maxlength="128">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control required email" id="email" value="<?= set_value('email'); ?>" name="email"
                                            maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Mot de passe</label>
                                        <input type="password" class="form-control required" id="password" name="password" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Vérifier le mot de passe</label>
                                        <input type="password" class="form-control required equalTo" id="cpassword" name="cpassword" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Numéro de téléphone</label>
                                        <input type="text" class="form-control required digits" id="mobile" value="<?= set_value('mobile'); ?>" name="mobile"
                                            maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rôle</label>
                                        <select class="form-control required" id="role" name="role">
                                            <option value="0">Sélectionner un rôle</option>
                                            <?php if(!empty($roles)): ?>
                                                <?php foreach ($roles as $rl): ?>
                                                    <option value="<?= $rl->roleId ?>" <?php if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>>
                                                        <?= $rl->role ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="serialNumber">Matricule</label>
                                        <input type="text" class="form-control required" id="serialNumber" value="<?= set_value('serial_number'); ?>"
                                               name="serialNumber"
                                               maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" value="Valider" />
                                        <input type="reset" class="btn btn-default" value="Annuler" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>