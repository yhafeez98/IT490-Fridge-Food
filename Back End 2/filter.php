<?php

require "include/session_check.php";
require "db/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('dist/img/favico.ico') }}" type="image/ico" sizes="16x16">
    <title>Food</title>
    <?php
    include "include/css.php"; ?>

</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <?php
    include "include/header.php"; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php
    include "include/sidemenu.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Recipe</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool"
                                    data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="search_form">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control mb-2" name="title"
                                           placeholder="search recipe title">
                                </div>
                                <div class="col-md-4">
                                    <select name="cuisines" class="form-control select2">
                                        <option value="" selected disabled>Select Cuisine</option>
                                        <?php
                                        $q = "SELECT * FROM `cuisines` ORDER BY id DESC";
                                        $result = $db->select($q);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="servings" class="form-control select2">
                                        <option value="" selected disabled>Select Servings</option>
                                        <?php
                                        $q = "SELECT DISTINCT servings FROM `recipes`;";
                                        $result = $db->select($q);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?= $row->servings ?>"><?= $row->servings ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="ready_in_minutes" class="form-control select2">
                                        <option value="" selected disabled>Select Minutes</option>
                                        <?php
                                        $q = "SELECT DISTINCT ready_in_minutes FROM `recipes`;";
                                        $result = $db->select($q);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?= $row->ready_in_minutes ?>">
                                                <?= $row->ready_in_minutes ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-info mt-2 float-right" type="submit">Apply Filter</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recipe List
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool"
                                    data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="table_div">

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    <form method="post" id="add_form">
        <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Recipe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_name" class="required">Title</label>
                                    <input type="text" class="form-control"
                                           placeholder="Enter Recipe Title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ready_in_minutes" class="required">Ready in Minutes</label>
                                    <input type="number" class="form-control"
                                           placeholder="Enter Time"
                                           name="ready_in_minutes"
                                           min="0"
                                           required
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Recipe Image</label>
                                <div class="custom-file">
                                    <input type="file" class="" name="image" required>
                                </div>
                                <p>
                                    <small class="cr-file-description">
                                        image size should be less than 2mb
                                    </small></p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_name" class="required">Summary</label>
                                    <input type="text" class="form-control"
                                           placeholder="Enter Recipe summary" name="summary" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="servings" class="required">Servings</label>
                                    <input type="text" class="form-control"
                                           placeholder="Servings" name="servings" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cuisines" class="required">Cuisines</label>
                                    <select name="cuisines" class="form-control select2" required>
                                        <option value="" selected disabled>select cuisine</option>
                                        <?php
                                        $q = "SELECT * FROM `cuisines` ORDER BY id DESC";
                                        $result = $db->select($q);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status"
                                           id="add_status" checked>
                                    <label class="form-check-label" for="add_status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="post" id="edit_form">
        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Edit Recipe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_name" class="required">Title</label>
                                    <input type="text" class="form-control"
                                           placeholder="Enter Recipe Title" name="title" id="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ready_in_minutes" class="required">Ready in Minutes</label>
                                    <input type="number" class="form-control"
                                           placeholder="Enter Time"
                                           name="ready_in_minutes"
                                           min="0"
                                           required
                                           id="ready_in_minutes"
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Recipe Image</label>
                                <div class="custom-file">
                                    <input type="file" class="" name="image">
                                </div>
                                <p>
                                    <small class="cr-file-description">
                                        image size should be less than 2mb
                                    </small></p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_name" class="required">Summary</label>
                                    <input type="text" class="form-control"
                                           placeholder="Enter Recipe summary" name="summary"
                                           id="summary" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="servings" class="required">Servings</label>
                                    <input type="text" class="form-control"
                                           placeholder="Servings" name="servings" id="servings" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cuisines" class="required">Cuisines</label>
                                    <select name="cuisines" id="cuisines"
                                            class="form-control select2" required>
                                        <option value="" selected disabled>select cuisine</option>
                                        <?php
                                        $q = "SELECT * FROM `cuisines` ORDER BY id DESC";
                                        $result = $db->select($q);
                                        foreach ($result as $row) {
                                            ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status"
                                           id="edit_status" checked>
                                    <label class="form-check-label" for="edit_status">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="old_image" id="old_image">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Main Footer -->
    <?php
    include "include/footer.php"; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php
include "include/js.php"; ?>
<script>
    $(document).ready(function () {
        loadData();

        $('#search_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "api/search_recipe.php",
                data: new FormData(this),
                contentType: false,
                data_type: 'json',
                cache: false,
                processData: false,
                beforeSend: function () {
                    loader();
                },
                success: function (response) {
                    swal.close();
                    $('#table_div').html(response);
                    $('#td').DataTable({
                        "order": [[0, "desc"]],
                        "bDestroy": true,
                    });
                },
                error: function (xhr, error, status) {
                    swal.close();
                    var response = xhr.responseJSON;
                    console.log(status);
                }
            });
        });

        $('#edit_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "api/update_recipe.php",
                data: new FormData(this),
                contentType: false,
                data_type: 'json',
                cache: false,
                processData: false,
                beforeSend: function () {
                    loader();
                },
                success: function (response) {
                    var response = JSON.parse(response);
                    swal.close();
                    alertMsg(response.status, response.message);
                    loadData();
                    $('#edit_modal').modal('toggle');
                },
                error: function (xhr, error, status) {
                    var response = xhr.responseJSON;
                    //console.log(response);
                }
            });
        });
    })
    $(document).on('click', '.edit_btn', function () {

        $('#id').val($(this).data('id'));
        $('#title').val($(this).data('title'));
        $('#ready_in_minutes').val($(this).data('ready-in-minutes'));
        $('#old_image').val($(this).data('image'));
        $('#summary').val($(this).data('summary'));
        $('#servings').val($(this).data('servings'));
        $('#cuisines').val($(this).data('cuisines')).trigger('change');
        let status = $(this).data('status');

        if (status == 1) {
            $('#edit_status').attr('checked', true);
        } else {
            $('#edit_status').attr('checked', false);
        }

        $('#edit_modal').modal('show');
    });

    $(document).on('click', '.delete_btn', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "api/delete_recipe.php",
                    data: {
                        id: id,
                        delete_data: true
                    },
                    beforeSend: function () {
                        loader();
                    },
                    success: function (response) {
                        var response = JSON.parse(response);
                        swal.close();
                        alertMsg(response.status, response.message);
                        loadData();
                    }
                });
            }
        })

    });
    $(document).on('click', '.favourite_btn', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            type: 'POST',
            url: "api/favourite_recipe.php",
            data: {
                id: id,
                status: status,
            },
            beforeSend: function () {
                loader();
            },
            success: function (response) {
                var response = JSON.parse(response);
                swal.close();
                alertMsg(response.status, response.message);
                loadData();
            },
            error: function (xhr, error, status) {
                var response = xhr.responseJSON;
                //console.log(response);
            }
        });
    });
    function loadData() {
        $.ajax({
            type: 'POST',
            url: "api/load_recipe_list.php",
            success: function (response) {
                $('#table_div').html(response);
                $('#td').DataTable({
                    "order": [[0, "desc"]],
                    "bLengthChange": false,
                    searching: false,
                    "bDestroy": true,
                });
            }
        });
    }
</script>
</body>
</html>
