<?php 
    include_once('../functions/general.php'); 
    include('../functions/scholar_view.php');
    include('../functions/scholar_fx.php');
    include('../functions/document_view.php');
    include('../functions/document_fx.php');
    include('../functions/document_upload.php');
    $sourceFile = 'ad_skoDetail.php';

    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : null);

    if ($user_role == "1") {
    } elseif ($user_role == "2") {
        header("Location: dashboard.php");
    } elseif ($user_role == "3") {
        header("Location: eval_dashboard.php");
    } else {
        header("Location: front_page.php");
    }

    $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'scholar_id';
    $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';

    if(isset($_POST['scholar_id'])) {$_SESSION['sid'] = $_POST['scholar_id'];}
    $id = $_SESSION['sid'];

    if (isset($_GET['ajax'])) {
        if ($_GET['ajax'] === 'table') {
            docxAdmin($id, $current_page, $sort_column, $sort_order);
        }
        exit;
    }

    global $year, $sem;

    function getUploadButtonHtml($scholar_id, $doc_type, $year, $sem) {
        $docDetails = getDocumentDetails($scholar_id, $doc_type, $year, $sem);
        if ($docDetails) {
            if ($docDetails['doc_status'] === 'DECLINED') {
                $buttonLabel = 'REPLACE DOCUMENT';
                $buttonStyle = 'style=""';
            } else {
                $buttonLabel = '';
                $buttonStyle = 'style="display:none;"';
            }
            return "
                <label type='button' class='lblAdd' for='choose-file-$doc_type' $buttonStyle>
                    <ion-icon name='share-outline'></ion-icon> <b> $buttonLabel </b>
                </label>
                <input name='$doc_type' type='file' id='choose-file-$doc_type' accept='.pdf' style='display: none;' $buttonStyle /> <p>{$docDetails['doc_name']} - <b>{$docDetails['doc_status']}</b></p>
            ";
        } else {
            return "
                <label type='button' class='lblAdd' for='choose-file-$doc_type'>
                    <ion-icon name='share-outline'></ion-icon> UPLOAD FILE
                </label>
                <input name='$doc_type' type='file' id='choose-file-$doc_type' accept='.pdf' style='display: none;' />
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pio Iskolar</title>
    <link rel="icon" type="image/x-icon" href="images/pio-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/ad_docs.css">
    <link rel="stylesheet" href="css/ad_skoDetail.css">
    <link rel="stylesheet" href="css/confirm.css">
</head>

<body>
    <!-- SIDEBAR - ad_navbar.php -->
    <?php include 'ad_navbar.php'; ?>

    <!-- TOP BAR -->
    <div class="main2">
        <div class="topBar">
            <a href="./ad_scholar.php" style="text-decoration:none">
            <button class="headerBack" id="clickableIcon">
                <ion-icon name="chevron-back-outline"></ion-icon>
                <h1>Back</h1>
            </button>
            </a>

            <div class="headerRight">
                <a class="user" href="ad_settings.php">
                    <img src="images/profile.png" alt="">
                </a>
            </div>
        </div>

        <!-- TOP NAV -->
        <div class="details"><center> 
            <?php scholarFull(); ?>
        </center></div>

        <?php scholarDetail();?>
        
        <div></div>

        <div class="accordion">
            <!-- <div class="table">
                <button class="tblTitle active">
                    <span>
                        PLV 2024-2025 1ST SEMESTER
                    </span>
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </button>

                <div class="tblContent" style="display:block;">
                    <table>
                        <tr style="font-weight: bold;">
                            <th style="width:10%"> Type </th>
                            <th style="width:65%">
                                <div class="docName-header" id="sortDocName" style="cursor: pointer;">
                                    Document Name
                                    <i id="docNameSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:10%"> Status </th>
                            <th style="width:10%">
                                <div class="date-header" id="sortDate" style="justify-content: center; cursor: pointer;">
                                    Date
                                    <i id="dateSortIcon" class="fa fa-sort"></i>
                                </div>
                            </th>
                            <th style="width:5%"> Action </th>
                        </tr>
                        <tbody id="docTableBody">
                            <?php //docxAdmin($id, $sort_column, $sort_order); ?>
                        </tbody>
                    </table>
                </div>
            </div> -->
            <?php docxAdmin($id, $sort_column, $sort_order); ?>
        </div>

        <!--
            <br> <br>
            <table id="remarksTable" class="table-container">
                <tr>
                    <th class="details2">REMARKS 
                        <ion-icon name="pencil-outline" onclick="toggleEdit('remarksTable')"></ion-icon>
                    </th>
                </tr>
                <tr>
                    <td><input type="text" class="input3"></td>
                </tr>
            </table>  
        </div> <br>  
        -->
    </div>
    
    <!-- VIEW MODAL -->
    <div id="viewModal" class="view">
        <div class="view-content">
            <h2 id="view-doc_name">Document Name</h2>
            <span class="closeView" onclick="closePrev()">&times;</span>
            
            <form id="updateForm" method="post" action="">
                <input type="hidden" id="update-doc_id" name="doc_id">

                <div class="status">
                    <h4>Status:</h4>
                    <label>
                        <input type="radio" name="status" value="APPROVED" id="approveRadio"> APPROVE
                    </label>
                    <label>
                        <input type="radio" name="status" value="DECLINED" id="declineRadio"> DECLINE
                    </label>
                </div>

                <div id="declineOptions" style="display: none;">
                    <div class="decline">
                        <h4>Reason for Declining:</h4>
                        <select name="declineReason" id="declineReasonSelect">
                            <option value="" disabled selected>Select a reason</option>
                            <option value="CORRUPTED FILE">CORRUPTED FILE</option>
                            <option value="NOT LEGIBLE/READABLE">NOT LEGIBLE/READABLE</option>
                            <option value="WRONG DOCUMENT">WRONG DOCUMENT</option>
                            <option value="OTHER">OTHER</option>
                        </select>
                    </div>

                    <div id="otherReason" style="display: none;" class="others">
                        <h4>Enter other reasons:</h4>
                        <textarea name="reason" id="denialReasonText" placeholder="Type your reason here"></textarea>
                    </div>
                </div> <br>

                <center>
                    <button id="updateButton" type="submit" name="update" class="btnSave">Save</button>
                </center>
            </form>

             <br> <hr> <br>
            <center>
                <div class="pdfViewer" id="pdfViewer"></div>
            </center>
        </div>
    </div>

    <?php include('confirm.php');?>
    <?php include('notiF.php');?>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.1.81/pdf.min.js"></script>
    <script>
        //ACCORDION
        var acc = document.getElementsByClassName("tblTitle active");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var tblContent = this.nextElementSibling;
                if (tblContent.style.display === "block") {
                    tblContent.style.display = "none";
                } else {
                    tblContent.style.display = "block";
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const editButton = document.getElementById('editButton');
            const cancelButton = document.getElementById('cancelButton');
            const saveButton = document.getElementById('saveButton');
            const inputs = document.querySelectorAll('input[readonly], select[disabled]');

            editButton.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                });
                editButton.style.display = 'none';
                cancelButton.style.display = 'block';
                saveButton.style.display = 'block';
            });

            cancelButton.addEventListener('click', function() {
                inputs.forEach(input => {
                    input.setAttribute('readonly', 'readonly');
                    input.setAttribute('disabled', 'disabled');
                });
                editButton.style.display = 'inline';
                cancelButton.style.display = 'none';
                saveButton.style.display = 'none';
                // Optionally, reload the page to revert changes
                location.reload();
            });

            saveButton.addEventListener('click', function() {
                document.getElementById('profileForm').submit();
            });
        });

        // FETCH API SEARCH/SORT/FILTER AND PAGINATION
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('docTableBody');

            let sortStates = {
                'doc_name': 'neutral',
                'sub_date': 'neutral'
            };

            const updateSortIcons = () => {
                const icons = {
                    'doc_name': document.getElementById('docNameSortIcon'),
                    'sub_date': document.getElementById('dateSortIcon'),
                };

                for (const [column, icon] of Object.entries(icons)) {
                    const state = sortStates[column];
                    if (state === 'neutral') {
                        icon.className = 'fa fa-sort';
                    } else if (state === 'asc') {
                        icon.className = 'fa fa-sort-up';
                    } else if (state === 'desc') {
                        icon.className = 'fa fa-sort-down';
                    }
                }
            };

            const handleSort = (headerId, sortKey) => {
                const header = document.getElementById(headerId);
                header.addEventListener('click', () => {
                    const currentState = sortStates[sortKey];
                    let nextState;
                    if (currentState === 'neutral') {
                        nextState = 'asc';
                    } else if (currentState === 'asc') {
                        nextState = 'desc';
                    } else {
                        nextState = 'neutral';
                    }
                    sortStates[sortKey] = nextState;

                    for (const key in sortStates) {
                        if (key !== sortKey) {
                            sortStates[key] = 'neutral';
                        }
                    }

                    updateSortIcons();
                    fetchData();
                });
            };

            handleSort('sortDocName', 'doc_name');
            handleSort('sortDate', 'sub_date');
            updateSortIcons();

            const fetchData = (page = 1) => {
                const params = new URLSearchParams(window.location.search);
                params.set('page', page);
                for (const [column, state] of Object.entries(sortStates)) {
                    if (state !== 'neutral') {
                        params.set('sort_column', column);
                        params.set('sort_order', state);
                    }
                }
            };

            const navigatePage = (page, sourceFile) => {
                const sortColumn = Object.keys(sortStates).find(column => sortStates[column] !== 'neutral');
                if (sortColumn) {
                    params.set('sort_column', sortColumn);
                    params.set('sort_order', sortStates[sortColumn]);
                }

                // Fetch table data
                params.set('ajax', 'table');
                fetch(`${sourceFile}?${params.toString()}`)
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching table data:', error));
            };

            fetchData(); // Initial fetch on page load
        });

        // VIEW MODAL
        function openPrev(elem) {
            document.getElementById('viewModal').style.display = 'block';
            document.getElementById("view-doc_name").innerText = elem.getAttribute("data-doc_name");
            document.getElementById("update-doc_id").value = elem.getAttribute("data-id");

            const pdfPath = '../assets/' + elem.getAttribute("data-doc_name");
            console.log(pdfPath);
            loadPDF(pdfPath);
        }

        function closePrev() {
            document.getElementById('viewModal').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('viewModal')) {
                closePrev();
            }
        });


        // Show reason for declining when "DECLINED" is selected
        document.getElementById('declineRadio').addEventListener('click', function() {
            document.getElementById('declineOptions').style.display = 'block';
        });

        // Hide reason for declining when "APPROVED" is selected
        document.getElementById('approveRadio').addEventListener('click', function() {
            document.getElementById('declineOptions').style.display = 'none';
            document.getElementById('otherReason').style.display = 'none'; // Hide "Other" reasons if previously selected
            document.getElementById('declineReasonSelect').selectedIndex = 0; // Reset dropdown
        });

        // Show textarea when "OTHER" is selected
        document.getElementById('declineReasonSelect').addEventListener('change', function() {
            if (this.value === 'OTHER') {
                document.getElementById('otherReason').style.display = 'block';
            } else {
                document.getElementById('otherReason').style.display = 'none';
            }
        });

        // PDF VIEWER
        function loadPDF(pdfPath) {
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.1.81/pdf.worker.min.js';

            var loadingTask = pdfjsLib.getDocument(pdfPath);
            loadingTask.promise.then(function(pdf) {
                console.log('PDF loaded');

                pdf.getPage(1).then(function(page) {
                    console.log('Page loaded');

                    var scale = 1.5;
                    var viewport = page.getViewport({ scale: scale });

                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);
                    renderTask.promise.then(function() {
                        console.log('Page rendered');
                        var pdfViewer = document.getElementById('pdfViewer');
                        pdfViewer.innerHTML = '';
                        pdfViewer.appendChild(canvas);
                    });
                });
            }, function (reason) {
                console.error(reason);
            });
        }

        $(document).ready(function () {
            // Select all input elements with class 'custom-file-upload'
            $('input[type=file]').change(function () {
                var file = $(this)[0].files[0].name;
                // Find the corresponding label by its 'for' attribute
                var labelFor = $(this).attr('id');
                $('label[for=' + labelFor + ']').text(file);
            });
        });
    </script>
</body>
</html>
