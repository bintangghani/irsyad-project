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

document.getElementById('tambahPermissionBtn').addEventListener('click', function () {
    const modal = document.getElementById('modalTambahPermission');
    modal.classList.remove('hidden', 'opacity-0');
    modal.classList.add('flex');
});

document.addEventListener('click', function (event) {
    const modal = document.getElementById('modalTambahPermission');
    if (event.target === modal) {
        modal.classList.add('hidden', 'opacity-0');
        modal.classList.remove('flex');
    }
});

const editButtons = document.querySelectorAll('.editPermissionBtn');
editButtons.forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const nama = this.getAttribute('data-nama');

        document.getElementById('editIdPermission').value = id;
        document.getElementById('editNama').value = nama;

        document.getElementById('modalEditPermission').classList.remove('hidden');
    });
});

document.getElementById('closeEditModalBtn').addEventListener('click', function () {
    document.getElementById('modalEditPermission').classList.add('hidden');
});