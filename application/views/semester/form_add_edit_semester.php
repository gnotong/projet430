<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
$issetSemester = isset($semester);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des Ressources
            <small>Ajouter / Modifier un semestre</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations du semestre</h3>
                    </div>

                    <form role="form" id="addNewLevel"
                          action="<?= base_url() ?><?= !$issetSemester ? 'add_semester' : 'edit_semester/' . $semester->id ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nom</label>
                                        <input type="text" class="form-control required"
                                               value="<?= !$issetSemester ? set_value('name') : $semester->name; ?>" id="name" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Année</label>
                                        <input type="text" class="form-control required"
                                               value="<?= !$issetSemester ? set_value('year') : $semester->year; ?>" id="year" name="year">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start">Date de début</label>
                                    <div class='input-group datetimepicker'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        </span>
                                        <input type="text" class="form-control required"
                                               value="<?= !$issetSemester ? set_value('start') : $semester->start; ?>" id="start" name="start">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="year">Date de fin</label>
                                    <div class='input-group datetimepicker'>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        </span>
                                        <input type="text" class="form-control required"
                                               value="<?= !$issetSemester ? set_value('end') : $semester->end; ?>" id="end" name="end">
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

<script>
    $(function () {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'fr'
        });
    });
</script>