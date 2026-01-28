<?php
class PDOModel
{
    protected $host;
    protected $dbname;
    protected $user;
    protected $pass;
    protected $pdo;

    public function __construct()
    {
        try {
            if (!extension_loaded('pdo')) {
                throw new Exception('PDO extension is not loaded.');
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        try {
            $this->getEnv();
        } catch (Exception $e) {
            die('Erreur lors de la lecture du fichier .env : ' . $e->getMessage());
        }

        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public function getEnv()
    {
        $envFile = __DIR__ . '/../../assets/config/.env';
        $env = [];

        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    [$key, $value] = explode('=', $line, 2);
                    $env[trim($key)] = trim($value);
                }
            }
        }

        $this->host = $env['DB_HOST'];
        $this->dbname = $env['DB_DATABASE'];
        $this->user = $env['DB_USERNAME'];
        $this->pass = $env['DB_PASSWORD'];
    }

    public function destroy()
    {
        $this->pdo = null;
    }
}
