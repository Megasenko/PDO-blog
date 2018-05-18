<?php
require_once '../functions.php' ;

if (!isset ($_SESSION['role']) && $_SESSION['role'] !== 1) {
    header('Location:/');
}
if (isset($_GET['action']) && $_GET['action']==='del'  && isset($_GET['url']) ){
    $articleManager->deleteArticle($_GET['url']);
    header('Location:/admin/articles.php');
} else {
    echo 'Что то пошло не так';
}

