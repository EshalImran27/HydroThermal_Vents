document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('vent-filter-form');
    const clearButton = document.getElementById('clear-filters');

    if (!filterForm) {
        return;
    }

    // Ensure accidental whitespace is trimmed before submit.
    filterForm.addEventListener('submit', () => {
        const locationInput = filterForm.querySelector('input[name="location"]');
        if (locationInput) {
            locationInput.value = locationInput.value.trim();
        }
    });

    if (clearButton) {
        clearButton.addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = 'index.php';
        });
    }
});



