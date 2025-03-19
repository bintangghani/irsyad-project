document.addEventListener("DOMContentLoaded", function () {
    function toggleDropdown(buttonId, menuId) {
        const button = document.getElementById(buttonId);
        const menu = document.getElementById(menuId);

        button.addEventListener("click", function (event) {
            event.stopPropagation();
            const isHidden = menu.classList.contains("hidden");
            document.querySelectorAll(".dropdown-menu").forEach(m => {
                m.classList.add("hidden", "opacity-0", "scale-95");
            });
            if (isHidden) {
                menu.classList.remove("hidden", "opacity-0", "scale-95");
            } else {
                menu.classList.add("hidden", "opacity-0", "scale-95");
            }
        });
    }

    toggleDropdown("dropdown-user-btn", "dropdown-user-menu");
    toggleDropdown("dropdown-book-btn", "dropdown-book-menu");

    document.addEventListener("click", function () {
        document.querySelectorAll(".dropdown-menu").forEach(m => {
            m.classList.add("hidden", "opacity-0", "scale-95");
        });
    });
});