    <!-- CSS FILE-->
    <link rel="stylesheet" href="css/confirm.css">
    
    <!-- HTML CODE -->
    <!-- DELETE MODAL -->
    <div id="deleteOverlay" class="deleteOverlay">
        <div class="delete-content">
            <div class="infos">
                <h2>Confirm Delete</h2>
                <br>
                <p>You are about to delete this report. Please enter your credentials to delete it permanently:</p>
            </div>
            <br> 
            
            <form method="POST">
            <!-- Hidden input field to store osqcar value -->
            <input type="hidden" id="delete-osqcar" name="osqcar">
                <div class="inner-content">
                    <label class="deleteText" for="username">Username:</label> <br>
                    <input class="input" type="username" id="username" name="username" placeholder="Enter Username" required>
                </div>

                <div class="inner-content">
                    <label class="deleteText" for="password">Password:</label> <br>
                    <input class="input" type="password" id="password" name="password" placeholder="Enter Password" required>
                    <br>
                    <input type="checkbox" id="showPassword" style="position:absolute; top:355px">
                    <label for="showPassword" style="font-size: 12px; position:absolute; top: 353px; left:90px">Show Password</label>
                </div>

                <div class="delete-button-container">
                    <button class="cancel-button" type="submit" onclick="closeDelete()"> Cancel </button>
                    <button class="delete-button" type="submit"> Delete Report </button>
                </div>
            </form>
        </div>
    </div>

    <!-- APPROVE MODAL -->
    <div id="approveOverlay" class="deleteOverlay">
        <div class="delete-content">
            <div class="infos">
                <h2>Confirm Approval</h2>
                <span class="closeDelete" onclick="closeApprove()">&times;</span>
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
    <div id="declineOverlay" class="deleteOverlay">
        <div class="delete-content">
            <div class="infos">
                <h2>Confirm Decline</h2>
                <span class="closeDelete" onclick="closeDecline()">&times;</span>
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
        // DELETE
        function openDelete() {
            document.getElementById("deleteOverlay").style.display = "block";
        }
        function closeDelete() {
            document.getElementById("deleteOverlay").style.display = "none";
        }
        function submitForm() {
            closeDelete();
        }

        // APPROVE
        function openApprove(elem) {
            document.getElementById("approve-id").value = elem.getAttribute("data-id");
            document.getElementById("approveOverlay").style.display = "block";
        }

        function closeApprove() {
            document.getElementById("approveOverlay").style.display = "none";
        }

        // DECLINE
        function openDecline(elem) {
            document.getElementById("decline-id").value = elem.getAttribute("data-id");
            document.getElementById("declineOverlay").style.display = "block";
        }
        function closeDecline(elem) {
            document.getElementById("declineOverlay").style.display = "none";
        }
    </script>