            <footer class="main-footer" data-base-url="<?= base_url(); ?>">
                <div class="pull-right hidden-xs">
                    <b>Université de Yaoundé 1</b> Informatique
                </div>
                <strong>Copyright &copy; 2018-2019
                    <a href="<?= base_url(); ?>">UY1</a>
                </strong> Projet430: Gestion des ressources
            </footer>


            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
            <script src="<?= base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
            <script src="<?= base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
            <script src="<?= base_url(); ?>assets/js/validation.js" type="text/javascript"></script>

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
        </div>
    </body>
</html>