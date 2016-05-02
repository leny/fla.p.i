<?php
namespace Models;


/**
 * Class Score
 * @package Models
 */
class Score extends Model
{
    /**
     * @var string
     */
    protected $table = 'scores';

    /**
     * @return array
     */
    public function topScores()
    {
        $sql = sprintf('SELECT * FROM %s ORDER BY score DESC', $this->table);
        $pdoSt = $this->cn->query($sql);

        return $pdoSt->fetchAll();
    }
}