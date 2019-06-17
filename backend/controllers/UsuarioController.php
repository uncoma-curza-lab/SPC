<?php

namespace backend\controllers;

use yii\rest\ActiveController;

class UsuarioController extends ActiveController
{
    public $modelClass = 'backend\models\Status';
    function index () {
        return "Hola";
    }

}
