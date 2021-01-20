<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-lg navbar-light bg-light shadow-sm']
]);

if (Yii::$app->user->isGuest) {
    //when user is not authorized
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
       'label' => 'Logout (' .Yii::$app->user->identity->username. ')' ,
       'url' => ['/site/logout'],
       'linkOptions'=>[
         'data-method' => 'post'
       ]
    ];
}
?>
    <form action="<?= Url::to(['/video/search']);?>" class="form-inline my-2 my-lg-0">
        <input type="search" class="form-control mr-sm-2" placeholder="Search" name="keyword"
        value="<?=Yii::$app->request->get('keyword') ?>">
        <button class="btn btn-outline-success my-2 my-sm-0"> Search </button>
    </form>
<?php
echo Nav::widget([
    'options' => ['class' => 'navbar-nav ml-auto'],
    'items' => $menuItems,
]);
NavBar::end();

?>
