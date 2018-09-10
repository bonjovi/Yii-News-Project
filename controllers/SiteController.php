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
    public function actionIndex($date = null)
    {
        $date ? $data = News::find()->where('MONTH(date) = :date', [':date' => $date])->orderBy(['date' => SORT_DESC])->all() : $data = News::find()->orderBy(['date' => SORT_DESC])->all();

        $themes = Themes::getAll();
        $years = News::find()->select('date')->all();
        // foreach($years as $year) {
        //     echo $year->date('YEAR(date)');
        // }

        $sql = 'select year(date) as `year`, month(date) as `month`, count(*) as `count` from news group by `year`, `month` order by year(date) desc';
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        // echo '<pre>';
        //var_dump($result);
        // print_r($result);
        // echo '</pre>';
        // die;

        return $this->render('index',[
            'news'=>$data,
            'pagination'=>$data['pagination'],
            'themes'=>$themes,
            'dates' => $result
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
