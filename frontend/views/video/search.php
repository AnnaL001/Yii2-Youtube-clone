<?php

/**
 * var $dataProvider \yii\data\ActiveDataProvider
 */

    $this->title = 'Search videos | '.Yii::$app->name;
 ?>

  <h1 style="font-weight:600;"> Found videos </h1>
  <?= \yii\widgets\ListView::widget([
      'dataProvider' => $dataProvider,
      'pager' => [
        'class' => \yii\bootstrap4\LinkPager::class,
       ],
      'itemView' => '_video_item',
      'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
      'itemOptions' => [
          'tag' => false
      ]
  ]); 
  ?>