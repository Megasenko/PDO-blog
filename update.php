<?php require_once 'header.php' ?>
<?php
if (!isset ($_SESSION['access']) && ($_SESSION['role'] !== 1 || $_SESSION['role'] !== 3)) {
    header('Location: /access_denied.php');
    exit;
}
?>
<?php
if ($_POST) {
    updateArticle($_POST, $_GET['url']);
    header('Location:post.php?url='.$_POST['url']);
}

?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto col-md-10-offset-1" >
                    <div style="margin-top:60px " class="container">
                        <h1 class="text-warning">Update article</h1>


                        <?php if (getArticle($_GET)):?>
                            <?php foreach (getArticle($_GET) as $article): ?>
                        <div>

                            <form method="post" action="">
                                <label class="container">
                                    Заголовок
                                </label>
                                <input  size="80px" type="text" name="title" value="<?= $article['title']; ?>" class="form-item" autofocus required>
                                <label class="container">
                                    Краткое описание
                                </label>
                                <input size="80px" type="text" name="sub_title" value="<?= $article['sub_title']; ?>" class="form-item">
                                <label class="container">
                                    Содержимое статьи
                                </label>
                                <textarea rows="10" cols="81" type="text" name="content" class="form-item" required><?= $article['content']; ?></textarea>
                                <label class="container">
                                    Дата создания
                                </label>
                                <input   type="text" name="created_at" value="<?= $article['created_at']; ?>" class="form-item" required>
                                <label class="container">
                                    Ссылка на страницу
                                </label>
                                <input  type="text" name="url" value="<?= $article['url']; ?>" class="form-item">
                                <label class="container">
                                    Автор
                                </label>
                                <!--                                placeholder="-->
                                <?php //echo $_SESSION['name'] ?><!--"-->
                                <input   type="text" name="author" value="<?= $article['author']; ?>"
                                       class="form-item" required>
                                <br>
                                <button style="margin: 15px" type="submit" name="update" class="btn btn-warning">
                                    Update article
                                </button>
                            </form>
                        </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Article not found!</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <a style="margin-left:100px" href="/" class="btn btn-info" >Back to articles</a>
<?php require_once 'footer.php' ?>