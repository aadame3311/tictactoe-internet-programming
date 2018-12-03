$(document).ready(function() {
    $(".username-input").focus();
})
$("form").on('submit', function(e) {
    e.preventDefault();
    var name = $(".username-input").val()
    $.ajax({
        url: "../public/main.php/login/"+name,
        data: {
            'name': name
        },
        method: "POST", 
    }).done(function() {

    })
})