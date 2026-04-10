<?php
include "includes/db.php";
include "includes/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Listing & Rating System</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- jQuery -->
    <script src="assets/js/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- Raty Plugin -->
    <script src="assets/js/jquery.raty.min.js"></script>

    <style>
        body {
            background: #f8f9fa;
        }
        .modal-title {
            font-weight: bold;
        }
        table th, table td {
            vertical-align: middle !important;
        }
        .star-rating {
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Business Listing & Rating System</h2>

        <button class="btn btn-primary mb-3" id="addBusinessBtn">+ Add Business</button>

        <table class="table table-bordered table-striped" id="businessTable">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Business Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th width="140">Actions</th>
                <th width="150">Average Rating</th>
            </tr>
            </thead>
            <tbody>
                <!-- Loaded by AJAX -->
            </tbody>
        </table>
    </div>


    <!-- ------------------- ADD / EDIT BUSINESS MODAL ------------------- -->
    <div class="modal fade" id="businessModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="businessForm">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Business</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id" id="business_id">

                        <div class="form-group mb-3">
                            <label>Business Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Address</label>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Save</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- ------------------- RATING MODAL ------------------- -->
    <div class="modal fade" id="ratingModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="ratingForm">

                    <div class="modal-header">
                        <h5 class="modal-title">Submit Rating</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="business_id" id="rating_business_id">

                        <div class="form-group mb-3">
                            <label>Your Name</label>
                            <input type="text" name="name" id="rating_name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="rating_email" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="rating_phone" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Rating</label>
                            <div id="star_rate"></div>
                            <input type="hidden" name="rating" id="rating_value" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Submit Rating</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- ------------------- AJAX LOGIC ------------------- -->
    <script>
        $(document).ready(function () {

            loadBusinesses();


            /* ---------------- LOAD BUSINESS TABLE ---------------- */
            function loadBusinesses() {
                $.ajax({
                    url: "fetch_business.php",
                    type: "POST",
                    success: function (data) {
                        $("#businessTable tbody").html(data);

                        // Re-init raty for every row
                        $('.avgRating').each(function () {
                            let rating = $(this).data("rating");
                            $(this).raty({
                                readOnly: true,
                                half: true,
                                starOn: 'assets/images/star-on.png',
                                starOff: 'assets/images/star-off.png',
                                starHalf: 'assets/images/star-half.png',
                                score: rating
                            });
                        });
                    }
                });
            }


            /* ---------------- OPEN ADD BUSINESS MODAL ---------------- */
            $("#addBusinessBtn").click(function () {
                $("#businessForm")[0].reset();
                $("#business_id").val("");
                $("#businessModal .modal-title").text("Add Business");
                $("#businessModal").modal("show");
            });


            /* ---------------- SAVE (ADD / EDIT) BUSINESS ---------------- */
            $("#businessForm").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: $("#business_id").val() === "" ? "add_business.php" : "update_business.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function () {
                        $("#businessModal").modal("hide");
                        loadBusinesses();
                    }
                });
            });


            /* ---------------- EDIT BUSINESS ---------------- */
            $(document).on("click", ".editBtn", function () {
                let id = $(this).data("id");

                $.ajax({
                    url: "fetch_single_business.php",
                    type: "POST",
                    data: { id: id },
                    success: function (data) {
                        let b = JSON.parse(data);

                        $("#business_id").val(b.id);
                        $("#name").val(b.name);
                        $("#address").val(b.address);
                        $("#phone").val(b.phone);
                        $("#email").val(b.email);

                        $("#businessModal .modal-title").text("Edit Business");
                        $("#businessModal").modal("show");
                    }
                });
            });


            /* ---------------- DELETE BUSINESS ---------------- */
            $(document).on("click", ".deleteBtn", function () {

                if (!confirm("Are you sure you want to delete this business?")) return;

                let id = $(this).data("id");

                $.ajax({
                    url: "delete_business.php",
                    type: "POST",
                    data: { id: id },
                    success: function () {
                        loadBusinesses();
                    }
                });
            });


            /* ---------------- OPEN RATING MODAL ---------------- */
            $(document).on("click", ".rateBtn", function () {
                let id = $(this).data("id");

                $("#rating_business_id").val(id);

                $("#ratingForm")[0].reset();

                // star rating box
                $("#star_rate").raty({
                    half: true,
                    click: function (score) {
                        $("#rating_value").val(score);
                    },
                    starOn: 'assets/images/star-on.png',
                    starOff: 'assets/images/star-off.png',
                    starHalf: 'assets/images/star-half.png'
                });

                $("#ratingModal").modal("show");
            });


            /* ---------------- SUBMIT RATING ---------------- */
            $("#ratingForm").submit(function (e) {
                e.preventDefault();
                
                $.ajax({
                    url: "rating_submit.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function () {
                        $("#ratingModal").modal("hide");
                        loadBusinesses();
                    }
                });
            });

        });
    </script>

</body>
</html>