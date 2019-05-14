<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des Ressources
            <small>Ajouter / Modifier un niveau d'études</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations du niveau d'études</h3>
                    </div>
                    <form role="form" id="editLevel" action="<?php echo base_url() ?>edit_level/<?= $level->id; ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="label">Nom</label>
                                        <input type="hidden" name="levelId" id="levelId" value="<?= $level->id; ?>">
                                        <input type="text"
                                               class="form-control required"
                                               value="<?= $level->name; ?>"
                                               id="name" name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="box-footer">
                                    <input type="submit" class="btn btn-primary" value="Valider"/>
                                    <input type="reset" class="btn btn-default" value="Annuler"/>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <!-- TODO: Factoriser les alertes flash -->
            <div class="col-md-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= $this->session->flashdata('success'); ?>
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