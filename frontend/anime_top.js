document.addEventListener("DOMContentLoaded", () => {

    //  GESTIONE LIKE
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", async () => {
            const url = button.dataset.url;
            const card = button.closest(".anime-card"); 
            const countSpan = card?.querySelector(".likes-count");

            if (!url || !countSpan) {
                console.error("Errore: manca data-url o .likes-count");
                return;
            }

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json",
                    },
                });

                if (!res.ok) throw new Error("Errore nella richiesta");

                const data = await res.json();

                
                if (data.likes !== undefined) {
                    countSpan.textContent = data.likes;
                } else if (data.success && data.newLikesCount) {
                    // fallback nel caso il JSON abbia un campo diverso
                    countSpan.textContent = data.newLikesCount;
                }

            } catch (error) {
                console.error("Errore nel like:", error);
            }
        });
    });


    //  GESTIONE COMMENTI
    document.querySelectorAll(".comment-form").forEach(form => {
        form.addEventListener("submit", async e => {
            e.preventDefault();

            const url = form.dataset.url;
            const input = form.querySelector('input[name="comment"]');
            const commentText = input.value.trim();
            const commentsDiv = form.closest(".anime-card")?.querySelector(".comments");

            if (!commentText || !url || !commentsDiv) return;

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

                if (!res.ok) throw new Error("Errore server");

                const data = await res.json();

                
                const newComment = document.createElement("p");
                newComment.innerHTML = `<strong>${data.user ?? 'Tu'}:</strong> ${data.comment ?? commentText}`;
                commentsDiv.prepend(newComment);

                input.value = ""; 
            } catch (err) {
                console.error("Errore nel commento:", err);
            }
        });
    });

});
