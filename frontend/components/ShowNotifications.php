<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;

class ShowNotifications extends Widget
{
    public $data;
    public $columns;
    public function init() {
        // your logic here
        parent::init();
        $this->data = $this->data->getModels();
        $this->columns = $this->columns;
    }
    public function run(){
        // you can load & return the view or you can return the output variable
        return $this->render('viewShowNotifications', [
            'models' => $this->data,
            'columns' => $this->columns
        ]);
    }


}