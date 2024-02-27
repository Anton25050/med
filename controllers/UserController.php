<?php

namespace app\controllers;

use app\models\User;
use app\models\Role;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UserRegister;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = new UserRegister();

        if ($this->request->isPost) {
            // Можно поставить $model->validate(), для проверки валидации, но она автоматически проверяется методом $model->save()
            if ($model->load($this->request->post())) {
                // Назначаем новому пользователю id роли пользователя
                $model->role_id = Role::USER_ROLE_ID;
                // Переносим сохранение модели в отдельное условие, чтобы была возможность добавить id роли до сохранения
                if ($model->save()) {
                    // Переносим пользователя на страницу аутентификации при успешном созранении модели
                    return $this->redirect('/site/login');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
