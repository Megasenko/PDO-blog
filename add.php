<?php require_once 'header.php' ?>
<?php
if (!isset ($_SESSION['access']) && ($_SESSION['role'] !== 1 || $_SESSION['role'] !== 3)) {
    header('Location: /access_denied.php');
    exit;
}
if (isset($_GET['exit']) == 1) {
    session_destroy();
    header('Location:signIn.php');
    exit;
}
?>

<?php
if ($_POST) {
    insertArticle($_POST);
    if(insertArticle($_POST)){
        header('Location: /?send=1');
    } else {
        echo "Произошла ошибка при отправке";
    }

}

?>
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto col-md-10-offset-1">
                    <div style="margin-top:60px " class="container">
                        <h1 class="text-success">Добавление статьи</h1>
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <form method="post" action="">
                                        <label class="container">
                                            Заголовок
                                            <input size="80px" type="text" name="title" value="" class="form-item"
                                                   autofocus required>
                                        </label>

                                        <label class="container">
                                            Краткое описание
                                            <textarea rows="2" cols="81" type="text" name="sub_title" class="form-item"
                                                      required></textarea>
                                        </label>

                                        <label class="container">
                                            Содержимое статьи
                                            <textarea rows="10" cols="81" type="text" name="content" class="form-item"
                                                      required></textarea>
                                        </label>

                                        <br>
                                        <button style="margin: 15px" type="submit" name="add" class="btn btn-success">
                                            Добавить запись
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


<?php require_once 'footer.php' ?>