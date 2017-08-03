<?php
use yii\helpers\Html;
use yii\grid\GridView;
use module\estate\helpers\Rets as RetsHelper;
  
$this->title = tt('My Schedule', '我的预约');  
$this->params['breadcrumbs'][] = $this->title;  
?>

<h2 class="title"><?php echo $this->title?></h2>

<?php
echo yii\grid\GridView::widget([
    'id'=>'uc-schedule-grid',
    'layout'=>"{pager}\n{items}\n{pager}",
    'tableOptions'=>['class'=>'table'],
    'dataProvider' => $dataProvider,
    'columns'=>[
        'item_image'=>[
            'header'=>tt('Item', '项目'),
            'value'=>function($m){
                if($rets = $m->getRets()) {
                    $imgSrc = $rets->getPhoto(0, 60, 50) . '';
                    $linkUrl  = RetsHelper::getUrl($rets);
                    return "<a href=\"{$linkUrl}\" target=\"_blank\"><img src=\"{$imgSrc}\" style=\"width:60px;height:50px;\"/></a>";
                }
                return '';
            },
            'headerOptions'=>[
              'width'=>'50'
            ],
            'format'=>'html'
        ],
        'item_name'=>[
            'value'=>function($m){
                if($rets = $m->getRets()) {
                    $linkUrl = RetsHelper::getUrl($rets);
                    $name = $m->getRetsName();
                    return "<a href=\"{$linkUrl}\" target=\"_blank\">{$name}</a>";
                }
                return '';
            },
            'headerOptions'=>[
              'width'=>'320'
            ],
            'format'=>'html'
        ],
        'date_start'=>[
            'attribute'=>'date_start',
            'value'=>function($m) {
                return date('Y-m-d H:00', strtotime($m->date_start));
            }
        ],
        'date_end'=>[
            'attribute'=>'date_end',
            'value'=>function($m) {
                return date('Y-m-d H:00', strtotime($m->date_end));
            }
        ],
        'status'=>[
            'attribute'=>'status',
            'value'=>function($m) {
                return "<span class=\"badge\">{$m->getStatusName()}</span>";
            },
            'format'=>'html'
        ],
        [
           'class' => 'yii\grid\ActionColumn',
           'header' => tt('Action', '操作'), 
           'template' => '{delete}',
           'headerOptions' => ['width' => '50px'],
           'contentOptions'=>[
                'align'=>'center'
           ]
        ],
    ]
]);
?>