<?php
namespace common\helpers;

/**
 * Class Html
 * 
 * @author Lynn Nyangon 
 * @package common\helpers;
 */

 use yii\helpers\Url;

 class Html{
     public static function channelLink($user, $schema = false){
        return \yii\helpers\Html::a($user->username,Url::to([
            '/channel/view', 'username' => $user->username], $schema),
            ['class' => 'text-dark channel-link']);
     }
 }
?>