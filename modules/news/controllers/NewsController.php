<?php

namespace app\modules\news\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\news\models\News;
use app\modules\news\models\Themes;
use yii\data\Pagination;

class NewsController extends Controller
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
    public function actionIndex($year = null, $month = null, $theme_id = null)
    {
        if($year && $month) { 
            $newsQuery = News::find()->
                where('MONTH(date) = :month', [':month' => $month])->
                andWhere('YEAR(date) = :year', [':year' => $year])->
                orderBy(['date' => SORT_DESC]);
        } elseif($theme_id) {
            $newsQuery = News::find()->
                where('theme_id = :theme_id', [':theme_id' => $theme_id])->
                orderBy(['date' => SORT_DESC]);
        } else {
            $newsQuery = News::find()->orderBy(['date' => SORT_DESC]);
        }
        
        $count = $newsQuery->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 3]);
        $news = $newsQuery->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $datesSql = 'SELECT YEAR(date) AS `year`, MONTH(date) AS `month`, COUNT(*) AS `count` FROM news GROUP BY `year`, `month` ORDER BY YEAR(date) DESC';
        $datesResult = Yii::$app->db->createCommand($datesSql)->queryAll();

        $themesSql = 'SELECT themes.theme_title AS theme_title, themes.theme_id AS theme_id, COUNT(news.theme_id) as count FROM themes LEFT JOIN news ON themes.theme_id = news.theme_id GROUP BY theme_title, theme_id';
        $themesResult = Yii::$app->db->createCommand($themesSql)->queryAll();        

        return $this->render('index',[
            'news'=>$news,
            'pagination'=>$pagination,
            'themes'=>$themesResult,
            'dates' => $datesResult
        ]);
    }

    public function actionView($id)
    {
        $news = News::findOne($id);
       
        
        return $this->render('single',[
            'news'=>$news,
            
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
