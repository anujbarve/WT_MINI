<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            Study Tracker
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
    <?php if (isset($_SESSION["UserID"])) : ?>
        <div class="navbar-start">
        <a class="navbar-item" href="rooms.php">
                Rooms
            </a>
        </div>
    <?php endif ?>



        <div class="navbar-end">
            <?php if (isset($_SESSION["UserID"])) : ?>
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary">
                            <strong>Welcome <?php echo $_SESSION["Username"]; ?></strong>
                        </a>
                        <a href="logout.php" class="button is-dark">
                            Log Out
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <div class="navbar-item">
                    <div class="buttons">
                        <a href="register.php" class="button is-primary">
                            <strong>Register</strong>
                        </a>
                        <a href="login.php" class="button is-dark">
                            Log in
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>