<?php
/** @var $model \common\models\video  */

use \yii\helpers\Url;
use \common\helpers\Html;
?>

<div class="card m-3" style="width: 15rem;">
    <a href="<?= Url::to(['/video/view', 'id' => $model->video_id]); ?>">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item"
                    src="<?php echo $model->getVideoLink(); ?>">
            </video>
        </div>
    </a>
    <div class="card-body p-2">
        <h6 class="card-title font-weight-bold m-0"><?= $model->title; ?></h6>
        <p class="card-text text-muted m-0"> <?= Html::channelLink($model->createdBy); ?> </p>
        <p class="card-text text-muted m-0"> <?= $model->getViews()->count(); ?> views . <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?> </p>
    </div>
</div>