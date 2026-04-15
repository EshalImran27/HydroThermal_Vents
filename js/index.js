const dropdowns = document.querySelectorAll('.dropdown');
const filterButton = document.querySelector('.filter-button');
const filters = document.querySelector('.filters');
const applyFiltersButton = document.getElementById('apply-filters');
const clearFiltersButton = document.getElementById('clear-filters');
const activeFiltersSpan = document.getElementById('active-filters');
filterButton.addEventListener('click', () => {
    filters.classList.toggle('is-open');
});
applyFiltersButton.addEventListener('click', () => {
    const location = document.getElementById('location').querySelector('.selected').innerText;
    const type = document.getElementById('type').querySelector('.selected').innerText;
    const depth = document.getElementById('depth').querySelector('.selected').innerText;
    const discoveryYear = document.getElementById('discovery-year').querySelector('.selected').innerText;

    const params = new URLSearchParams();
    if (location !== 'All Locations') params.append('location', location);
    if (type !== 'All Types') params.append('type', type);
    if (depth !== 'All Depths') params.append('depth', depth);
    if (discoveryYear !== 'All Years') params.append('discovery_year', discoveryYear);

    document.querySelector('.filters').classList.remove('is-open');
    window.location.href = `index.html?${params.toString()}`;
    activeFiltersSpan.textContent = 'Filters applied';
});
clearFiltersButton.addEventListener('click', () => {
    filters.classList.remove('is-open');
    activeFiltersSpan.textContent = 'No filters applied';
});
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



