<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shared Todos</title>
    <!-- <link rel="stylesheet" href="./assets/vendor/bulma/css/bulma.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <script src="./main.js"></script>
</head>
<body>
<?php

include './modules/navbar.php';

?>
<section class="section is-medium">
    <div class="container">
        <h1 class="title">Register to Study Tracker</h1>

        <div class="columns is-centered">
            <div class="column is-one-third">
                <div class="box">
                    <form action="./backend/register_controller.php" method="post">
                        <div class="field">
                            <label class="label">Username</label>
                            <div class="control">
                                <input class="input" type="text" name="username" placeholder="Choose a username">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="Choose a password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<?php

include './modules/footer.php';

?>
</body>
</html>
