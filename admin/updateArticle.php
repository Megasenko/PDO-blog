<?php require_once 'header.php' ?>

<?php
if (isset($_POST['update'])) {
    $articleManager->updateArticle($_POST, $_GET['url']);
    header('Location: /admin/articles.php');
    exit;
} ?>

    <div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/main.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Update article</li>
        </ol>

        <?php $article=$articleManager->getArticle($_GET['url']);
        if ($article): ?>

        <!-- Example DataTables Card-->
        <div class="row">
            <div class="col-12">
                <form method="post" action="">
                    <label class="container">
                        Заголовок
                        <input size="101px" type="text" name="title" value="<?= $article->title; ?>" class="form-item"
                               autofocus required>
                    </label>

                    <label class="container">
                        Краткое описание
                        <textarea rows="2" cols="100" type="text" name="sub_title" class="form-item"
                                  required><?= $article->sub_title; ?></textarea>
                    </label>

                    <label class="container">
                        Содержимое статьи
                        <textarea rows="10" cols="100" type="text" name="content" class="form-item"
                                  required><?= $article->content; ?></textarea>
                    </label>

                    <label class="container">
                        Для кого видна статья (1-админ, 2-модератор, 3-пользователь)
                        <input size="101px" type="text" name="role" value="<?= $article->role; ?>" class="form-item"
                               required>
                    </label>

                    <br>
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