<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>
            Toutes les Ressources
        </h1>
    </section>
    <section class="content">
        <div class="col-xs-12">
            <div class="text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>add_resource">
                    <i class="fa fa-plus"></i> Ajouter une ressource
                </a>
            </div>
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
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

                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover"
                               id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th>Créateur</th>
                                    <th>Rôle créateur</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($resourcesRecords)): ?>
                                    <?php foreach ($resourcesRecords as $record): ?>
                                        <tr>
                                            <td>
                                                <?php echo $record->id ?>
                                            </td>
                                            <td>
                                                <?php echo $record->name ?>
                                            </td>
                                            <td>
                                                <?php echo $record->description ?>
                                            </td>
                                            <td>
                                                <?php echo $record->category ?>
                                            </td>
                                            <td>
                                                <?php echo $record->creator ?>
                                            </td>
                                            <td>
                                                <?php echo $record->creatorRole ?>
                                            </td>
                                            <td>
                                                <?php echo $record->created ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="<?php echo base_url() . 'edit_resource/' . $record->id; ?>"
                                                   title="Editer">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger fire-delete-alert"
                                                   href="<?php echo base_url() . 'deleteResource/' . $record->id; ?>"
                                                   data-alert-title="Êtes-vous certains de vouloir supprimer cette ressource ?"
                                                   data-alert-text="Cette action est irréversible!"
                                                   title="Supprimer">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/datatable-in430.js"></script>