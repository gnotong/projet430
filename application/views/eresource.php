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
                                <th>Libellé</th>
                                <th>Marque</th>
                                <th>Description</th>
                                <th>Catégorie</th>
                                <th>Utilisateur ayant créé</th>
                                <th>Rôle utilisateur ayant créé</th>
                                <th>Date création</th>
                                <th>Action</th>
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
                                                <?php echo $record->label ?>
                                            </td>
                                            <td>
                                                <?php echo $record->brand ?>
                                            </td>
                                            <td>
                                                <?php echo $record->description ?>
                                            </td>
                                            <td>
                                                <?php echo $record->categoryId ?>
                                            </td>
                                            <td>
                                                <?php echo $record->createdBy ?>
                                            </td>
                                            <td>
                                                <?php echo $record->role ?>
                                            </td>
                                            <td>
                                                <?php echo $record->created ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-primary"
                                                   href="<?= base_url() . 'endResource/' . $record->id; ?>"
                                                   title="Görevi Bitir">
                                                    <i class="fa fa-check-circle"></i>
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