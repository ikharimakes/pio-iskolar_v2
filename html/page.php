    <!-- CSS FILE -->
    <link rel="stylesheet" href="css/page.css">   

    <!-- HTML CODE -->
    <div class="pagination">
        <p>Showing 1-15 of 200 records</p>
        <div class="box">
            <button type="button" class="prev">
                <a href="">Prev</a>
            </button>

            <ul class="ul">
                <li>
                    <a href=""> </a>
                </li>
            </ul>

            <button type="button" class="next">
                <a href="">Next</a>
            </button>
        </div>
    </div>

    <!-- JS CODE -->
    <script>
        //PAGINATION
        let ul =document.querySelector(".ul");
        let prev =document.querySelector(".prev");
        let next =document.querySelector(".next");
        let current_page = 5;
        let total_page = 10;
        let active_page = "";

        crete_pages(current_page);

        function crete_pages(current_page) {
            ul.innerHTML = "";

            let before_page = current_page - 2;
            let after_page = current_page + 2;

            if(current_page == 2) {
                before_page = current_page - 1;
            }
            if(current_page == 1) {
                before_page = current_page;
            }

            if(current_page == total_page - 1) {
                after_page = current_page + 1;
            }
            if(current_page == total_page) {
                after_page = current_page;
            }

            for (let i = before_page; i <= after_page; i++) {
                if (current_page == i) { 
                    active_page = "active_page"; 
                } else {
                    active_page = "";
                }
                ul.innerHTML += '<li onclick="crete_pages(' +i+ ')"> <a href="#" class="page_number '+ active_page +' ">' +i+ '</a> </li>';
            }

            prev.onclick =function() {
                current_page--;
                crete_pages(current_page);
            }
            if(current_page <= 1) {
                prev.style.display = "none";
            } else {
                prev.style.display = "block";
            }

            next.onclick =function() {
                current_page++;
                crete_pages(current_page);
            }
            if(current_page >= total_page) {
                next.style.display = "none";
            } else {
                next.style.display = "block";
            }
        }
    </script>