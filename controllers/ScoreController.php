<?php
namespace Controllers;

use Models\Score;

class ScoreController extends Controller
{
    private $score_model = null;

    /**
     * ScoreController constructor.
     */
    public function __construct(Score $score)
    {
        $this->score_model = $score;
    }

    public function index()
    {
        return $this->score_model->topScores();
    }

    public function store()
    {
        if (!isset($_POST['score']) || !isset($_POST['username'])) {
            return ['error' => 'la requête est incomplète'];
        }
        $fields = [];
        $fields['score'] = intval($_POST['score']);
        $fields['username'] = $_POST['username'];
        if ($this->score_model->save($fields)) {
            return ['success' => 'le score a bien été enregistré'];
        } else {
            return ['error' => 'échec lors de l’écriture dans la base de données'];
        }
    }
}