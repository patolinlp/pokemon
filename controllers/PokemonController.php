<?php

namespace app\controllers;

use Yii;
use app\models\Pokemon;
use app\models\MisUser;
use app\models\Comentario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\Pagination;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\web\Response;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;

/**
 * PokemonController implements the CRUD actions for Pokemon model.
 */
class PokemonController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback'=>function($rule,$action){
                            return MisUser::isUserAdmin(Yii::$app->user->identity->id);
                        },
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule,$action){
                            return MisUser::isUserSimple(Yii::$app->user->identity->id);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pokemon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $table  =   Pokemon::find();
        $pagination =   new Pagination([    'defaultPageSize'   =>  5,'totalCount'  =>  $table->count(),]);
        $form   =   new FormSearch;
        $search =   null;
        if($form->load(Yii::$app->request->get()))
        {
            if  ($form->validate())
            {
                //quita simbolos    html    del form    para    evitar  posibles    ataques de  xss
                $search =   Html::encode($form->q);
                $pokemons   =   $table->orFilterWhere(['like','id',$search])->orFilterWhere(['like','name',$search])->orFilterWhere(['like','type1',$search])->orFilterWhere(['like','type2',$search]);
                $pagination =   new Pagination(['defaultPageSize'   =>  5,'totalCount'  =>  $pokemons->count(),]);
                $pokemons   =   $pokemons->orderBy('number')    ->offset($pagination->offset)->limit($pagination->limit)->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        else
        {
            $pokemons=$table->orderBy('number')->offset($pagination->offset)->limit($pagination->limit)->all();
        }
        return  $this->render('index',  ['pokemons'=>$pokemons,'pagination'=>$pagination,'form'=>$form,'search'=>$search]);
    }

    /**
     * Displays a single Pokemon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $comentarios = Comentario::find()->where(['id_pokemon' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Creates a new Pokemon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pokemon();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pokemon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pokemon model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pokemon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pokemon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pokemon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
