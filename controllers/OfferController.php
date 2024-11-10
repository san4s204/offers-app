<?php
namespace app\controllers;

use Yii;
use app\models\Offer;
use app\models\Offers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

class OfferController extends Controller
{
    // Метод для отображения списка офферов
    public function actionIndex()
    {
        $searchModel = new \app\models\OfferSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Offers::find(),
            'pagination' => [
                'pageSize' => 10, // Пагинация: 10 записей на страницу
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);
    
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    protected function findModel($id)
{
    if (($model = \app\models\Offers::findOne($id)) !== null) {
        return $model;
    }

    throw new \yii\web\NotFoundHttpException('The requested offer does not exist.');
}


    public function behaviors()
{
    return [
        'access' => [
            'class' => \yii\filters\AccessControl::class,
            'only' => ['index', 'view', 'create', 'update', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], // Доступ только для авторизованных пользователей
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'roles' => ['?'], // Доступ для всех
                ],
            ],
        ],
    ];
}
public function actionCreate()
{
    $model = new \app\models\Offers();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['index']);
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}

public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Offer updated successfully.');
        return $this->redirect(['index']);
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

public function actionDelete($id)
{
    $this->findModel($id)->delete();
    Yii::$app->session->setFlash('success', 'Offer deleted successfully.');

    return $this->redirect(['index']);
}




    // Другие методы CRUD операций

}