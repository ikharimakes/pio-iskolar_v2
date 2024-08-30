// PAGINATION
let ul = document.querySelector(".ul");
let prevButton = document.querySelector(".prev");
let nextButton = document.querySelector(".next");

// Get total pages and current page from the data attributes
let total_page = parseInt(ul.dataset.totalPages);
let current_page = parseInt(ul.dataset.currentPage);

// Function to update the page links
function updatePageLinks() {
    ul.innerHTML = "";
    let before_page = current_page - 2;
    let after_page = current_page + 2;
    let searchParams = new URLSearchParams(window.location.search);
    let search = searchParams.get('search') || '';
    let sort = searchParams.get('sort') || 'batch_num';
    let order = searchParams.get('order') || 'DESC';

    if (current_page == 2) {
        before_page = current_page - 1;
    }
    if (current_page == 1) {
        before_page = current_page;
    }

    if (current_page == total_page - 1) {
        after_page = current_page + 1;
    }
    if (current_page == total_page) {
        after_page = current_page;
    }

    for (let i = before_page; i <= after_page; i++) {
        if (i > 0 && i <= total_page) {
            let active_page = current_page == i ? "active_page" : "";
            ul.innerHTML += '<li><a href="?page=' + i + '&search=' + encodeURIComponent(search) + '&sort=' + encodeURIComponent(sort) + '&order=' + encodeURIComponent(order) + '" class="page_number ' + active_page + '">' + i + '</a></li>';
        }
    }

    // Update the Prev and Next button visibility
    prevButton.style.display = current_page <= 1 ? "none" : "block";
    nextButton.style.display = current_page >= total_page ? "none" : "block";
}

// Initial call to set up the page links
updatePageLinks();

// Add event listeners to the Prev and Next buttons
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.page_number');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.textContent.trim();
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', page);
            window.location.search = urlParams.toString();
        });
    });

    const prevButton = document.querySelector('.prev a');
    const nextButton = document.querySelector('.next a');

    if (prevButton) {
        prevButton.addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = parseInt(document.querySelector('.ul').dataset.currentPage);
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', currentPage - 1);
            window.location.search = urlParams.toString();
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function(e) {
            e.preventDefault();
            const currentPage = parseInt(document.querySelector('.ul').dataset.currentPage);
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', currentPage + 1);
            window.location.search = urlParams.toString();
        });
    }
});

