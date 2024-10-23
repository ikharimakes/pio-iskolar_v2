    <!-- CSS FILE-->
    <link rel="stylesheet" href="css/confirm.css">
    
    <!-- HTML CODE -->
    <!-- DELETE MODAL -->
    <div id="deleteOverlay" class="deleteOverlay">
        <div class="delete-content">
            <div class="infos">
                <h2>Confirm Delete</h2>
                <br>
                <p>You are about to delete this record. Please enter your credentials to delete it permanently:</p>
            </div>
            <br> 
            <form id="deleteForm" method="POST" novalidate>
                <div class="inner-content">
                    <label class="deleteText" for="username">Username:</label> <br>
                    <input class="input" type="text" id="username" name="username" placeholder="Enter Username" required>
                </div>
                <div class="inner-content">
                    <label class="deleteText" for="password">Password:</label> <br>
                    <input class="input" type="password" id="password" name="password" placeholder="Enter Password" required>
                    <br>
                    <input type="checkbox" id="showPassword" style="position:absolute; top:355px">
                    <label for="showPassword" style="font-size: 12px; position:absolute; top: 353px; left:90px">Show Password</label>
                </div>
                <div id="loginError" style="color: red; display: none; text-align: center;">Invalid Credentials!</div>
                <div class="delete-button-container">
                    <input type="hidden" id="type" name="type">
                    <input type="hidden" id="delete-id" name="id">
                    <input type="hidden" id="delete-name" name="name">
                    <button class="cancel-button" type="button" onclick="closeDelete()"> Cancel </button>
                    <button class="delete-button" type="submit"> Confirm Delete </button>
                </div>
            </form>
        </div>
    </div>

    <!-- APPROVE MODAL -->
    <div id="approveOverlay" class="overlay">
        <div class="overlay-content">
            <div class="infos">
                <h2>Confirm Approval</h2>
                <span class="closeOverlay" onclick="closeApprove()">&times;</span>
            </div>
            <div class="message">
                <h4>Are you sure you want to approve this document?</h4>
            </div>
            <div class="button-container">
                <form id="approveForm" method="post" action="">
                    <input type="hidden" id="approve-id" name="doc_id">
                    <button type="submit" name="approve" class="yes-button">Yes</button>
                    <button type="button" class="no-button" onclick="closeApprove()">No</button>
                </form>
            </div>
        </div>
    </div>

    <!-- DECLINE MODAL -->
    <div id="declineOverlay" class="overlay">
        <div class="overlay-content">
            <div class="infos">
                <h2>Confirm Decline</h2>
                <span class="closeOverlay" onclick="closeDecline()">&times;</span>
            </div>
            <form id="declineForm" method="post" action="">
                <input type="hidden" id="decline-id" name="doc_id">

                <div class="message">
                    <h4>Are you sure you want to decline this document?</h4>
                </div>

                <div id="declineOptions2">
                        <div class="decline">
                            <select name="declineReason_alt" id="declineReasonSelect2" style="width:100%">
                                <option value="" disabled selected>Reason for Declining</option>
                                <option value="CORRUPTED FILE">CORRUPTED FILE</option>
                                <option value="NOT LEGIBLE/READABLE">NOT LEGIBLE/READABLE</option>
                                <option value="WRONG DOCUMENT">WRONG DOCUMENT</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </div>

                        <div id="otherReason2" style="display: none;" class="others">
                            <h4>Enter other reasons:</h4>
                            <textarea name="reason_alt" id="denialReasonText2" placeholder="Type your reason here"></textarea>
                        </div>
                    </div>

                <div class="button-container">
                        <button type="submit" name="decline" class="yes-button" id="declineSubmitButton2" class="disabled-button">Yes</button>
                        <button type="button" class="no-button" onclick="closeDecline()">No</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS CODE-->
    <script>

        // APPROVE
        function openApprove(elem) {
            if (elem.closest('.icon').classList.contains('disabled')) return;
            document.getElementById("approve-id").value = elem.getAttribute("data-id");
            document.getElementById("approveOverlay").style.display = "block";
        }
        function closeApprove() {
            document.getElementById("approveOverlay").style.display = "none";
        }

        // DECLINE
        function openDecline(elem) {
            if (elem.closest('.icon').classList.contains('disabled')) return;
            document.getElementById("decline-id").value = elem.getAttribute("data-id");
            document.getElementById("declineOverlay").style.display = "block";
        }

        function closeDecline(elem) {
            document.getElementById("declineOverlay").style.display = "none";
        }

        // DELETE
        function openDelete(elem) {
            document.getElementById("type").value = elem.getAttribute("type");
            document.getElementById("delete-id").value = elem.getAttribute("data-id");
            document.getElementById("delete-name").value = elem.getAttribute("data-name");
            document.getElementById("deleteOverlay").style.display = "block";
        }
        function closeDelete() {
            document.getElementById("deleteForm").reset();  // Reset the form fields
            document.getElementById("deleteOverlay").style.display = "none";
        }

        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            const form = e.target;
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            
            const loginError = document.getElementById('loginError');
            loginError.style.display = 'none';

            requiredFields.forEach(field => {
                if (!field.value) {
                field.classList.add('required-error');
                valid = false;
                } else {
                field.classList.remove('required-error');
                }
            });

            if (!valid) {
                e.preventDefault(); // Prevent form submission if required fields are empty
            } else {
                e.preventDefault();

                const formData = new FormData(this);
                const data = new URLSearchParams();

                for (const pair of formData) {
                    data.append(pair[0], pair[1]);
                }

                fetch('../functions/delete_fx.php', {
                    method: 'POST',
                    body: data,
                })
                .then(response => response.text()) // Expect text response from the backend
                .then(response => {
                    if (response === 'success') {
                        // Store the success message in sessionStorage before reload
                        sessionStorage.setItem('toastMessage', 'Record successfully deleted.');
                        sessionStorage.setItem('toastTitle', 'Success');

                        // Reload the page
                        window.location.href = '<?php echo $_SERVER["PHP_SELF"]; ?>';
                    } else if (response === 'invalid') {
                        document.getElementById('loginError').style.display = 'block';
                    } else {
                        showToast('An error occurred during deletion.', 'Error');
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    showToast('An unexpected error occurred.', 'Error');
                });
            }
        });

        window.addEventListener('load', function() {
            const message = sessionStorage.getItem('toastMessage');
            const title = sessionStorage.getItem('toastTitle');

            if (message && title) {
                // Show the success toast
                showToast(message, title);

                // Clear the message from sessionStorage after displaying
                sessionStorage.removeItem('toastMessage');
                sessionStorage.removeItem('toastTitle');
            }
        });

        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>