<?php
/**
 * Created by PhpStorm.
 * User: megas
 * Date: 16.05.18
 * Time: 22:25
 */

namespace Classes;

use PDO;

class User
{
    /**
     * @var \PDO $connect
     */
    private $connect;

    /**
     * User constructor.
     *
     * @param $connect
     */
    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    /**
     * Выбор всех пользователей из базы
     * @return array
     */
    public function getUsers()
    {
        if ($this->connect) {
            $sql = "SELECT *
                FROM users
                ";

            return $this->connect->query($sql)->fetchAll(PDO::FETCH_OBJ);
        }
    }

    /**
     * Добавление пользователей в базу при регистрации
     * @return bool
     */
    public function insertUser($userData)
    {

        if ($this->connect) {
            $role = 3;
            $password = md5($userData['password']);
            $sql = "INSERT INTO users(name, last_name, login , email , password, role)
        VALUES ( :name, :last_name , :login , :email , :password , :role)";

            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':name', $userData['name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $userData['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':login', $userData['login'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $userData['email'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            return $stmt->execute();
        }
    }


    /**
     * Регистрация пользователей
     * @param array $userData
     * @return bool|void
     */
    public function registerUser(array $userData)
    {


        if (!isset($userData['login']) || empty ($userData['login'])) {
            $_SESSION['error_message'] = 'Login can not be empty';
            return;
        }
        if (!isset($userData['email']) || empty ($userData['email'])) {
            $_SESSION['error_message'] = 'Email can not be empty';
            return;
        }
        if (!isset($userData['password']) || empty ($userData['passwordConfirm'])) {
            $_SESSION['error_message'] = 'Password can not be empty';
            return;
        }
        if ($userData['password'] !== $userData['passwordConfirm']) {
            $_SESSION['error_message'] = 'Inputted passwords not confirm!';
            return;
        }

        if ($this->insertUser($userData)) {
            $_SESSION['error_message'] = false;
            return true;
        } else {
            $_SESSION['error_message'] = 'Register user not complete';

        }

    }


    /**
     * Извлечение пользователя с базы по логину
     * @param array $userData
     * @return array
     *
     */
    function getLogin(array $userData)
    {


        $sql = 'SELECT * FROM users WHERE login = :login';

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':login', $userData['login'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Вход пользователя на сайт и добавление значений в сессию
     * @param array $userData
     *
     */
    function auth(array $userData)
    {
        $_SESSION['access'] = false;
        if (!isset($userData['login']) || empty ($userData['login'])) {
            $_SESSION['error_message'] = 'Login can not be empty';
            return;
        }
        if (!isset($userData['password']) || empty ($userData['password'])) {
            $_SESSION['error_message'] = 'Password can not be empty';
            return;
        }
        if ($this->getLogin($userData)) {
            $rows = $this->getLogin($userData);
            if (count($rows) > 0) {
                if (md5($userData['password']) == $rows[0]['password']) {
                    if ($rows[0]['login'] === 'admin') {
                        $_SESSION['access'] = true;
                        $role = $rows[0]['role'] * 1;
                        $_SESSION['role'] = $role;
                        $_SESSION['author'] = $rows[0]['id'];
                        $_SESSION['login'] = $rows[0]['login'];
                        $_SESSION['email'] = $rows[0]['email'];
                        $_SESSION['name'] = $rows[0]['name'];
                        header('Location:/admin/main.php');
                        exit;
                    } else {
                        $_SESSION['access'] = true;
                        $_SESSION['role'] = $rows[0]['role'];
                        $_SESSION['author'] = $rows[0]['id'];
                        $_SESSION['login'] = $rows[0]['login'];
                        $_SESSION['name'] = $rows[0]['name'];
                        $_SESSION['email'] = $rows[0]['email'];
                        header('Location:/');
                        exit;
                    }

                } else {
                    $_SESSION['error_message'] = 'You entered the wrong password ';
                }
            }
        } else {
            $_SESSION['error_message'] = 'Логин <b>' . $userData['login'] . '</b> не найден!';

        }


    }

    /**
     *  Удаление пользователя
     * @param $id
     * @return bool
     */
    function deleteUser($id)
    {

        if ($this->connect) {
            $sql = "DELETE FROM users WHERE id=$id";

            return $this->connect->prepare($sql)->execute();
        }

        return false;
    }

    /**
     * обновление информации о пользователе или установка роли
     * @param $userData
     * @param $id
     * @return bool
     *
     */
    function updateRole($userData, $id)
    {

        if ($this->connect) {

            $role = $userData['role'];

            $sql = "UPDATE users SET role=$role WHERE id='$id'";

            return $this->connect->prepare($sql)->execute();
        }
        return false;


    }


    /**
     * Выбор одного пользователя по id
     * @param $id
     * @return array
     *
     */
    function getUser($id)
    {

        if ($this->connect) {
            $sql = "SELECT *
            FROM users WHERE id='$id'";
            return $this->connect->query($sql)->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * Доступ на страничку только админу
     */
    public function accessAdmin()
    {
        if ($_SESSION['role'] !== 1) {
            header('Location: /');
            exit;
        }
    }
}