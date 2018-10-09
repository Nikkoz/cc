<?php

namespace core\forms\manage;


use core\entities\Formula;
use yii\base\Model;

/**
 * Class FormulaForm
 * @package core\forms\manage
 *
 * @property integer $news_max_val
 * @property integer $news_max_count
 * @property integer $community_max_val
 * @property integer $community_max_count
 * @property integer $developers_max_val
 * @property integer $developers_max_count
 * @property integer $exchanges_max_val
 * @property integer $exchanges_max_count
 */
class FormulaForm extends Model
{
    public $news_max_val;
    public $news_max_count;
    public $community_max_val;
    public $community_max_count;
    public $developers_max_val;
    public $developers_max_count;
    public $exchanges_max_val;
    public $exchanges_max_count;

    public function __construct(Formula $formula = null, array $config = [])
    {
        if($formula) {
            $this->news_max_val = $formula->news_max_val;
            $this->news_max_count = $formula->news_max_count;
            $this->community_max_val = $formula->community_max_val;
            $this->community_max_count = $formula->community_max_count;
            $this->developers_max_val = $formula->developers_max_val;
            $this->developers_max_count = $formula->developers_max_count;
            $this->exchanges_max_val = $formula->exchanges_max_val;
            $this->exchanges_max_count = $formula->exchanges_max_count;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['news_max_val', 'news_max_count', 'community_max_val', 'community_max_count', 'developers_max_val', 'developers_max_count', 'exchanges_max_val', 'exchanges_max_count'], 'required'],
            [['news_max_val', 'news_max_count', 'community_max_val', 'community_max_count', 'developers_max_val', 'developers_max_count', 'exchanges_max_val', 'exchanges_max_count'], 'integer']
        ];
    }
}