<?php

namespace Classes;

use PDO;

abstract class ConnectDb
{
    const HOST = 'localhost';
    const DB_NAME = 'custom_blog';
    const USER = 'root';
    const PASSWORD = 'dimidi19';
    const CHARSET = 'utf8';

    public static function getConnect()
    {
        if (!self::connectDb()) {
            self::connectDb();
            self::getConnect();
        }
        return self::connectDb();
    }

    private static function connectDb()
    {
        return new PDO(
            'mysql:host=' . self::HOST . ';
            dbname=' . self::DB_NAME . '; charset=' . self::CHARSET,
            self::USER,
            self::PASSWORD
        );
    }
}