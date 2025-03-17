document.addEventListener("DOMContentLoaded", function () {
    const booksDropdownBtn = document.getElementById("booksDropdownBtn");
    const booksDropdownMenu = document.getElementById("booksDropdownMenu");
    const booksDropdownIcon = document.getElementById("booksDropdownIcon");

    booksDropdownBtn.addEventListener("click", function () {
        if (booksDropdownMenu.classList.contains("hidden")) {
            booksDropdownMenu.classList.remove("hidden");
            booksDropdownMenu.style.maxHeight = "0px";
            booksDropdownMenu.style.opacity = "0";
            requestAnimationFrame(() => {
                booksDropdownMenu.style.transition = "max-height 0.3s ease-out, opacity 0.3s ease-out";
                booksDropdownMenu.style.maxHeight = "200px";
                booksDropdownMenu.style.opacity = "1";
            });
        } else {
            booksDropdownMenu.style.transition = "max-height 0.2s ease-in, opacity 0.2s ease-in";
            booksDropdownMenu.style.maxHeight = "0px";
            booksDropdownMenu.style.opacity = "0";
            setTimeout(() => {
                booksDropdownMenu.classList.add("hidden");
            }, 200);
        }
        booksDropdownIcon.classList.toggle("rotate-180");
    });

    document.addEventListener("click", function (event) {
        if (!booksDropdownBtn.contains(event.target) && !booksDropdownMenu.contains(event.target)) {
            booksDropdownMenu.style.transition = "max-height 0.2s ease-in, opacity 0.2s ease-in";
            booksDropdownMenu.style.maxHeight = "0px";
            booksDropdownMenu.style.opacity = "0";
            setTimeout(() => {
                booksDropdownMenu.classList.add("hidden");
            }, 200);
            booksDropdownIcon.classList.remove("rotate-180");
        }
    });
});
