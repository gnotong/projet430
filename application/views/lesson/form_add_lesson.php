<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des Ressources
            <small>Ajouter / Modifier un cours</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations du cours <span class="text-danger"> (champs enseignant en cours de dev)</span>
                        </h3>
                    </div>

                    <form role="form" id="addNewLesson" action="<?= base_url() ?>add_lesson" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="label">Libellé</label>
                                        <input type="text" class="form-control required"
                                               value="<?= set_value('label'); ?>" id="label" name="label">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Code du cours</label>
                                        <input type="text" class="form-control" value="<?= set_value('code'); ?>"
                                               id="code" name="code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="level">Niveaux d'études</label>
                                        <select class="form-control required" id="level" name="level" required>
                                            <option value="">Choisissez le niveau d'études</option>
                                            <?php if (!empty($levels)): ?>
                                                <?php foreach ($levels as $level): ?>
                                                    <option value="<?= $level->id ?>">
                                                        <?= $level->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value="Valider"/>
                                <input type="reset" class="btn btn-default" value="Annuler"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                        <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>