<?php
namespace Controllers;

use Models\Score;

/**
 * Class ScoreController
 * @package Controllers
 */
class ScoreController extends Controller
{
    /**
     * @var Score|null
     */
    private $score_model = null;

    /**
     * ScoreController constructor.
     */
    public function __construct(Score $score)
    {
        $this->score_model = $score;
    }

    /**
     * @return array
     */
    public function index()
    {
        return $this->score_model->topScores();
    }

    /**
     * @return array
     */
    public function store()
    {
        if (!isset($_POST['score'])) {
            return ['error' => 'la requête est incomplète'];
        }
        $fields = [];
        $fields['score'] = intval($_POST['score']);
        if ($this->score_model->save($fields)) {
            return ['success' => 'le score a bien été enregistré'];
        } else {
            return ['error' => 'échec lors de l’écriture dans la base de données'];
        }
    }
}
