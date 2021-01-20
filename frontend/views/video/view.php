<?php
/**
 * var $model \common\models\Video
 */

 use yii\helpers\Url;
 use yii\widgets\Pjax;
 use yii\helpers\Html;

 /**
  * @var $this \yii\web\View 
  * @var $model \common\models\Video
  * @var $similarVideos \common\models\Video[]
  * @var $comments \common\models\Comment[]
  */
?>

<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item"
                    src="<?php echo $model->getVideoLink(); ?>" controls>
            </video>
        </div>
        <h6 class="mt-2 font-weight-bold"><?= $model->title; ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p> <?= $model->getViews()->count(); ?> views . <?= Yii::$app->formatter->asDate($model->created_at); ?></p>
            </div>
            <div>
                <?php Pjax::begin() ?>
                    <?= $this->render('_buttons', [
                        'model' => $model
                    ]) ?>
                <?php Pjax::end() ?>
            </div>
        </div>  
        <div>
            <p> <?= \common\helpers\Html::channelLink($model->createdBy); ?></p>
            <?= Html::encode($model->description); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <?php foreach($similarVideos as $similarVideo): ?>
            <div class="media">
                <a href="<?= Url::to(['/video/view', 'id' => $similarVideo->video_id]);?>">
                    <div class="embed-responsive embed-responsive-16by9 mr-2 mb-3" 
                    style="width:140px;">
                        <video class="embed-responsive-item"
                                src="<?php echo $similarVideo->getVideoLink(); ?>">
                        </video>
                    </div>
                </a>
                <div class="media-body">
                    <h6 class="m-0 font-weight-bold"> <?= $similarVideo->title;?></h6>
                    <div class="text-muted">
                        <p class="m-0">
                            <?= \common\helpers\Html::channelLink($similarVideo->createdBy); ?> 
                        </p>
                        <small>
                            <?= $similarVideo->getViews()->count(); ?> views . <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>