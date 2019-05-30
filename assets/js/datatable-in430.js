$(document).ready(function () {
    let $baseUrl = $(".main-footer").data('base-url');

    $('#dataTables-example').DataTable({
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
});