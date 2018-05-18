<?php require_once 'header.php'; ?>
<?php
if (isset($_POST['log'])) {
    $userManager->auth($_POST);
    exit;
}
?>
<br>
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
            <?php if (getErrorMessage()): ?>
                <div class="text-danger">

                    <?php echo getErrorMessage(); ?>
                </div>
            <?php endif; ?>
            <?php $_SESSION['error_message'] = false; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label style="margin-left: 40%">Login
                        <input class="form-control" name="login" value="<?= $_POST['login']??''?>" autofocus required type="text"
                               placeholder="Enter login">
                    </label>
                </div>
                <div class="form-group">
                    <label style="margin-left: 40%">Password
                    <input class="form-control" name="password" type="password" placeholder="Password">
                    </label>
                </div>

                <button class="btn btn-primary " style="margin-left: 45%" name="log">Login</button>
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="signUp.php">Register an Account</a>
            </div>
        </div>
    </div>
</div>

</body>


<?php require_once 'footer.php' ?>
