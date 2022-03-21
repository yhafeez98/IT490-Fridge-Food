<?php

require "../db/config.php";
require "../include/api_session_check.php";
$user = $_SESSION['auth'];

$title = isset($_POST['title']) && !empty(trim($_POST['title'])) ? trim($_POST['title']) : null;
$cuisines = isset($_POST['cuisines']) && !empty(trim($_POST['cuisines'])) ? trim($_POST['cuisines']) : null;
$servings = isset($_POST['servings']) && !empty(trim($_POST['servings'])) ? trim($_POST['servings']) : null;
$ready_in_minutes = isset($_POST['ready_in_minutes']) && !empty(trim($_POST['ready_in_minutes'])) ? trim(
    $_POST['ready_in_minutes']
) : null;


$q = "SELECT * FROM `recipes`";

if (!is_null($title) || !is_null($cuisines) || !is_null($servings) || !is_null($ready_in_minutes)) {
    $q .= " WHERE";
}

if (!empty($title)) {
    $small_title = strtolower($title);
    $capital_title = strtoupper($title);
    $q .= " (title LIKE '%$title%' OR  title LIKE '%$small_title%' OR  title LIKE '%$capital_title%')";
}

if (!is_null($cuisines)) {
    if (!is_null($title)) {
        $q .= " AND";
    }

    $q .= " cuisines = '$cuisines'";
}

if (!is_null($servings)) {
    if (!is_null($title) || !is_null($cuisines)) {
        $q .= " AND";
    }
    $q .= " servings = '$servings'";
}
if (!is_null($ready_in_minutes)) {
    if (!is_null($title) || !is_null($cuisines) || !is_null($servings)) {
        $q .= " AND";
    }
    $q .= " ready_in_minutes = '$ready_in_minutes'";
}
if (!is_null($title) || !is_null($cuisines) || !is_null($servings) || !is_null($ready_in_minutes)) {
    $q .= " AND";
}
$q .= " user_id=$user->id";
//echo $q;
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
                        <button class="btn btn-danger btn-sm text-white delete_btn mr-2"
                                data-id="<?= $row->id ?>">Delete
                        </button>
                        <button class="btn btn-success btn-sm text-white delete_btn mr-2"
                                data-id="<?= $row->id ?>">Add To Favourite
                        </button>
                    </div>
                </th>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
</div>
