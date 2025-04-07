import './bootstrap';
import 'laravel-datatables-vite';
import Swal from 'sweetalert2';

window.Swal = Swal;

if (window.location.pathname === "/auth") {
  var positionLeft = $("#imgAuth").position().left;
  var parentWidth = $("#imgAuth").parent().width();
  var positionLeftPercentage = (positionLeft / parentWidth) * 100;

  if (parentWidth < 1024) {
    if (positionLeftPercentage >= 49 && positionLeftPercentage <= 50) {
      window.location.href = "/auth/login";
    } else if (positionLeftPercentage >= 0 && positionLeftPercentage <= 1) {
      window.location.href = "/auth/register";
    }
  }
}
$(document).ready(function () {});

$("#imgAuth").css("right", "0px");
$("#registerBtn").click(function () {
  $("#imgAuth").animate(
    {
      left: "0px",
    },
    250,
    "linear"
  );
});
$("#loginBtn").click(function () {
  $("#imgAuth").animate(
    {
      left: "50%",
    },
    250,
    "linear"
  );
});

$(document).ready(function () {
  // Tambah Jenis
  function showModalWithAnimation(modal) {
    modal
      .css({
        display: "flex",
        opacity: 0,
      })
      .animate(
        {
          opacity: 0.8,
        },
        300
      );
  }

  function hideModalWithAnimation(modal) {
    modal.animate(
      {
        opacity: 0,
      },
      300,
      function () {
        modal.css("display", "none");
      }
    );
  }

  $("#tambahJenisBtn").click(function () {
    showModalWithAnimation($("#modalTambahJenis"));
  });

  $(".close-modal").click(function () {
    hideModalWithAnimation($("#modalTambahJenis"));
  });

  $(window).click(function (event) {
    if ($(event.target).is("#modalTambahJenis")) {
      hideModalWithAnimation($("#modalTambahJenis"));
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Jenis
  const editJenisSection = document.querySelectorAll(".editJenisSection");
  const editJenisBtn = document.querySelectorAll(".editJenisBtn");
  const editJenisInput = document.querySelectorAll(".editJenisInput");
  const editJenisSubmitBtn = document.querySelectorAll(".editJenisSubmitBtn");

  editJenisBtn.forEach((btn, index) => {
    btn.addEventListener("click", function () {
      editJenisSection[index].classList.add("hidden");
      editJenisInput[index].classList.remove("hidden");
    });
  });

  editJenisSubmitBtn.forEach((btn, index) => {
    btn.addEventListener("click", function () {
      editJenisSection[index].classList.remove("hidden");
      editJenisInput[index].classList.add("hidden");
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const tambahBtn = document.getElementById("tambahInstansiBtn");
  const closeTambahModalBtn = document.getElementById("closeTambahModalBtn");
  const modalTambah = document.getElementById("modalTambahPermission");
  const editButtons = document.querySelectorAll(".editInstansiBtn");
  const closeEditModalBtn = document.getElementById("closeEditModalBtn");
  const modalEdit = document.getElementById("modalEditPermission");
  const editIdPermission = document.getElementById("editIdPermission");
  const editNama = document.getElementById("editNama");
  const editAlamat = document.getElementById("editAlamat");
  const editDeskripsi = document.getElementById("editDeskripsi");
  const editProfile = document.getElementById("editProfile");
  const editBackground = document.getElementById("editBackground");

  // Open Tambah Modal
  tambahBtn.addEventListener("click", () => {
    modalTambah.classList.remove("hidden");
  });

  // Close Tambah Modal
  closeTambahModalBtn.addEventListener("click", () => {
    modalTambah.classList.add("hidden");
  });

  // Open Edit Modal and Populate Data
  editButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const id = button.getAttribute("data-id");
      const nama = button.getAttribute("data-nama");
      const alamat = button.getAttribute("data-alamat");
      const deskripsi = button.getAttribute("data-deskripsi");
      const profile = button.getAttribute("data-profile");
      const background = button.getAttribute("data-background");

      editIdPermission.value = id;
      editNama.value = nama;
      editAlamat.value = alamat;
      editDeskripsi.value = deskripsi;
      editProfile.value = "";
      editBackground.value = "";

      modalEdit.classList.remove("hidden");
    });
  });

  // Close Edit Modal
  closeEditModalBtn.addEventListener("click", () => {
    modalEdit.classList.add("hidden");
  });

  // Close modals when clicking outside the form
  [modalTambah, modalEdit].forEach((modal) => {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    });
  });
});
