<?php

namespace app\controllers;

use app\models\About;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Banners;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'about-edit'],
                'rules' => [
                    [
                        'actions' => ['logout', 'about-edit'],
                        'allow' => true,
                        'roles' => ['@'],
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $bannerModel = new Banners();
        return $this->render('index', ['banners' => $bannerModel->buildBannerObject()]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())
            && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Conteúdo da página Sobre.
     *
     * @return string
     */
    public function actionAbout()
    {
        $id = 1;
        $find = About::findOne($id);

        if ($find) {
            $model = $find;

            return $this->render('about', [
                'model' => $model,
            ]);
        } else {
            return $this->render('about');
        }
    }

    /**
     * Edição do conteúdo da página Sobre.
     *
     * @return string|\yii\web\Response
     */
    public function actionAboutEdit()
    {
        $model = new About();

        $id = 1;
        $find = About::findOne($id);
        if ($find) {
            if (!$find->isNewRecord) {
                $model = $find;
                $model->conteudo = htmlspecialchars_decode($model->conteudo, ENT_QUOTES);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->id = $id;
            $model->conteudo = htmlspecialchars($model->conteudo, ENT_QUOTES, 'UTF-8');
            if ($model->save()) {
                return $this->redirect(['about']);
            }
        }

        return $this->render('about-edit', [
            'model' => $model,
        ]);
    }
}
