const dropdowns = document.querySelectorAll('.dropdown');
const filterButton = document.querySelector('.filter-button');
const filters = document.querySelector('.filters');
const applyFiltersButton = document.getElementById('apply-filters');
const clearFiltersButton = document.getElementById('clear-filters');
const activeFiltersSpan = document.getElementById('active-filters');
const depthSlider = document.getElementById('depth-slider');
const depthValue = document.getElementById('depth-value');

// depthSlider.addEventListener('input', () => {
//     depthValue.textContent = `${depthSlider.value} m`;
// });
// const yearSlider = document.getElementById('discovery-year-slider');
// const yearValue = document.getElementById('discovery-year-value');
// yearSlider.addEventListener('input', () => {
//     yearValue.textContent = `${yearSlider.value}`;
// });
filterButton.addEventListener('click', () => {
    filters.classList.toggle('is-open');
});
// applyFiltersButton.addEventListener('click', () => {
//     const location = document.getElementById('location').querySelector('.selected').innerText;
//     const type = document.getElementById('type').querySelector('.selected').innerText;
//     const depth = document.getElementById('depth').querySelector('.selected').innerText;
//     const discoveryYear = document.getElementById('discovery-year').querySelector('.selected').innerText;

//     const params = new URLSearchParams();
//     if (location !== 'All Locations') params.append('location', location);
//     if (type !== 'All Types') params.append('type', type);
//     if (depth !== 'All Depths') params.append('depth', depth);
//     if (discoveryYear !== 'All Years') params.append('discovery_year', discoveryYear);

//     document.querySelector('.filters').classList.remove('is-open');
//     window.location.href = `index.html?${params.toString()}`;
//     activeFiltersSpan.textContent = 'Filters applied';
// });
// clearFiltersButton.addEventListener('click', () => {
//     filters.classList.remove('is-open');
//     activeFiltersSpan.textContent = 'No filters applied';
// });
dropdowns.forEach(dropdown => {
    const select = dropdown.querySelector('.select');
    const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    const options = dropdown.querySelectorAll('.menu li');
    const selected = dropdown.querySelector('.selected');

    select.addEventListener('click', () => {
        select.classList.toggle('select-clicked');
        caret.classList.toggle('caret-rotate');
        menu.classList.toggle('menu-open');
    });

    options.forEach(option => {
        option.addEventListener('click', () => {
            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');
            options.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
        }
        );
    });
});

// When a type is selected from the dropdown
// menuItems.forEach(item => {
//     item.addEventListener('click', () => {
//         const selected = item.textContent.trim();

//         ventCards.forEach(card => {
//             const ventType = card.dataset.type; // e.g. data-type="Back-arc basin"
//             const match = selected === 'All' || ventType === selected;
//             card.style.display = match ? '' : 'none';
//         });
//     });
// });
// <form class="search-form" method="get" action="search.php">
   // <input type="text" name="q" placeholder="Search vents by name or location..." required>
    //<button type="submit">Search</button>
//</form>

document.querySelector('.search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.querySelector('input[name="q"]').value.trim().toLowerCase();
    const ventCards = document.querySelectorAll('.card');

    let anyVisible = false;
    ventCards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
            const locationCards = card.querySelector('.card-location')?.textContent.toLowerCase() ?? '';
        const matches = name.includes(query) || locationCards.includes(query);
        card.style.display = matches ? '' : 'none';
        if (matches) anyVisible = true;
    });

    let emptyMessage = document.getElementById('empty-message');
    if (!anyVisible) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('p');
            emptyMessage.id = 'empty-message';
            emptyMessage.textContent = 'No vents found matching your search.';
            document.querySelector('.cards').after(emptyMessage);
        }
        emptyMessage.style.display = '';
    } else if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
});

