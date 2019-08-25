<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $video_id
 * @property string $video_title
 * @property string $chanel_title
 * @property string $video_description
 * @property string $video_thumb
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_title', 'chanel_title', 'video_description', 'video_thumb'], 'required'],
            [['video_title', 'chanel_title', 'video_thumb'], 'string', 'max' => 255],
            [['video_description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'video_title' => 'Video Title',
            'chanel_title' => 'Chanel Title',
            'video_description' => 'Video Description',
            'video_thumb' => 'Video Thumb',
        ];
    }
}
