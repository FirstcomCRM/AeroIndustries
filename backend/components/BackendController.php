<?php    
namespace backend\components;
use Yii;

class BackendController extends \yii\web\Controller
{
    public function init(){
        parent::init();

    }
    public function Hello(){
        return "Hello Yii2";
    }
}