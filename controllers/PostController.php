<?php

namespace app\controllers;

use Yii;
use app\models\PostServices;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PostCategory;
use app\models\Users;
use yii\web\UploadedFile;
use yii\easyimage\EasyImage;
/**
 * PostController implements the CRUD actions for PostServices model.
 */
class PostController extends Controller
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
     * Lists all PostServices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single PostServices model.
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
     * Creates a new PostServices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'columnLeft';
        $user_id = \Yii::$app->user->getID();
        $user = Users::find($user_id)->one();
        $categories = new PostCategory;
        $model = new PostServices();
        $categories = $categories->find()->all();
        $categoryList[''] = '--Select category--';
        foreach ($categories as $key => $category) {
            $categoryList[$category->category_id] = $category->category_name;
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->owner_id = $user_id;
            $model->currency = 'Rs.';
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $file = UploadedFile::getInstance($model, 'image_url');
            $ext = explode('.', $file->name);
            $model->image_url = $user_id . '_' . $randomString . '.' . $ext[count($ext)-1];
            $model->datetimestamp = date('Y-m-d H:i:s', time());
            $model->featured = 0;
            if($model->save()){
               $file->saveAs('images/services/' . $model->image_url);
               $file=Yii::getAlias('@app/web/images/services/'.$model->image_url); 
               $image=Yii::$app->image->load($file);
               $image->resize(1000,1000)->crop(800, 500)->save();
               \Yii::$app->getSession()->setFlash('message', 'Post created successfully. You are ready to make some money.');
               return $this->redirect(['user/profile']);
           }
       }
        return $this->render('create', [
            'model' => $model,
            'categories' => $categoryList,
            'user'=>$user,
            ]);
    
}

    /**
     * Updates an existing PostServices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'columnLeft';
        $model = $this->findModel($id);
        $user_id = \Yii::$app->user->getID();
        $image_url = $model->image_url;
        $categories = new PostCategory;
        $categories = $categories->find()->all();
        $categoryList[''] = '--Select category--';
        foreach ($categories as $key => $category) {
            $categoryList[$category->category_id] = $category->category_name;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $length = 8;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }   
            $file = UploadedFile::getInstance($model, 'image_url');
            if(!empty($file)){
                $ext = explode('.', $file->name);
                $model->image_url = $user_id . '_' . $randomString . '.' . $ext[count($ext)-1];
                $file->saveAs('images/services/' . $model->image_url);
                $file=Yii::getAlias('@app/web/images/services/'.$model->image_url); 
                $image=Yii::$app->image->load($file);
                $dimension = getimagesize('images/services/' . $model->image_url);
                $width = $dimension[0];
                $height = $dimension[1];
                if($height > $width ){
                     $image->resize($width*2, $width*2)->crop(800, 500)->save();
                }else{
                       $image->resize($height*1.5,$height*1.5)->crop(800, 500)->save();
                }
            }else{
                $model->image_url = $image_url;
            }
            if($model->save()){
                \Yii::$app->getSession()->setFlash('message', 'Post updated successfully.');
                return $this->redirect(['user/profile']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categoryList,
                ]);
        }
    }

    /**
     * Deletes an existing PostServices model.
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
     * Finds the PostServices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PostServices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostServices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
