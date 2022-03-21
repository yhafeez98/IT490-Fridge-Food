<?php

require "../db/config.php";
require "../include/api_session_check.php";
$auth = $_SESSION['auth'];


$q = "SELECT * FROM `recipes` where user_id=$auth->id";

$result = $db->select($q);
?>
<div class="table-responsive">
    <table class="table table-bordered" id="td">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Image</th>
            <th>Ready In Minutes</th>
            <th>Servings</th>
            <th>Cuisines</th>
            <th>Favourite</th>
            <th>status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($result as $row) {
            $cuisines = $db->find_data("SELECT * FROM `cuisines` WHERE id=$row->cuisines");
            $is_favourite = $db->rowsCount(
                "SELECT * FROM `favourite_recipe` WHERE recipe_id=$row->id AND user_id=$auth->id"
            );
            ?>
            <tr>
                <td><?= $row->id ?></td>
                <td><?= $row->title ?></td>
                <td><img src="<?= $row->image ?>" alt="img" style="height: 100px"></td>
                <td><?= $row->ready_in_minutes ?></td>
                <td><?= $row->servings ?></td>
                <td><?= $cuisines->name ?></td>
                <td>
                    <?php
                    if ($is_favourite != 0) {
                        $favourite_recipe = $db->find_data(
                            "SELECT * FROM `favourite_recipe` WHERE recipe_id=$row->id AND user_id=$auth->id"
                        );
                        ?>
                        <button class="btn btn-success btn-sm text-white favourite_btn"
                                data-id="<?= $favourite_recipe->id ?>"
                                data-status="remove"
                        >Yes
                        </button>
                        <?php
                    } else {
                        ?>
                        <button class="btn btn-secondary btn-sm text-white favourite_btn"
                                data-id="<?= $row->id ?>"
                                data-status="add"
                        >No
                        </button>
                        <?php
                    } ?>
                </td>
                <td><?= $row->status ?></td>
                <th>
                    <div class="btn-group">
                        <button class="btn btn-info btn-sm text-white edit_btn ml-2"
                                data-id="<?= $row->id ?>"
                                data-title="<?= $row->title ?>"
                                data-ready-in-minutes="<?= $row->ready_in_minutes ?>"
                                data-image="<?= $row->image ?>"
                                data-summary="<?= $row->summary ?>"
                                data-servings="<?= $row->servings ?>"
                                data-cuisines="<?= $row->cuisines ?>"
                                data-status="<?= $row->status ?>"
                        >
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm text-white delete_btn"
                                data-id="<?= $row->id ?>">Delete
                        </button>
                    </div>
                </th>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
</div>
