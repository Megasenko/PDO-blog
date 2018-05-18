<?php require_once 'header.php' ?>

<?php
if (isset($_POST['update'])) {
    $userManager->updateRole($_POST, $_GET['id']);
    header('Location: /admin/users.php');
    exit;
} ?>

    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/main.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Update role</li>
        </ol>

        <?php $user=$userManager->getUser($_GET['id']);
        if ($user): ?>

        <!-- Example DataTables Card-->
        <div class="row">
            <div class="col-12">
                 <form method="post" action="">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="container">
                                    User name*:
                                    <br>
                                    <input size="50px" type="text" name="name" value="<?= $user->name; ?>" class="form-control"
                                           >
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="container">
                                    Role (1-admin , 2-moderator , 3-user) :
                                    <br>
                                    <input size="50px" type="text" name="role" value="<?= $user->role; ?>" autofocus required class="form-control">
                                </label>
                            </div>
                        </div>
                    </div>



                    <button style="margin: 15px" type="submit" name="update" class="btn btn-success">Обновить запись
                    </button>
                </form>
            </div>

            <?php else: ?>
                <p>Article not found!</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- /.container-fluid-->

<?php require_once 'footer.php' ?>