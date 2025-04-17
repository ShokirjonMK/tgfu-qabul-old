<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\User;

trait ResourceTrait
{

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    function simple_errors($errors) {
        $result = [];
        foreach ($errors as $lev1) {
             foreach ($lev1 as $key => $error) {
                 $result[] = $error;
             }
        }
        return array_unique($result);
    }

}
