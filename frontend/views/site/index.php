<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Youtube video statistics';


$csrf = \yii::$app->request->csrfParam;

$token = \yii::$app->request->csrfToken;
?>

<?php Pjax::begin(['enablePushState' => false])?>
<div class="site-index video">
    <?= Html::beginForm(['site/index'], 'post', ['data-pjax' => '']) ?>
        <div class="row <?=$attr;?>">
        <div class="col-lg-2">
            <div class="video__attr">
                <input name="attr" type="radio" id="views" value="views" <?=($attr == 'views') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                <label for="views"><i class="fa fa-eye"></i> Views</label>

                <input name="attr" type="radio" id="likes" value="likes" <?=($attr == 'likes') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                <label for="likes"> <i class="fa fa-thumbs-up"></i> Likes</label>

                <input name="attr" type="radio" id="dislikes" value="dislikes" <?=($attr == 'dislikes') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                <label for="dislikes"><i class="fa fa-thumbs-down"></i> Dislakes</label>

                <input name="attr" type="radio" id="subscribers" value="subscribers" <?=($attr == 'subscribers') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                <label for="subscribers"><i class="fa fa-users"></i> Chanel subscribers</label>
                <?= Html::hiddenInput($csrf,$token);?>
            </div>
            
        </div>
        <div class="col-lg-10">
            <div id="plot-container"></div>
                <div class="row video__date">
                    <div class="col-lg-4">
                        <input name="date_start" type="radio" id="daily" value="daily" <?=($date_start == 'daily') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                        <label for="daily">Daily report</label>
                    </div>

                    <div class="col-lg-4">
                        <input name="date_start" type="radio" id="weekly" value="weekly" <?=($date_start == 'weekly') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                        <label for="weekly">Weekly report</label>
                    </div>

                    <div class="col-lg-4">
                    <input name="date_start" type="radio" id="monthly" value="monthly" <?=($date_start == 'monthly') ? 'checked' : ''?> onchange="$(this).closest('form').submit();">
                    <label for="monthly">Monthly report</label>
                    </div>
                </div>
            </div>
        </div>

    <?= Html::endForm() ?>

    <br><br>

    <div class="video_list">
        <?php foreach($video as $key => $v){ ?>
            <div class="video_item" style="border: 3px solid <?=$colors[$key];?>">
                <?= Html::img($v->video_thumb); ?>
                <div class="video__title"><b>Title</b>: <?=$v->video_title;?></div>
                <div class="video__title"><b>Chanel</b>: <?=$v->chanel_title;?></div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
    $this->registerJs('var data = ' . json_encode($plot_data) . '; var colors = ' . json_encode($colors) . '; var title = "' . $attr . '"');
?>
<?php
$script = <<< JS
    Highcharts.chart('plot-container', {

    title: {
        text: 'Youtube video statistics'
    },

    yAxis: {
        title: {
            text: title
        }
    },
    xAxis: {
        type: 'datetime',
    },

    plotOptions: {
        series: {
            showInLegend: false,
            pointStart: 1
        }
    },

    colors: ['#d41814', '#337ab7', '#3c763d', '#ef9d08', '#7800fb'],

    series: data,

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

    });
JS;
$this->registerJs($script);
?>

<?php 
    $this->registerJsFile('//code.highcharts.com/highcharts.js', ['depends' => [yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('//code.highcharts.com/modules/series-label.js', ['depends' => [yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('//code.highcharts.com/modules/exporting.js', ['depends' => [yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('//code.highcharts.com/modules/export-data.js', ['depends' => [yii\web\JqueryAsset::className()]]);
?>

<?php Pjax::end(); ?>
