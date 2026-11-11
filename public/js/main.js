document.addEventListener("DOMContentLoaded", () => {
    const menu = document.querySelector(".mobile-menu");
    const nav = document.querySelector(".desktop-nav");

    if (menu && nav) {
        menu.addEventListener("click", () => nav.classList.toggle("open"));
    }

    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", () => {
            const button = form.querySelector("button[type='submit']");
            if (button && button.dataset.loading !== "false") {
                button.classList.add("loading");
            }
        });
    });
});
