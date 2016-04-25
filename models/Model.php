<?php
namespace Models;

/**
 * Class Model
 * @package Model
 */
class Model
{
    /**
     * @var string
     */
    protected $table = '';
    /**
     * @var null|\PDO
     */
    protected $cn = null;

    /**
     * Model constructor.
     * Creates the PDO connection
     */
    public function __construct()
    {
        $dbConfig = parse_ini_file('db.ini');
        $pdoOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try {
            $dsn = sprintf(
                '%s:dbname=%s;host=%s',
                $dbConfig['driver'],
                $dbConfig['dbname'],
                $dbConfig['host']
            );
            $this->cn = new \PDO(
                $dsn,
                $dbConfig['username'],
                $dbConfig['password'],
                $pdoOptions
            );
            $this->cn->exec('SET CHARACTER SET UTF8');
            $this->cn->exec('SET NAMES UTF8');
        } catch (\PDOException $exception) {
            die($exception->getMessage());
        }
    }

    /**
     * Returns everything from a table
     *
     * @return array
     */
    public function all()
    {
        $sql = sprintf('SELECT * FROM %s', $this->table);
        $pdoSt = $this->cn->query($sql);

        return $pdoSt->fetchAll();
    }

    /**
     * Returns a single record from a table
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id = :id', $this->table);
        $pdoSt = $this->cn->prepare($sql);
        $pdoSt->execute([':id' => $id]);

        return $pdoSt->fetch();
    }

    public function save($fields)
    {
        $sFieldsNames = implode('`, `', array_keys($fields));
        $sFieldsJokers = implode(', :', array_keys($fields));
        $sql = sprintf('INSERT INTO %s(`%s`) VALUES(:%s)',
            $this->table,
            $sFieldsNames,
            $sFieldsJokers);
        $pdoSt = $this->cn->prepare($sql);
        foreach (array_keys($fields) as $field) {
            $pdoSt->bindValue(':' . $field, $fields[$field]);
        }
        return $pdoSt->execute();
    }
}