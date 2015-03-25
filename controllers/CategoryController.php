<?php

namespace app\controllers;

use Yii;
use app\models\PostCategory;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\easyimage\EasyImage;

/**
 * CategoryController implements the CRUD actions for PostCategory model.
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ];
    }

    /**
     * Lists all PostCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single PostCategory model.
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
     * Creates a new PostCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PostCategory();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = \Yii::$app->user->getId();
            $model->created_date = date('Y-m-d H:i:s', time());
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $file = UploadedFile::getInstance($model, 'category_pic');
            $ext = explode('.', $file->name);
            $model->category_pic = $randomString . '.' . $ext[count($ext)-1];
            if($model->save()){
                $file->saveAs('images/categories/' . $model->category_pic);
                $file=Yii::getAlias('@app/web/images/categories/'.$model->category_pic); 
                $image=Yii::$app->image->load($file);
                $image->resize(1000,1000)->crop(800, 500)->save();
                Yii::$app->session->setFlash('message', 'Category created successfully.');
                return $this->redirect(['view', 'id' => $model->category_id]);
            }else{
                print_r(Yii::$app->user);
                print_r($model->getErrors());
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                ]);
        }
    }

    /**
     * Updates an existing PostCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'category_pic');
            if($file){
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $length = 8;
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }   
                $ext = explode('.', $file->name);
                $model->category_pic = $randomString . '.' . $ext[count($ext)-1];
            }
            if($model->save()){
                if($model->category_pic){
                    $file->saveAs('images/categories/' . $model->category_pic);
                    $file=Yii::getAlias('@app/web/images/categories/'.$model->category_pic); 
                    $image=Yii::$app->image->load($file);
                    $image->resize(1000,1000)->crop(800, 500)->save();
                }
                Yii::$app->session->setFlash('message', 'Category edited successfully.');
                return $this->redirect(['view', 'id' => $model->category_id]);
            }
        }   
        return $this->render('update', [
            'model' => $model,
            ]);     
    }

    /**
     * Deletes an existing PostCategory model.
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
     * Finds the PostCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
