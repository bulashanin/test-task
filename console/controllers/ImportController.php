<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\httpclient\Client;

use common\models\Video;
use common\models\VideoStat;


/**
 * Import controller
 */
class ImportController extends Controller
{

    public $defaultAction = 'index';
    /**
     * import action.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $videos = ['wmiHyJcBc6A', 'sAvqBto3uLI', 'bjxjAESwejE', 'OiMdznIjXnw', 'h3RLiRaXM_8'];

        foreach($videos as $video){
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl('https://www.googleapis.com/youtube/v3/videos')
                ->setData(['id' => $video, 'key' => 'AIzaSyA3ss8BjA5_CIKPw-flrbX3Hvg5l14_3Cg', 'part' => 'snippet,statistics'])
                ->send();

            if(isset($response->content)){
                $info = json_decode($response->content);
                $info = $info->items[0];
                //print_r($info);

                $model_video = Video::find()->where(['video_code' => $video])->one();
                if(!$model_video) {
                    $model_video = new Video;
                    $model_video->video_code = $video;
                }
                $model_video->video_title = $info->snippet->title;
                $model_video->chanel_title = $info->snippet->channelTitle;
                $model_video->video_description = $info->snippet->description;
                $model_video->video_thumb = $info->snippet->thumbnails->default->url;
                $model_video->save();

                $response_cahenel = $client->createRequest()
                    ->setMethod('GET')
                    ->setUrl('https://www.googleapis.com/youtube/v3/channels')
                    ->setData(['id' => $info->snippet->channelId, 'key' => 'AIzaSyA3ss8BjA5_CIKPw-flrbX3Hvg5l14_3Cg', 'part' => 'statistics'])
                    ->send();
                $chanel_info = json_decode($response_cahenel->content);
                $chanel_info = $chanel_info->items[0];

                $model_stat = new VideoStat;
                $model_stat->video_id = $model_video->video_id;
                $model_stat->views = $info->statistics->viewCount;
                $model_stat->coments = $info->statistics->commentCount;
                $model_stat->likes = $info->statistics->likeCount;
                $model_stat->dislikes = $info->statistics->dislikeCount;
                $model_stat->subscribers = $chanel_info->statistics->subscriberCount;
                $model_stat->created_at = date("Y-m-d H:i:s");
                $model_stat->save();
                //$model_stat->updatet_at = ;

            }
            


        }
    }
}
