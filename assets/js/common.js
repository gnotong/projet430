$(document).ready(function(){

    $(document).on("click", ".fire-delete-alert", function(e){
        e.preventDefault();

        let $element = $(this);
        let $title = $element.data('alert-title');
        let $text = $element.data('alert-text');

        fireAlert($element, $title, $text);
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
