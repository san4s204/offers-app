<?php

namespace app\controllers;

use app\models\Offers;
//use yii\bootstrap5\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\widgets\ActiveForm as WidgetsActiveForm;
use yii\widgets\ActiveForm;
use Yii;

class Offers1Controller extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
{
    return $this->render('index');
}


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
{
    $model = new Offers();

    if ($this->request->isAjax && $model->load($this->request->post())) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->save()) {
            return ['status' => 'success', 'message' => 'Оффер успешно добавлен!'];
        } else {
            return [
                'status' => 'error',
                'errors' => ActiveForm::validate($model),
            ];
        }
    }

    if ($this->request->isAjax) {
        return $this->renderAjax('_form', ['model' => $model]);
    }

    return $this->redirect(['index']);
}


public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($this->request->isAjax && $model->load($this->request->post())) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->save()) {
            return ['status' => 'success'];
        } else {
            return [
                'status' => 'error',
                'errors' => ActiveForm::validate($model),
            ];
        }
    }

    if ($this->request->isAjax) {
        return $this->renderAjax('_form', ['model' => $model]);
    }

    return $this->redirect(['index']);
}   

    public function actionDelete()
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    if (\Yii::$app->request->isPost) {
        $id = \Yii::$app->request->post('id');
        if ($id) {
            $model = $this->findModel($id);
            if ($model->delete()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Не удалось удалить оффер.'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Некорректный идентификатор оффера.'];
        }
    }

    return ['status' => 'error', 'message' => 'Некорректный запрос.'];
}

    protected function findModel($id)
    {
        if (($model = Offers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAjaxFilter()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = \Yii::$app->request->get('name', '');
        $email = \Yii::$app->request->get('email', '');

        $query = Offers::find();

        // Применяем фильтрацию
        if (!empty($name)) {
            $query->andFilterWhere(['like', 'name', $name]);
        }
        if (!empty($email)) {
            $query->andFilterWhere(['like', 'email', $email]);
        }

        $offers = $query->all();
        $data = [];

        foreach ($offers as $offer) {
            $data[] = [
                'id' => $offer->id,
                'name' => $offer->name,
                'email' => $offer->email,
                'phone' => $offer->phone,
                'created_at' => $offer->created_at,
            ];
        }

        // Проверка на наличие данных
        if (empty($data)) {
            return ['data' => [], 'status' => 'empty'];
        }

        return ['data' => $data, 'status' => 'success'];
    }

}
