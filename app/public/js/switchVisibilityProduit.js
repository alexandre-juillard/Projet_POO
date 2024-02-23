const inputs = document.querySelectorAll('input[data-switch-produit-id]');

inputs.forEach((item) => {
    item.addEventListener('change', async (e) => {
        const id = e.currentTarget.dataset.switchProduitId;

        const response = await fetch(`/admin/produits/${id}/switch`);

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