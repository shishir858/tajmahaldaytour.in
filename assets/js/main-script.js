// Tour Packages Load More/Less
$(document).ready(function() {
    var shown = 12;
    var increment = 4;
    var total = $(".package-card-item").length;
    $("#loadMoreBtn").click(function() {
        var next = shown + increment;
        $(".package-card-item").slice(shown, next).fadeIn(300).css('display','block');
        shown = next;
        if (shown >= total) {
            $(this).hide();
        }
        $("#showLessBtn").show();
    });
    $("#showLessBtn").click(function() {
        shown = 12;
        $(".package-card-item").slice(shown).fadeOut(200, function(){ $(this).css('display','none'); });
        $("#loadMoreBtn").show();
        $(this).hide();
        $(window).scrollTop($("#packageCardsRow").offset().top - 80);
    });
});
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
