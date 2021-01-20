<?php

/**
 * var $dataProvider \yii\data\ActiveDataProvider
 */

 ?>
  <h1 style="font-weight:600;"> My History </h1>
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