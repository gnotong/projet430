<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>
            Tous les cours
        </h1>
    </section>
    <section class="content">
        <div class="col-xs-12">
            <div class="text-right">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>add_lesson">
                    <i class="fa fa-plus"></i> Ajouter un cours
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
                                    <th>Nom</th>
                                    <th>Code</th>
                                    <th>Niveau</th>
                                    <th>Enseignant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($lessons)): ?>
                                    <?php foreach ($lessons as $lesson): ?>
                                        <tr>
                                            <td>
                                                <?php echo $lesson->label ?>
                                            </td>
                                            <td>
                                                <?php echo $lesson->code ?>
                                            </td>
                                            <td>
                                                <?php echo $lesson->levelName ?>
                                            </td>
                                            <td><?php echo $lesson->teacher ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="<?php echo base_url() . 'edit_lesson/' . $lesson->id; ?>"
                                                   title="Editer">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger deleteLesson"
                                                   href="<?php echo base_url() . 'delete_lesson/' . $lesson->id; ?>"
                                                   data-lessonid="<?php echo $lesson->id; ?>"
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