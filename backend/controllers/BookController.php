<?php

namespace backend\controllers;

use backend\models\Book;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class BookController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        if (!\Yii::$app->user->can('listBooks')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),

            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                     'id' => SORT_DESC,
                ]
             ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        if (!\Yii::$app->user->can('viewBook')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->can('createBook')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $model = new Book();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->authorBooks = $this->request->post('Book')['authorBooks'];
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        if (!\Yii::$app->user->can('updateBook')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->authorBooks = $this->request->post('Book')['authorBooks'];
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        if (!\Yii::$app->user->can('deleteBook')) {
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?Book
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
