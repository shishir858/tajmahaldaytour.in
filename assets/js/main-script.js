// Main JS for tajmahaldaytour frontend
$(document).ready(function() {
    // Back to Top
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('#backToTop').addClass('show');
        } else {
            $('#backToTop').removeClass('show');
        }
    });
    $('#backToTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });
});
