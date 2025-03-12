import './bootstrap';

if (window.location.pathname === '/auth') {
    var positionLeft = $('#imgAuth').position().left;
    var parentWidth = $('#imgAuth').parent().width();
    var positionLeftPercentage = (positionLeft / parentWidth) * 100;

    if (parentWidth <1024) {
        if (positionLeftPercentage >= 49 && positionLeftPercentage <= 50) {
            window.location.href = '/auth/login';
        } else if (positionLeftPercentage >= 0 && positionLeftPercentage <= 1) {
            window.location.href = '/auth/register';
        }
    }
}
$(document).ready(function () {
});

$('#imgAuth').css('right', '0px');
$('#registerBtn').click(function () {
    $('#imgAuth').animate({
        left: '0px'
    }, 250, 'linear');
});
$('#loginBtn').click(function () {
    $('#imgAuth').animate({
        left: '50%'
    }, 250, 'linear');
});