<?php

namespace app\controllers;

use Yii;
use app\models\Banners;
use app\models\BannersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for Banners model.
 */
class BannerController extends Controller
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
     * Lists all Banners models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banners model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banners();

        if ($model->load(Yii::$app->request->post())) {
            //Pega a instância do arquivo
            $model->image_file = UploadedFile::getInstance($model, 'image_file');

            //Salva o caminho no BD
            if ($model->url_imagem = $model->uploadBanner()) {
                $model->created_at = $model->updated_at = date('Y-m-d h:i:s');

                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', ['model' => $model,]);
                }

            } else {
                throw new BadRequestHttpException('Não foi possível enviar o arquivo');
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Banners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $currentImage = $model->url_imagem;

        if ($model->load(Yii::$app->request->post())) {
            //Pega a instância do arquivo
            $model->image_file = UploadedFile::getInstance($model, 'image_file');
            $model->updated_at = date('Y-m-d h:i:s');

            //Salva o caminho no BD e apaga a imagem antiga
            if ($model->uploadBanner()) {
                $model->url_imagem = $model->uploadBanner();
                $model->deleteBanner($currentImage);
            }

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', ['model' => $model,]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Banners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteBanner($model->url_imagem);

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }
}
