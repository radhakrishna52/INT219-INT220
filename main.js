document.addEventListener('DOMContentLoaded', function() {
    // Gallery search and filter functionality
    const searchInput = document.getElementById('search');
    const sortSelect = document.getElementById('sort');
    const filterBtn = document.getElementById('filter-btn');
    const artworksGrid = document.getElementById('artworks-grid');
    const noResults = document.getElementById('no-results');
    const artworkItems = document.querySelectorAll('.artwork-item');

    function filterArtworks() {
        const searchTerm = searchInput.value.toLowerCase();
        const sortValue = sortSelect.value;

        let filteredItems = Array.from(artworkItems).filter(item => {
            const title = item.dataset.title;
            return title.includes(searchTerm);
        });

        // Sort items
        filteredItems.sort((a, b) => {
            switch(sortValue) {
                case 'newest':
                    return b.dataset.date - a.dataset.date;
                case 'oldest':
                    return a.dataset.date - b.dataset.date;
                case 'price-high':
                    return b.dataset.price - a.dataset.price;
                case 'price-low':
                    return a.dataset.price - b.dataset.price;
                default:
                    return 0;
            }
        });

        // Clear current grid
        artworksGrid.innerHTML = '';

        // Append filtered and sorted items
        if (filteredItems.length > 0) {
            noResults.classList.add('hidden');
            filteredItems.forEach(item => {
                artworksGrid.appendChild(item);
            });
        } else {
            noResults.classList.remove('hidden');
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterArtworks);
    filterBtn.addEventListener('click', filterArtworks);

    // Initial filter
    filterArtworks();
});