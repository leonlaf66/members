<?php
use yii\helpers\Html;
use yii\grid\GridView;
use module\estate\helpers\Rets as RetsHelper;
use module\estate\helpers\FieldFilter;
  
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
                $imgSrc = $m->house->photo;
                $linkUrl = FieldFilter::url($m->house->id, $m->house->prop!== 'RN');

                return "<a href=\"{$linkUrl}\" class=\"_blank\"><img src=\"{$imgSrc}\" style=\"width:60px;height:50px;\"/></a>";
            },
            'headerOptions'=>[
              'width'=>'50'
            ],
            'format'=>'html'
        ],
        'item_name'=>[
            'value'=>function($m){
                $linkUrl = FieldFilter::url($m->house->id, $m->house->prop!== 'RN');
                $name = $m->house->nm;

                return "<a class=\"_blank\" href=\"{$linkUrl}\">{$name}</a>";
            },
            'headerOptions'=>[
              'width'=>'320'
            ],
            'format'=>'html'
        ],
        'date_start'=>[
            'header'=>tt('Start Time', '开始时间'),
            'attribute'=>'date_start',
            'value'=>function($m) {
                return date('Y-m-d H:00', strtotime($m->date_start));
            }
        ],
        'date_end'=>[
            'header'=>tt('End Time', '结束时间'),
            'attribute'=>'date_end',
            'value'=>function($m) {
                return date('Y-m-d H:00', strtotime($m->date_end));
            }
        ],
        'status'=>[
            'header'=>tt('Status', '确认状态'),
            'attribute'=>'status',
            'value'=>function($m) {
                $statusName = tt($m->is_confirmed ? ['Confirmed', '已确认'] : ['Not Confirmed', '未确认']);
                return "<span class=\"badge\">{$statusName}</span>";
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

<script type="text/javascript">
$('a._blank').attr('target', '_blank');
</script>