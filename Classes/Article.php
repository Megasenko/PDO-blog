<?php

namespace Classes;

use PDO;
use DateTime;

class Article
{
    /**
     * @var \PDO $connect
     */
    private $connect;

    /**
     * Article constructor.
     *
     * @param $connect
     */
    public function __construct($connect)
    {
        $this->connect = $connect;
    }


    /**
     * Создание красивого заголовка
     *
     */
    function viewTitle()
    {
        $arr = explode('.', $_SERVER['REQUEST_URI']);
        $str = substr($arr[0], 1);
        if ($str) {
            echo 'PDO Blog - ' . ucfirst($str);
        } else {
            echo 'PDO Blog';
        }
    }

    /**
     * Получение всех статей
     * Get Articles
     *
     * @return array|bool
     */
    public function getArticles()
    {
        if ($this->connect) {
            $sql = "SELECT *
                FROM articles
                ";

            return $this->connect->query($sql)->fetchAll(PDO::FETCH_OBJ);
        }

        return false;
    }

    /**
     * Получение автора по Id
     * @param $id
     * @return bool|mixed
     */
    public function getAuthor($id)
    {
        if ($this->connect) {
            $sql = "SELECT *
                FROM users
                WHERE id='$id'
                ";

            return $this->connect->query($sql)->fetch(PDO::FETCH_OBJ);
        }

        return false;
    }

    /**
     * Получение статьи по URl адрессу
     * @param $url
     * @return mixed
     */
    public function getArticle($url)
    {

        if ($this->connect) {
            $sql = "SELECT *
            FROM articles WHERE url='$url'
            ";

            return $this->connect->query($sql)->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * Удаление статьи
     * @param $url
     * @return bool
     */
    function deleteArticle($url)
    {

        if ($this->connect) {
            $sql = "DELETE FROM articles WHERE url='$url'";

            return $this->connect->prepare($sql)->execute();
        }

        return false;
    }

    /**
     * Обновление статьи
     * @param $dataArticle
     * @param $urlArticle
     * @return bool
     */
    function updateArticle($dataArticle, $urlArticle)
    {

        if ($this->connect) {
            $title = strip_tags(trim($dataArticle['title']));
            $sub_title = strip_tags(trim($dataArticle['sub_title']));
            $content = strip_tags(trim($dataArticle['content']));
            $role = strip_tags(trim($dataArticle['role']));

            $sql = "UPDATE articles SET title='$title',sub_title='$sub_title',content='$content',
              role=$role WHERE url='$urlArticle'";

            return $this->connect->prepare($sql)->execute();
        }
        return false;
    }

    /**
     * Добавление статьи в базу
     * @param $dataArticle
     * @return bool
     */
    function insertArticle($dataArticle)
    {

        if ($this->connect) {
            $sql = "INSERT INTO articles(title , sub_title , content , created_at , url , author , role)
            VALUES ( :title , :sub_title , :content , :created_at , :url , :author , :role)";

            $stmt = $this->connect->prepare($sql);


            $datetime = new DateTime();
            $createdAt = $datetime->format('Y-m-d H:i:s');
            $url = $this->getUrl($dataArticle['title']);
            $author = $this->getAuthorArticle();
            $role = 1;

            $stmt->bindValue(':title', strip_tags(trim($dataArticle['title'])), PDO::PARAM_STR);
            $stmt->bindValue(':sub_title', strip_tags(trim($dataArticle['sub_title'])), PDO::PARAM_STR);
            $stmt->bindValue(':content', strip_tags(trim($dataArticle['content'])), PDO::PARAM_STR);
            $stmt->bindValue(':created_at', $createdAt, PDO::PARAM_STR);
            $stmt->bindValue(':url', $url, PDO::PARAM_STR);
            $stmt->bindValue(':author', $author, PDO::PARAM_STR);
            $stmt->bindValue(':role', $role, PDO::PARAM_STR);

            return $stmt->execute();
        }
        return false;
    }


    /**
     * автор для статьи
     * @return mixed
     */
    function getAuthorArticle()
    {

        if ($this->connect) {
            $a = $_SESSION['login'];
            $sql = "SELECT id
                FROM users
                WHERE login='$a'
                ";

            $row = $this->connect->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        }


    }

    /**
     * генерируем URL
     * @param $str
     * @return mixed|string
     */
    function getUrl($str)
    {
        $articleUrl = str_replace(' ', '-', $str);
        $articleUrl = transliteration($articleUrl);
        $articleIsset = $this->getArticleByUrl($articleUrl);
        if (!$articleIsset) {
            return $articleUrl;
        } else {
            $url = $articleIsset['url'];
            $exUrl = explode('-', $url);
            if ($exUrl) {
                $temp = (int)end($exUrl);
                $newUrl = $exUrl[0] . '-' . ++$temp;
            } else {
                $temp = 0;
                $newUrl = $articleUrl . '-' . ++$temp;
            }

            return $this->getUrl($newUrl);
        }
    }


    /**
     *  перевод тектса
     * @param $str
     * @return string
     */
    function transliteration($str)
    {
        $st = strtr($str,
            array(
                'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
                'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
                'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
                'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
                'ф' => 'ph', 'х' => 'h', 'ы' => 'y', 'э' => 'e', 'ь' => '',
                'ъ' => '', 'й' => 'y', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh',
                'щ' => 'sh', 'ю' => 'yu', 'я' => 'ya', ' ' => '_', '<' => '_',
                '>' => '_', '?' => '_', '"' => '_', '=' => '_', '/' => '_',
                '|' => '_'
            )
        );
        $st2 = strtr($st,
            array(
                'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd',
                'Е' => 'e', 'Ё' => 'e', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i',
                'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o',
                'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
                'Ф' => 'ph', 'Х' => 'h', 'Ы' => 'y', 'Э' => 'e', 'Ь' => '',
                'Ъ' => '', 'Й' => 'y', 'Ц' => 'c', 'Ч' => 'ch', 'Ш' => 'sh',
                'Щ' => 'sh', 'Ю' => 'yu', 'Я' => 'ya'
            )
        );
        $translit = $st2;

        return $translit;
    }


    /**
     * получение статьи по URL
     * @param $str
     * @return bool|mixed
     *
     */
    function getArticleByUrl($str)
    {

        if ($this->connect) {
            $sql = "SELECT *
                FROM articles
                WHERE url='$str'
                ";

            return $this->connect->query($sql)->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }


    /**
     * поиск статьи по запросу пользователя
     * @param $search
     * @return array
     */
    function getArticleByUser($search)
    {
        $search = "%$search%";

        if ($this->connect) {
            $stm = $this->connect->prepare("SELECT * FROM articles WHERE (title LIKE '$search') 
                              OR (sub_title LIKE '$search') OR (content LIKE '$search')");
            $stm->execute(array($search));
            return $stm->fetchAll();
        }

    }


    /**
     * вывод статей по роли пользователя
     * @param $role
     * @return mixed
     */
    function getArticlesRole($role)
    {

        if ($this->connect) {
            $sql = "SELECT *
                FROM articles WHERE role='$role'";

            return $this->connect->query($sql)->fetchAll(PDO::FETCH_OBJ);
        }
    }

}


