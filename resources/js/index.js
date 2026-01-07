/* Navbar scroll effect */
document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("navbar");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 10) {
            navbar.classList.add("navbar-scrolled");
        } else {
            navbar.classList.remove("navbar-scrolled");
        }
    });
});
