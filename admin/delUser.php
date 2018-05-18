<?php
require_once '../functions.php';

if (!isset ($_SESSION['role']) && $_SESSION['role'] !== 1) {
    header('Location:/');
}
if (isset($_GET['action']) && $_GET['action'] === 'del' && isset($_GET['id'])) {
    if ($userManager->deleteUser($_GET['id'])) {
        header('Location:/admin/users.php');
    }
} else {
    var_dump($_GET['action']);
    echo 'Что то пошло не так';
}
