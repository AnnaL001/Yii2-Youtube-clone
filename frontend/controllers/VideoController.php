<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\Video;
use common\models\VideoView;
use common\models\VideoLike;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class VideoController
 * 
 * @author Lynn Nyangon
 * @package frontend\controllers
 */
class VideoController extends Controller{ 
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike', 'history'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post']
                ]
            ]
        ];
    }
    public function actionIndex(){
        $this->layout = 'main';
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->with('createdBy')->published()->latest(),
            'pagination' => [
                'pageSize' => 5
            ]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id){
        $this->layout = 'auth';
        $video = $this->findVideo($id);

        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = \Yii::$app->user->id;
        $videoView->created_at =time();
        $videoView->save();

        $similarVideos = Video::find()
            ->published()
            ->byKeyword($video->title)
            ->andWhere(['NOT', ['video_id' => $id]])
            ->limit(10)
            ->all();

        return $this->render('view', [
            'model' => $video,
            'similarVideos' => $similarVideos
        ]);
    }

    public function actionLike($id){
        $video = $this->findVideo($id);
        $userId = \Yii::$app->user->id;

        $videoLike = VideoLike::find()
            ->userIdVideoId($userId,$id)
            ->one();

        if(!$videoLike){
            $this->saveLikes($id, $userId, VideoLike::TYPE_LIKE);
        } elseif($videoLike->type = VideoLike::TYPE_LIKE){
            $videoLike->delete();
        }else{
            $videoLike->delete();
            $this->saveLikes($id, $userId, VideoLike::TYPE_LIKE);
        }
        

        return $this->renderAjax('_buttons',[
            'model' => $video
        ]);
    }

    public function actionDislike($id){
        $video = $this->findVideo($id);
        $userId = \Yii::$app->user->id;

        $videoLike = VideoLike::find()
            ->userIdVideoId($userId,$id)
            ->one();

        if(!$videoLike){
            $this->saveLikes($id, $userId, VideoLike::TYPE_DISLIKE);
        } elseif($videoLike->type = VideoLike::TYPE_DISLIKE){
            $videoLike->delete();
        }else{
            $videoLike->delete();
            $this->saveLikes($id, $userId, VideoLike::TYPE_DISLIKE);
        }
        

        return $this->renderAjax('_buttons',[
            'model' => $video
        ]);
    }


    protected function findVideo($id){
        $video = Video::findOne($id);
        if(!$video){
            throw new NotFoundHttpException("Video does not exist");
        }

        return $video;
    }

    protected function saveLikes($videoId,$userId,$type){
        $videoLike = new VideoLike();
        $videoLike->video_id = $videoId;
        $videoLike->user_id = $userId;
        $videoLike->type = $type;
        $videoLike->created_at = time();
        $videoLike->save();

    }

    public function actionSearch($keyword){
        $this->layout = 'main';
        $query = Video::find()
            ->with('createdBy') //For optimization
            ->published()
            ->latest();
        if($keyword){
            $query->byKeyword($keyword);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionHistory(){
        $this->layout = 'main';
        $query = Video::find()
            ->alias('v')
            ->innerJoin("(SELECT video_id, MAX(created_at) as max_date FROM video_view
                    WHERE user_id = :userId
                    GROUP BY video_id) vv", 'vv.video_id = v.video_id',[
                    'userId' => \Yii::$app->user->id
                    ])
                    ->orderBy("vv.max_date ASC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }
}
?>