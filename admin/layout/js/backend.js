$(function () {
    let passField = $('.password')
    $(".show-pass").hover(
        function () {
            passField.attr("type", "text");

        }, function () {
            passField.attr("type", "password");
        }
    );




});
