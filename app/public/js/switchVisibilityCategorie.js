const inputs = document.querySelectorAll('input[data-switch-categorie-id]');

inputs.forEach((item) => {
    item.addEventListener('change', async (e) => {
        const id = e.currentTarget.dataset.switchCategorieId;

        const response = await fetch(`/admin/categories/${id}/switch`);

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