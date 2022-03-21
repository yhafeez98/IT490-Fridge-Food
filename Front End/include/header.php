<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php
        if (isset($_SESSION['login_status']) && $_SESSION['login_status']) { ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    Logout
                </a>
            </li>
            <?php
        } ?>

    </ul>
</nav>
