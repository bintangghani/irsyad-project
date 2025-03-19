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

$(document).ready(function() {
    // Tambah Jenis
    function showModalWithAnimation(modal) {
        modal.css({
            display: 'flex',
            opacity: 0
        }).animate({
            opacity: 0.8
        }, 300);
    }

    function hideModalWithAnimation(modal) {
        modal.animate({
            opacity: 0
        }, 300, function() {
            modal.css('display', 'none');
        });
    }

    $('#tambahJenisBtn').click(function() {
        showModalWithAnimation($('#modalTambahJenis'));
    });

    $('.close-modal').click(function() {
        hideModalWithAnimation($('#modalTambahJenis'));
    });

    $(window).click(function(event) {
        if ($(event.target).is('#modalTambahJenis')) {
            hideModalWithAnimation($('#modalTambahJenis'));
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Jenis
    const editJenisSection = document.querySelectorAll('.editJenisSection');
    const editJenisBtn = document.querySelectorAll('.editJenisBtn');
    const editJenisInput = document.querySelectorAll('.editJenisInput');
    const editJenisSubmitBtn = document.querySelectorAll('.editJenisSubmitBtn');

    editJenisBtn.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            editJenisSection[index].classList.add('hidden');
            editJenisInput[index].classList.remove('hidden');
        });
    });

    editJenisSubmitBtn.forEach((btn, index) => {
        btn.addEventListener('click', function () {
            editJenisSection[index].classList.remove('hidden');
            editJenisInput[index].classList.add('hidden');
        });
    });
});