/** Custom JS **/

$(document).ready(function() {

    /** Console Log **/
    console.log('!!!!! Loaded and Ready !!!!!');

    /** Disable # Links **/
    $('a[href*="#"]').click(function(e) {
        e.preventDefault();
    });

    /** Smooth Scroll To Top **/
    $('#scroll').click(function() {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 700);
        return false;
    });

});

/** goBack **/
function goBack() {
    window.history.back();
}
