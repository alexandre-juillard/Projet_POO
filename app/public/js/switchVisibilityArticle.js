const inputs = document.querySelectorAll('input[data-switch-article-id]');

inputs.forEach((item) => {
    item.addEventListener('change', async (e) => {
        const id = e.currentTarget.dataset.switchArticleId;

        const response = await fetch(`/admin/articles/${id}/switch`);

        if(response.ok) {
            const data = await response.json();

            const card = e.target.closest(".card");

            if(data.visibility) {
                card.classList.remove('bg-secondary');
                card.classList.add('bg-success');
            } else {
                card.classList.remove('bg-success');
                card.classList.add('bg-secondary');
            }
        }

        
    });
});