            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Université de Yaoundé 1</b> Informatique
                </div>
                <strong>Copyright &copy; 2018-2019
                    <a href="<?php echo base_url(); ?>">UY1</a>
                </strong> Projet430: Gestion des ressources
            </footer>

            <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
            <script type="text/javascript">
                var windowURL = window.location.href;
                pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
                var x = $('a[href="' + pageURL + '"]');
                x.addClass('active');
                x.parent().addClass('active');
                var y = $('a[href="' + windowURL + '"]');
                y.addClass('active');
                y.parent().addClass('active');
            </script>
            <script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/pdfmake.min.js"></script>
            <script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/vfs_fonts.js"></script>
            <script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/datatables.min.js"></script>

            <script>
                $(document).ready(function () {
                    $('#dataTables-example').DataTable({
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

                            url: "<?= base_url(); ?>application/Resources/Translations/French.json"
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
                });
            </script>
        </div>
    </body>
</html>