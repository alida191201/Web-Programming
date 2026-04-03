document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (event) => {
        let name = document.getElementById("name").value.trim();
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();
        let confirmPassword = document.getElementById("password_confirmation").value.trim();

        // Validazione Nome
        if (name.length < 3) {
            alert("Il nome deve contenere almeno 3 caratteri.");
            event.preventDefault();
            return;
        }

        // Validazione Email
        if (!email.includes("@") || !email.includes(".")) {
            alert("Inserisci un'email valida.");
            event.preventDefault();
            return;
        }

        // Validazione Password
        if (password.length < 8) {
            alert("La password deve contenere almeno 8 caratteri.");
            event.preventDefault();
            return;
        }

        // Conferma Password
        if (password !== confirmPassword) {
            alert("Le password non coincidono.");
            event.preventDefault();
            return;
        }
    });
});
