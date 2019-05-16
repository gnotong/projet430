<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des utilisateurs
            <small>Ajouter, modifier, supprimer</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>add_user">
                        <i class="fa fa-plus"></i> Ajouter un utilisateur</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Liste d'utilisateurs</h3>
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
                                    <th>Email</th>
                                    <th>Numéro de téléphone</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <?php echo $user->name ?>
                                            </td>
                                            <td>
                                                <?php echo $user->email ?>
                                            </td>
                                            <td>
                                                <?php echo $user->mobile ?>
                                            </td>
                                            <td>
                                                <?php echo $user->role ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info"
                                                   href="<?php echo base_url() . 'edit_user/' . $user->userId; ?>"
                                                   title="Modifier">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger deleteUser" href="#"
                                                   data-userid="<?php echo $user->userId; ?>" title="Supprimer">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>