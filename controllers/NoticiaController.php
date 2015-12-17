<?php

namespace app\controllers;

use Yii;
use app\models\Noticia;
use app\models\NoticiaSearch;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * NoticiaController implements the CRUD actions for Noticia model.
 */
class NoticiaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>
                [
                    'class' => \yii\filters\AccessControl::className(),
                    'only' => ['create', 'delete', 'update', 'view', 'index'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@']
                        ],
                    ],
                ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Noticia models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Noticia model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render(
            'view', [
                'model' => $this->findModel($id),
            ]
        );
    }


    /**
     * Displays a single Noticia model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionVerNoticia($id)
    {
        $model = $this->findModel($id);
        # Atualizar visitas
        $model->visitas = $model->visitas + 1;
        $model->update();

        return $this->render(
            'ver_noticia', [
                'model' => $model,
            ]
        );
    }


    /**
     * Creates a new Noticia model.
     * If creation is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noticia();

        // Teste temporário
        $model->id_autor = 1;
        $model->nome_autor = 'Armando Ricardo';

        if ($model->load(Yii::$app->request->post())) {

            # Instância do arquivo
            $model->image_file = UploadedFile::getInstance($model, 'image_file');

            if ($model->image_file != null) {
                if ($model->uploadImagem()) {
                    $model->imagem = $model->uploadImagem();
                } else {
                    Yii::$app->session->setFlash('error', 'Não foi possível enviar o arquivo');
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render(
            'create', [
                'model' => $model,
            ]
        );
    }

    /**
     * Updates an existing Noticia model.
     * If update is successful, the browser will be redirected to the 'view'
     * page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            # Instância do arquivo
            $model->image_file = UploadedFile::getInstance($model, 'image_file');

            if ($model->image_file != null) {
                if ($model->uploadImagem()) {
                    $model->imagem = $model->uploadImagem();
                } else {
                    Yii::$app->session->setFlash('error', 'Não foi possível enviar o arquivo');
                }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render(
                'update', [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Deletes an existing Noticia model.
     * If deletion is successful, the browser will be redirected to the 'index'
     * page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Noticia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Noticia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
