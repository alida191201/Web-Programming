document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm");
    const messageDiv = document.getElementById("responseMessage");

    if (form) {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            let formData = new FormData(form);

            try {
                let response = await fetch("/contacts", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
                    },
                    body: formData
                });

                let result = await response.json();

                messageDiv.innerHTML = result.success
                    ? `<p style="color: lightgreen;">✅ ${result.message}</p>`
                    : `<p style="color: red;">❌ ${result.message}</p>`;
            } catch (error) {
                messageDiv.innerHTML = `<p style="color: red;">⚠️ Errore di rete, riprova più tardi.</p>`;
            }
        });
    }
});
