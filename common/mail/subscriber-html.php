<?php 
/** @var $channel \common\models\User */
/** @var $user \common\models\User */

use \common\helpers\Html;
?>

<p> Hello <?= $channel->username; ?></p>
<p> User <?= Html::channelLink($user,true); ?> has subscribed to you</p>

<p> FreeCodeTube team </p>