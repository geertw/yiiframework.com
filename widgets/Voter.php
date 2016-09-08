<?php
/**
 * Created by PhpStorm.
 * User: cebe
 * Date: 08.09.16
 * Time: 19:22
 */

namespace app\widgets;


use app\models\Rating;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This widget prints up/down voting buttons for a model.
 */
class Voter extends Widget
{
    /**
     * @var ActiveRecord
     */
    public $model;

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Voter widget property model is not set.');
        }
    }

    public function run()
    {
        // TODO check user login
        // TODO send not logged in user to login and after login redirect back here

        list($total, $up) = Rating::getVotes($this->model);
        $modelClass = $this->model->formName();
        $modelId = $this->model->primaryKey;

        $html = '';
        $html .= '<div class="voting">';

        $html .= '  <span class="votes-up">';
        $html .= '    <span class="votes">' . $up . '</span> ';
        $html .= Html::a('<i aria-label="Vote Up" title="Vote Up" class="thumbs-up"></i>', '', [
            'data-vote-url' => Url::to(['/ajax/vote', 'type' => $modelClass, 'id' => $modelId, 'vote' => 1])
        ]);
        $html .= '    </span>';
        $html .= '  </span>';

        $html .= '  <span class="votes-down">';
        $html .= '    <span class="votes">' . ($total - $up) . '</span> ';
        $html .= Html::a('<i aria-label="Vote Down" title="Vote Down" class="thumbs-down"></i>', '', [
            'data-vote-url' => Url::to(['/ajax/vote', 'type' => $modelClass, 'id' => $modelId, 'vote' => 0])
        ]);
        $html .= '    </span>';
        $html .= '  </span>';

        $html .= '</div>';

        return $html;
    }
} 