<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "video_stat".
 *
 * @property int $video_stat_id
 * @property int $video_id
 * @property int $views
 * @property int $coments
 * @property int $likes
 * @property int $dislikes
 * @property int $subscribers
 * @property string $created_at
 */
class VideoStat extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video_stat';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'views', 'coments', 'likes', 'dislikes', 'subscribers'], 'required'],
            [['video_id', 'views', 'coments', 'likes', 'dislikes', 'subscribers'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_stat_id' => 'Video Stat ID',
            'video_id' => 'Video ID',
            'views' => 'views',
            'coments' => 'Coments',
            'likes' => 'Likes',
            'dislikes' => 'Dislikes',
            'subscribers' => 'Subscribers',
            'created_at' => 'Created At',
        ];
    }
}
