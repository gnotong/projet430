<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des Ressources
            <small>Ajouter / Modifier une Ressource</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations de la tâche</h3>
                    </div>
                    <form role="form" id="editResource" action="<?php echo base_url() ?>edit_resource/<?= $resource->id; ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="label">Libellé</label>
                                        <input type="hidden" name="resourceId" id="resourceId" value="<?= $resource->id; ?>">
                                        <input type="text"
                                               class="form-control required"
                                               value="<?= $resource->label; ?>"
                                               id="label" name="label">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Catégorie</label>
                                        <select class="form-control required" id="category" name="category">
                                            <option value="0">Choisissez la catégorie</option>
                                            <?php if (!empty($resourcesCategories)): ?>
                                                <?php foreach ($resourcesCategories as $rl): ?>
                                                    <option value="<?= $rl->id ?>"
                                                        <?php if($rl->id == $resource->categoryId) {echo "selected=selected";} ?>
                                                    >
                                                        <?= $rl->label ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"
                                        ><?= $resource->description; ?></textarea>
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