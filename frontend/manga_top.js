document.addEventListener("DOMContentLoaded", () => {
    //  Gestione "Mi piace"
    document.querySelectorAll(".like-btn").forEach(btn => {
        btn.addEventListener("click", async () => {
            const url = btn.dataset.url;
            const countSpan = btn.closest(".anime-card").querySelector(".likes-count");

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                });

                const data = await res.json();
                if (data.likes !== undefined) {
                    countSpan.textContent = data.likes;
                }
            } catch (err) {
                console.error("Errore nel like:", err);
            }
        });
    });

    //  Gestione commenti
    document.querySelectorAll(".comment-form").forEach(form => {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const url = form.dataset.url;
            const input = form.querySelector('input[name="comment"]');
            const commentText = input.value.trim();
            const commentsDiv = form.closest(".anime-card").querySelector(".comments");

            if (!commentText) return;

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({ comment: commentText })
                });

                const data = await res.json();

                if (data.success) {
                    
                    const newComment = document.createElement("p");
                    newComment.innerHTML = `<strong>${data.user ?? 'Tu'}:</strong> ${commentText}`;
                    commentsDiv.prepend(newComment);

                    input.value = ""; 
                }
            } catch (err) {
                console.error("Errore nel commento:", err);
            }
        });
    });
});
