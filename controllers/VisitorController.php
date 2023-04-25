<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Visitor;
use app\models\search\VisitorSearch;

/**
 * VisitorController implements the CRUD actions for Visitor model.
 */
class VisitorController extends Controller
{
    public function actionFindByKeywords($keywords = '')
    {
        return $this->asJson(
            Visitor::findByKeywords($keywords, [
                'expire',
                'cookie',
                'ip',
                'browser',
                'os',
                'device',
                'location',
            ])
        );
    }

    /**
     * Lists all Visitor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitorSearch();
        $dataProvider = $searchModel->search(['VisitorSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visitor model.
     * @param string $cookie
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($cookie)
    {
        return $this->render('view', [
            'model' => Visitor::controllerFind($cookie, 'cookie'),
        ]);
    }

    /**
     * Deletes an existing Visitor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cookie
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($cookie)
    {
        $model = Visitor::controllerFind($cookie, 'cookie');

        if ($model->delete()) {
            App::success('Successfully Deleted');
        } else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }
}