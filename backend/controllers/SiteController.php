<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\LoginForm;

use yii\helpers\ArrayHelper;
use common\models\UserGroup;
use common\models\UserPermission;
use yii\web\UploadedFile;
use common\models\WorkOrder;
use common\models\Quotation;
use common\models\Unit;
use common\models\Part;
use common\models\Stock;

use yii\data\ArrayDataProvider;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {   
        $userGroupArray = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');
       
        foreach ( $userGroupArray as $uGId => $uGName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Site'])->andWhere(['user_group_id' => $uGId ] )->all();
            $actionArray = [];
            foreach ( $permission as $p )  {
                $actionArray[] = $p->action;
            }

            $allow[$uGName] = false;
            $action[$uGName] = $actionArray;
            if ( ! empty( $action[$uGName] ) ) {
                $allow[$uGName] = true;
            }

        } 
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => $action['admin'],
                        'allow' => $allow['admin'],
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => $action['engineer'],
                        'allow' => $allow['engineer'],
                        'roles' => ['engineer'],
                    ],
                    [
                        'actions' => $action['mechanic'],
                        'allow' => $allow['mechanic'],
                        'roles' => ['mechanic'],
                    ],
                    [
                        'actions' => $action['purchasing'],
                        'allow' => $allow['purchasing'],
                        'roles' => ['purchasing'],
                    ],
                    [
                        'actions' => $action['quality'],
                        'allow' => $allow['quality'],
                        'roles' => ['quality'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {   
        $getLowStock = Stock::getLowStock();
        $dataProvider = new ArrayDataProvider($getLowStock['dataProvider']); 
        $stockQuery = $getLowStock['stockQuery'];

        $totalQuotation = count(Quotation::getQuotation());
        $totalWorkOrder = count(WorkOrder::getWorkOrder());
        $totalWorkOrderInProgress = count(WorkOrder::getWorkOrderInProgress());
        $totalWorkOrderCompleted = count(WorkOrder::getWorkOrderCompleted());
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'stockQuery' => $stockQuery,
            'totalQuotation' => $totalQuotation,
            'totalWorkOrder' => $totalWorkOrder,
            'totalWorkOrderInProgress' => $totalWorkOrderInProgress,
            'totalWorkOrderCompleted' => $totalWorkOrderCompleted,
        ]);
    }


     public function actionLogin()
    {   
        $this->layout=false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUrl()
    {         
        $uploadedFile = UploadedFile::getInstanceByName('upload'); 
        // $mime = \yii\helpers\FileHelper::getMimeType($uploadedFile->tempName);
        $mime = $uploadedFile->type;
        $file = time()."_".$uploadedFile->name;
        // $url = Yii::$app->urlManager->createAbsoluteUrl('/uploads/ckeditor/'.$file);
        // $uploadPath = Yii::getAlias('@webroot').'/uploads/ckeditor/'.$file;
        $url = 'uploads/ckeditor/'.$file;
        $uploadPath = 'uploads/ckeditor/'.$file;
        // http://localhost/aero_industries_v2/backend/web/index.php?r=uploads%2Fckeditor%2F1474608776_5656.png
        //extensive suitability check before doing anything with the file…
        if ($uploadedFile==null)
        {
           $message = "No file uploaded.";
        }
        else if ($uploadedFile->size == 0)
        {
           $message = "The file is of zero length.";
        }
        else if ($mime!="image/jpeg" && $mime!="image/png")
        {
           $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
        }
        else if ($uploadedFile->tempName==null)
        {
           $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
        }
        else {
          $message = "";
          $move = $uploadedFile->saveAs($uploadPath);
          if(!$move)
          {
             $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
          } 
        }
        $funcNum = $_GET['CKEditorFuncNum'] ;
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";        
    } 

    public function export() {
        
    }


    /**
     * AJAX FUNCTION.
     */
    public function actionToggleSidebar()
    {   
        if ( Yii::$app->request->post() ) {
            if(isset($_SESSION['sidebar-collapse'])){
                $collapse = '';
                unset($_SESSION['sidebar-collapse']);
            } else {
                $collapse = 'sidebar-collapse';
                $_SESSION['sidebar-collapse'] = 'sidebar-collapse';
            }
            return $collapse;
        }
    }
}
