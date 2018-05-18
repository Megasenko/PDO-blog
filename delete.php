<?php require_once 'header.php' ?>
<?php
require_once 'adminAccess.php';
?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto col-md-10-offset-1" >
                    <div style="margin-top:60px " class="container">
                        <h1 class="text-danger">Delete article</h1>
                        <?php if (getArticle($_GET)):?>
                            <?php foreach (getArticle($_GET) as $article): ?>
                                <div>
                                    <form method="post" action="">
                                        <label class="container">
                                            Заголовок
                                        </label>
                                        <input  size="80px" type="text" name="title" value="<?= $article['title']; ?>" class="form-item" >
                                        <label class="container">
                                            Краткое описание
                                        </label>
                                        <input size="80px" type="text" name="sub_title" value="<?= $article['sub_title']; ?>" class="form-item">
                                        <label class="container">
                                            Содержимое статьи
                                        </label>
                                        <textarea rows="10" cols="81" type="text" name="content"  class="form-item" ><?= $article['content']; ?></textarea>
                                        <label class="container">
                                            Дата создания
                                        </label>
                                        <input   type="text" name="created_at" value="<?= $article['created_at']; ?>" class="form-item" >
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
                                                 class="form-item" >
                                        <br>
                                        <button  style="margin: 15px" name="delete" class="btn btn-danger"
                                           >Delete article</button>
                                    </form>
                                </div>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <h4 class="text-danger">Article deleted!</h4>
                        <br>
                        <a style="margin-bottom: 25px ; text-align: center" href="adminPanel.php" class="btn btn-info">Back to Admin panel</a>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </header>
<?php
if ($_GET['url']) {
    deleteArticle($_GET['url']);
}?>
<?php require_once 'footer.php' ?>