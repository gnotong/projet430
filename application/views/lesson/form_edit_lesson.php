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
                        <h3 class="box-title">Entrez les informations du cours</h3>
                    </div>
                    <form role="form" id="editLesson" action="<?php echo base_url() ?>edit_lesson/<?= $lesson->id; ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="label">Libellé</label>
                                        <input type="hidden" name="lessonId" id="lessonId" value="<?= $lesson->id; ?>">
                                        <input type="text"
                                               class="form-control required"
                                               value="<?= $lesson->label; ?>"
                                               id="label" name="label">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Code du cours</label>
                                        <input type="text" class="form-control" value="<?= $lesson->code; ?>"
                                               id="code" name="code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="level">Niveaux d'études</label>
                                        <select class="form-control required" id="level" name="level" required>
                                            <option value="">Choisissez le niveau d'études</option>
                                            <?php if (!empty($levels)): ?>
                                                <?php foreach ($levels as $level): ?>
                                                    <option value="<?= $level->id ?>"
                                                        <?php if($level->id == $lesson->levelId) {echo "selected=selected";} ?>
                                                    >
                                                        <?= $level->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="teacher">Enseignant</label>
                                        <select class="form-control required" id="teacher" name="teacher" required>
                                            <option value="">Sélectionnez l'enseignant</option>
                                            <?php if (!empty($teachers)): ?>
                                                <?php foreach ($teachers as $teacher): ?>
                                                    <option value="<?= $teacher->id; ?>"
                                                        <?php if($teacher->id == $lesson->teacherId) {echo "selected=selected";} ?>
                                                    >
                                                        <?= $teacher->name ?>
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
                                        <label for="semester">Semestre</label>
                                        <select class="form-control required" id="semester" name="semester" required>
                                            <option value="">Sélectionnez le semestre</option>
                                            <?php if (!empty($semesters)): ?>
                                                <?php foreach ($semesters as $semester): ?>
                                                    <option value="<?= $semester->id ?>"
                                                        <?php if($semester->id == $lesson->semesterId) {echo "selected=selected";} ?>
                                                    >
                                                        <?= $semester->year . ' - ' . $semester->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
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