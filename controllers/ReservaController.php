<?php

namespace app\controllers;

use app\models\Reserva;
use app\models\ReservaSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ReservaController extends Controller
{
	
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


	public function behaviors2()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/login']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ReservaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


	public function actionCreate($data_do_evento = null)
	{
		$model = new \app\models\Reserva();

		// se recebeu a data via GET em formato YYYY-MM-DD, converte para dd/mm/YYYY (ajuste conforme seu DB)
		if ($data_do_evento) {
			$model->data_do_evento = date('d/m/Y', strtotime($data_do_evento));
		}

		$request = \Yii::$app->request;

		// POST (envio do formulário)
		if ($request->isPost && $model->load($request->post())) {
			if ($model->save()) {
				if ($request->isAjax) {
					\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return ['success' => true];
				}
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				// validação falhou: se for AJAX, retorna o form com erros (HTML) para injetar no modal
				if ($request->isAjax) {
					return $this->renderAjax('create', ['model' => $model]);
				}
			}
		}

		// Pedido GET (abrir formulário no modal)
		if ($request->isAjax) {
			return $this->renderAjax('create', ['model' => $model]);
		}

		// fallback normal (se usuário abrir a página create)
		return $this->render('create', ['model' => $model]);
	}




    public function actionCreate2()
    {
        $model = new Reserva();
        $model->user_id = Yii::$app->user->id; // Preenche user_id

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Verifica se o usuário é o dono da reserva ou um gestor
     //   if ($model->user_id != Yii::$app->user->id && !Yii::$app->user->identity->isGestor) {
     //       throw new \yii\web\ForbiddenHttpException('Você não tem permissão para executar esta ação.');
      //  }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Verifica se o usuário é o dono da reserva ou um gestor
    //    if ($model->user_id != Yii::$app->user->id && !Yii::$app->user->identity->isGestor) {
     //       throw new \yii\web\ForbiddenHttpException('Você não tem permissão para executar esta ação.');
    //    }
        
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}