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
    function navigatePage(page, sourceFile) {
        const searchInput = document.querySelector('input[name="search"]').value.trim();
        const selectedFilter = document.getElementById('filter').value;
        const categorySelect = document.getElementById('category').value;
        const tableBody = document.getElementById('docTableBody');
        const pagination = document.getElementById('pagination');

        let sortColumn = '';
        let sortOrder = '';

        // Check for active sort
        const activeSortIcons = document.querySelectorAll('.fa-sort-up, .fa-sort-down');
        if (activeSortIcons.length > 0) {
            const activeSortIcon = activeSortIcons[0];
            sortColumn = activeSortIcon.closest('div').id.replace('sort', '').toLowerCase();
            sortOrder = activeSortIcon.classList.contains('fa-sort-up') ? 'asc' : 'desc';
        }

        const params = new URLSearchParams();
        params.set('page', page);

        if (searchInput) {
            params.set('search', searchInput);
        }

        if (selectedCategory) {
            params.set('category', selectedCategory);
            if (selectedFilter) {
                params.set('filter', selectedFilter);
            }
        }

        if (sortColumn && sortOrder) {
            params.set('sort_column', sortColumn);
            params.set('sort_order', sortOrder);
        }

        // Fetch table data
        params.set('ajax', 'table');
        fetch(`${sourceFile}?${params.toString()}`)
            .then(response => response.text())
            .then(html => {
                tableBody.innerHTML = html;
            })
            .catch(error => console.error('Error fetching table data:', error));

        // Fetch pagination data
        params.set('ajax', 'pagination');
        fetch(`${sourceFile}?${params.toString()}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newPagination = doc.querySelector('#pagination');
                if (newPagination) {
                    pagination.innerHTML = newPagination.innerHTML;
                }
            })
            .catch(error => console.error('Error fetching pagination data:', error));
    }
</script>
