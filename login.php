<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Shared Todos</title>
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
        <div class="is-centered">
        <h1 class="title">Login to Study Tracker</h1>
        </div>

        <div class="columns is-centered">
            <div class="column is-one-third">
                <div class="box">
                    <form action="./backend/login_controller.php" method="post">
                        <div class="field">
                            <label class="label">Username</label>
                            <div class="control">
                                <input class="input" type="text" name="username" placeholder="Enter your username">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password" placeholder="Enter your password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Login</button>
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