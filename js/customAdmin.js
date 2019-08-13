$(document).ready(function () {
    if ($('#bertutur').is(':checked')) {
        $('#catber').hide()
    }
    $('#bertutur').click(function () {
        $('#catber').hide()
    });
    $('#berita').click(function () {
        $('#catber').show()
    });
});
