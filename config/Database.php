<?php
class Database {
    private static $host = 'localhost';
    private static $db_name = 'bancophp';
    private static $username = 'root';
    private static $password = '';
    private static $conn;

    public static function conectar() {
        self::$conn = null;
        try {
            self::$conn = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$db_name . ';charset=utf8', self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
        }
        return self::$conn;
    }
}
?>