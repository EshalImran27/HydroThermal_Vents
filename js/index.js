const dropdowns = document.querySelectorAll('.dropdown');
const filterButton = document.querySelector('.filter-button');
const filters = document.querySelector('.filters');
const applyFiltersButton = document.getElementById('apply-filters');
const clearFiltersButton = document.getElementById('clear-filters');
const activeFiltersSpan = document.getElementById('active-filters');
const depthSlider = document.getElementById('depth-slider');
const depthValue = document.getElementById('depth-value');
const yearSlider = document.getElementById('discovery-year-slider');
const yearValue = document. getElementById('discovery-year-value');

// only display the filter options when the filter button is clicked,
// and hide them when the button is clicked again or when the user clicks outside the filter area.
filterButton?.addEventListener('click', () => {
    filters?.classList.toggle('is-open');
});
// open each dropdown menu when the user clicks on it
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
            selected.textContent = option.textContent;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');
            options.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
        }
        );
    });
});
// the filter options will be hidden when the user clicks outside the filter area,
window.addEventListener('click', (e) => {
    if (!filters?.contains(e.target) && !filterButton?.contains(e.target)) {
        filters?.classList.remove('is-open');
    }
});

// filter by type functionality is implemented by adding an event listener to each option 
// in the type dropdown menu.
let selectedType = 'All';
const typeDropdown = document.querySelectorAll('.dropdown')[1];
typeDropdown?.querySelectorAll('li').forEach(item => {
    item.addEventListener('click', () => {
        selectedType = (item.textContent || '').trim();
    });
});
// the depth and year sliders are implemented by adding event listeners to the input event of each slider,
 depthSlider?.addEventListener('input', () => {
     depthValue.textContent = `0 - ${depthSlider.value} m`;
 });
 yearSlider?.addEventListener('input', () => {
     yearValue.textContent = `1977 - ${yearSlider.value}`;
 });

 // the search functionality is implemented by adding an event listener to the submit event of the search form,
 // it filters the vent cards based on the search query and displays a message if no vents are found matching the search criteria.

document.querySelector('.search-form')?.addEventListener('submit', function(e) {
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
            emptyMessage.style.color = '#a08160';
            emptyMessage.textContent = 'No vents found matching your search.';
            document.querySelector('.cards').after(emptyMessage);
        }
        emptyMessage.style.display = '';
    } else if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
});

// the filter functionality is implemented by adding an event listener to the submit event of the filter form,
// it filters the vent cards based on the selected filter options and displays a message if no vents are found matching 
// the filter criteria.
document.querySelector('#vent-filter-form')?.addEventListener("submit", function(e){
    e.preventDefault();
    const maxYear=parseInt(yearSlider.value);
    const minYear=1977;
    const minDepth=0;
    const maxDepth=parseInt(depthSlider.value);
    const ventCards= document.querySelectorAll('.card');
    let anyVisible = false;
    // using parserInt to convert the string values from the data attributes to integers for comparison,
    // and using logical operators to check if the vent card matches the selected filter options.
    ventCards.forEach(card =>{
        const filterYear = parseInt(card.getAttribute('data-year'));
        const filterDepth = parseInt(card.getAttribute('data-depth'));
        const filterType = card.getAttribute('data-type');
        const typeMatch = selectedType === 'All' || filterType === selectedType;
        const yearMatch = filterYear >= minYear && filterYear <= maxYear;
        const depthMatch = filterDepth >= minDepth && filterDepth <= maxDepth;

        if (typeMatch && yearMatch && depthMatch) {
            activeFiltersSpan.textContent = `Type: ${selectedType}, Year: ${minYear}-${maxYear}, Depth: ${minDepth}-${maxDepth} m`;
            card.style.display = '';
            anyVisible = true;
        } else {
            card.style.display = 'none';
        }
    });
    let emptyMessage = document.getElementById('empty-message');
    if (!anyVisible) {
        if (!emptyMessage) {
            emptyMessage = document.createElement('p');
            emptyMessage.id = 'empty-message';
            emptyMessage.textContent = 'No vents found matching your search.';
            emptyMessage.style.color = '#a08160';
            document.querySelector('.cards').after(emptyMessage);
        }
        emptyMessage.style.display = '';
    } else if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
    filters?.classList.toggle('is-open');

});

document.querySelector('#vent-filter-form')?.addEventListener('reset', function() {
    depthSlider.value = 5000;
    yearSlider.value = new Date().getFullYear();
    depthValue.textContent = `0 - ${depthSlider.value} m`;
    yearValue.textContent = `1977 - ${yearSlider.value}`;
    document.querySelectorAll('.card').forEach(card => card.style.display = '');
    let emptyMessage = document.getElementById('empty-message');
    if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }
    activeFiltersSpan.textContent = '';
    filters?.classList.toggle('is-open');
});

