<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\News;
use app\models\Themes;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($year = null, $month = null)
    {
        if($year && $month) 
        { 
            $news = News::find()->
                where('MONTH(date) = :month', [':month' => $month])->
                andWhere('YEAR(date) = :year', [':year' => $year])->
                orderBy(['date' => SORT_DESC])->all();
        } else
        {
            $news = News::find()->orderBy(['date' => SORT_DESC])->all();
        }

        $themes = Themes::getAll();
        

        $datesSql = 'select year(date) as `year`, month(date) as `month`, count(*) as `count` from news group by `year`, `month` order by year(date) desc';
        $datesResult = Yii::$app->db->createCommand($datesSql)->queryAll();
        

        return $this->render('index',[
            'news'=>$news,
            //'pagination'=>$data['pagination'],
            'themes'=>$themes,
            'dates' => $datesResult
        ]);
    }

    public function actionView($id)
    {
        $news = News::findOne($id);
        $theme = Themes::findOne($news->theme_id);
       
        
        return $this->render('single',[
            'news'=>$news,
            'theme'=>$themes,
        ]);
    }







    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->redirect('/admin');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
