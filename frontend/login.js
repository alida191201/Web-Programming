document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (event) => {
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();

        // Regex semplice per email valida
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            alert("Inserisci un'email valida.");
            event.preventDefault();
            return;
        }

        // Password non vuota
        if (password === "") {
            alert("Inserisci la password.");
            event.preventDefault();
            return;
        }
    });
});
