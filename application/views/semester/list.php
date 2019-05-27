<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>
            Tous les niveaux d'études
        </h1>
    </section>
    <section class="content">
        <div class="col-xs-12">
            <div class="text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>add_semester">
                    <i class="fa fa-plus"></i> Nouveau semestre
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
                                    <th>Id</th>
                                    <th>Nom</th>
                                    <th>Année</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($semesters)): ?>
                                    <?php foreach ($semesters as $semester): ?>
                                        <tr>
                                            <td>
                                                <?php echo $semester->id ?>
                                            </td>
                                            <td>
                                                <?php echo $semester->name ?>
                                            </td>
                                            <td>
                                                <?php echo substr($semester->name, 0, 4) ?>
                                            </td>
                                            <td>
                                                <?php echo date_format(date_create($semester->start), 'd/m/Y') ?>
                                            </td>
                                            <td>
                                                <?php echo date_format(date_create($semester->end), 'd/m/Y') ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="<?php echo base_url() . 'edit_semester/' . $semester->id; ?>"
                                                   title="Editer">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger fire-delete-alert"
                                                   href="<?php echo base_url() . 'delete_semester/' . $semester->id; ?>"
                                                   data-alert-title="Êtes-vous certains de vouloir supprimer ce semestre ?"
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