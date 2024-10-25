<?php
function renderPagination($current_page, $records_per_page, $total_records, $total_page, $sourceFile) {
    ?>
    <div class="pagination" id="pagination">
        <p>Showing <?php echo $current_page * $records_per_page - $records_per_page + 1; ?>-<?php echo min($current_page * $records_per_page, $total_records); ?> of <?php echo $total_records; ?> records</p>
        <div class="box">
            <?php if ($current_page > 1): ?>
                <button type="button" class="prev" onclick="navigatePage(<?php echo $current_page - 1; ?>, '<?php echo $sourceFile; ?>')">
                    Prev
                </button>
            <?php endif; ?>

            <ul class="ul">
                <?php for ($i = max(1, $current_page - 2); $i <= min($total_page, $current_page + 2); $i++): ?>
                    <li>
                        <a href="#" class="page_number <?php echo $i == $current_page ? 'active_page' : ''; ?>" onclick="navigatePage(<?php echo $i; ?>, '<?php echo $sourceFile; ?>')">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>

            <?php if ($current_page < $total_page): ?>
                <button type="button" class="next" onclick="navigatePage(<?php echo $current_page + 1; ?>, '<?php echo $sourceFile; ?>')">
                    Next
                </button>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>

<script>
// In page.php, modify the navigatePage function:
    function navigatePage(page, sourceFile) {
    // Table body mapping
    const tableBodyMapping = {
        'ad_announce.php': 'announceTableBody',
        'ad_reports.php': 'reportTableBody',
        'ad_scholar.php': 'scholarTableBody',
        'ad_school.php': 'schoolTableBody',
        'history.php': 'docTableBody'
    };

    // Get elements and log their values
    const searchInput = document.querySelector('input[name="search"]');
    const filterSelect = document.getElementById('filter');
    const categorySelect = document.getElementById('category');
    
    console.log('Debug Values:', {
        page,
        sourceFile,
        searchValue: searchInput?.value,
        filterValue: filterSelect?.value,
        categoryValue: categorySelect?.value
    });

    const tableBodyId = tableBodyMapping[sourceFile] || 'docTableBody';
    const tableBody = document.getElementById(tableBodyId);
    const pagination = document.getElementById('pagination');

    // Build parameters
    const params = new URLSearchParams();
    params.set('page', page);

    // Add parameters and log each addition
    if (searchInput?.value.trim()) {
        params.set('search', searchInput.value.trim());
        console.log('Added search param:', searchInput.value.trim());
    }

    if (categorySelect?.value) {
        params.set('category', categorySelect.value);
        console.log('Added category param:', categorySelect.value);
    }

    if (filterSelect?.value) {
        params.set('filter', filterSelect.value);
        console.log('Added filter param:', filterSelect.value);
    }

    // Log final URL parameters
    console.log('Final params:', params.toString());

    // Fetch updated table data
    const tableParams = new URLSearchParams(params);
    tableParams.set('ajax', 'table');
    
    const tableUrl = `${sourceFile}?${tableParams.toString()}`;
    console.log('Fetching table data from:', tableUrl);

    fetch(tableUrl)
        .then(response => {
            if (!response.ok) {
                console.error('Table fetch failed:', response.status, response.statusText);
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            if (tableBody) {
                tableBody.innerHTML = html;
                console.log('Table body updated successfully');
            } else {
                console.error('Table body element not found:', tableBodyId);
            }
        })
        .catch(error => console.error('Error fetching table data:', error));

    // Fetch updated pagination
    const paginationParams = new URLSearchParams(params);
    paginationParams.set('ajax', 'pagination');
    
    const paginationUrl = `${sourceFile}?${paginationParams.toString()}`;
    console.log('Fetching pagination from:', paginationUrl);

    fetch(paginationUrl)
        .then(response => {
            if (!response.ok) {
                console.error('Pagination fetch failed:', response.status, response.statusText);
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            if (pagination) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newPagination = doc.querySelector('#pagination');
                if (newPagination) {
                    pagination.innerHTML = newPagination.innerHTML;
                    console.log('Pagination updated successfully');
                } else {
                    console.error('New pagination element not found in response');
                }
            } else {
                console.error('Pagination element not found in document');
            }
        })
        .catch(error => console.error('Error fetching pagination:', error));
}
</script>
