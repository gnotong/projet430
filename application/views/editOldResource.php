<?php

$id = '';
$label = '';
$description = '';
$categoryId = '';
$brand = '';


if (!empty($resourceInfo)) {
    foreach ($resourceInfo as $uf) {
        $id = $uf->id;
        $label = $uf->label;
        $description = $uf->description;
        $categoryId = $uf->categoryId;
        $brand = $uf->brand;
    }
}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des Ressources
            <small>Ajouter / Modifier une Ressource</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Entrez les informations de la tâche</h3>
                    </div>
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addNewResource" action="<?php echo base_url() ?>editResource" method="post"
                          role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="label">Libellé</label>
                                        <input type="hidden" name="resourceId" id="resourceId" value="<?php echo $id; ?>">
                                        <input type="text"
                                               class="form-control required"
                                               value="<?php echo $label; ?>"
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
                                                    <option value="<?php echo $rl->id ?>"
                                                        <?php if($rl->id == $categoryId) {echo "selected=selected";} ?>
                                                    >
                                                        <?php echo $rl->label ?>
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
                                        <label for="comment">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"
                                        ><?php echo $description; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand">Marque</label>
                                        <input type="text" class="form-control" value="<?php echo $brand; ?>" id="brand" name="brand">
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
                <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if ($error) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
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