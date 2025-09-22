<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
		 
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['?'], // libera para visitantes (não autenticados)
					],
					[
						'allow' => true,
						'roles' => ['@'], // libera também para autenticados (opcional)
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
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

 
public function actionIndex()
{
    $events = [];
    $reservas = \app\models\Reserva::find()->all();

    foreach ($reservas as $reserva) {
        $start = \DateTime::createFromFormat('d/m/Y H:i', $reserva->data_do_evento . ' ' . $reserva->hora_de_inicio_do_evento);
        $end   = \DateTime::createFromFormat('d/m/Y H:i', $reserva->data_do_evento . ' ' . $reserva->hora_final_do_evento);

        $events[] = [
            'id'    => $reserva->id,
            'title' => $reserva->titulo_evento . " ({$reserva->hora_de_inicio_do_evento} - {$reserva->hora_final_do_evento})",
            'start' => $start ? $start->format('Y-m-d\TH:i:s') : null,
            'end'   => $end ? $end->format('Y-m-d\TH:i:s') : null,
            'allDay' => false,
        ];
    }

/*
    // Gerar eventos "+" para cada dia deste ano e do próximo
    $anoAtual = (int)date('Y');
    $inicio = new \DateTime("{$anoAtual}-01-01");
    $fim = new \DateTime(($anoAtual+1) . "-12-31");

    for ($date = clone $inicio; $date <= $fim; $date->modify('+1 day')) {
        $dataFormatada = $date->format('d/m/Y');
        $dataISO = $date->format('Y-m-d');

        $events[] = [
            'title' => '+',
            'start' => $dataISO,
            'allDay' => true,
            'url' => \yii\helpers\Url::to(['reserva/create', 'data_do_evento' => $dataFormatada]),
            'color' => '#28a745', // verde para destacar o botão + como evento
            'textColor' => '#fff',
        ];
    }
	*/

    return $this->render('index', [
        'events' => $events,
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
            return $this->goBack();
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
