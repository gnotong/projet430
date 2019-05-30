<?php
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Gestion des affectations
            <small>Ajouter, modifier, supprimer</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-danger"
                       id="delete-allocation"
                       href="<?php echo base_url() . 'delete_allocation' ?>">
                        <i class="fa fa-minus-circle"></i> Supprimer</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Liste des affectations</h3>
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
                                    <th>Niveau</th>
                                    <th>Enseignant</th>
                                    <th>Semestre</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Ressource</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($allocations)): ?>
                                    <?php foreach ($allocations as $allocation): ?>
                                        <tr>
                                            <td>
                                                <?php echo $allocation->lessonName ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->levelName ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->teacherName ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->semesterName ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->start ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->end ?>
                                            </td>
                                            <td>
                                                <?php echo $allocation->name ?>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-danger fire-delete-alert"
                                                   href="<?php echo base_url() . 'delete_allocation/' . $allocation->eventId; ?>"
                                                   data-alert-title="Êtes-vous certains de vouloir supprimer cet utilisateur ?"
                                                   data-alert-text="Cette action est irréversible!"
                                                   title="Supprimer">
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
<script>
    $(document).ready(function(){

        let $baseUrl = $(".main-footer").data('base-url');

        let $table = $('#dataTables-example').DataTable({
            stateSave: true,
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-9'i><'col-sm-3'B>>" +
                "<'row'<'col-sm-7 col-centered'p>>",
            lengthMenu: [
                [10, 15, 25, 50, -1],
                [10, 15, 25, 50, "Tout"]
            ],

            language: {
                select: {
                    rows: "%d ligne sélectionnée."
                },

                url: $baseUrl + "application/Resources/Translations/French.json"
            },
            buttons: [{
                extend: "print",
                text: "Imprimer",
                exportOptions: {
                    orthogonal: 'export',
                    columns: ':visible'
                },
            },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: "Excel",
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: "PDF",
                }
            ],
            "order": [],
            responsive: true
        });

        $('#dataTables-example tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        } );

        $(document).on("click", "#delete-allocation", function(e){
            e.preventDefault();


            alert( $table.rows('.selected').data().length +' row(s) selected' );

            // let $element = $(this);
            // let $title = $element.data('alert-title');
            // let $text = $element.data('alert-text');
            //
            // fireAlert($element, $title, $text);
        });
    });



    function fireAlert($element, $title, $text) {
        Swal.fire({
            title: $title,
            text: $text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d60c10',
            cancelButtonColor: '#879fb5',
            confirmButtonText: 'Supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.value) {
                window.location = $element.attr("href")
            }
        });
    }

</script>