<?php
namespace Models;


class Score extends Model
{
    protected $table = 'scores';
    public function topScores()
    {
        $sql = sprintf('SELECT * FROM %s ORDER BY score DESC', $this->table);
        $pdoSt = $this->cn->query($sql);

        return $pdoSt->fetchAll();
    }
}