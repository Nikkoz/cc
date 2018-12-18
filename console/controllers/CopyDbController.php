<?php

namespace console\controllers;


use core\helpers\copy\PostsHelper;
use yii\console\Controller;
use core\helpers\copy\RestHelper;
use yii\helpers\Console;

class CopyDbController extends Controller
{
    private $_limit = 3;

    public function actionIndex(string $type = 'post')
    {
        $page = 0;

        switch ($type) {
            case 'post':
                //do {
                    $result = PostsHelper::getPosts($this->_limit, $page);

                    /*foreach($result as $type=>$posts) {

                    }

                    $page++;*/
                //} while($result);

                break;
        }

        $this->stdout('<pre>'.print_r($result,1).'</pre>', Console::FG_GREEN);
        $this->stdout("\n");
    }
}