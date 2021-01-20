<?php
/**
* @var $channel \common\models\User;
*/
 use yii\helpers\Url;
?>
<a class="btn <?= $channel->isSubscribed(Yii::$app->user->id) ? 
'btn-secondary' : 'btn-danger' ?>"  href="<?= Url::to(['channel/subscribe', 'username' => $channel->username]) ?>" 
    role="button" data-method="post" data-pjax="1">
    Subscribe <i class="far fa-bell"></i>
</a> <?= $channel->getSubscribers()->count() ?>