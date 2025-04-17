<?php

namespace common\models;


class Status
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;

    const CORRECT = 1;
    const IN_CORRECT = 0;

    const USER_STATUS_DELETE = 0;
    const USER_STATUS_NO_FAOL = 9;
    const USER_STATUS_ACTIVE = 10;

    public static function accessStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Faol',
            self::STATUS_INACTIVE => 'No faol',
        ];
    }


    public static function grantStatus()
    {
        return [
            2 => 'Boshlash',
            3 => 'Yakunlash',
        ];
    }

    public static function gender($id = null)
    {
        $data = [
            0 => 'Ayol',
            1 => 'Erkak',
        ];
        if ($id == null) {
            return $data;
        }
        return $data[$id];
    }

    public static function userStatus($id = null)
    {
        $data = [
            self::USER_STATUS_ACTIVE => 'Faol',
            self::USER_STATUS_DELETE => 'Bloklash',
        ];
        if ($id == null) {
            return $data;
        }
        return $data[$id];
    }

    public static function userStatusUpdate($id = null)
    {
        $data = [
            self::USER_STATUS_ACTIVE => 'Faol',
            self::USER_STATUS_NO_FAOL => 'To\'liq ro\'yhatdan o\'tmagan',
            self::USER_STATUS_DELETE => 'Bloklash',
        ];
        if ($id == null) {
            return $data;
        }
        return $data[$id];
    }

    public static function ofertaStatus()
    {
        return [
            0 => 'Qabul qilinmasin',
            1 => 'Qabul qilinsin',
        ];
    }

    public static function eStatus($id = null)
    {
        $data = [
            1 => 'Test ishlamagan',
            2 => 'Testda',
            3 => 'Yakunladi',
            4 => 'Shartnoma olgan',
            5 => 'Shartnoma olmagan',
        ];
        if ($id == null) {
            return $data;
        }
        return $data[$id];
    }

    public static function botStatus($id = null)
    {
        return [
            0 => 'Jarayonda',
            1 => 'Kelib tushgan',
            2 => 'Tasdiqlangan',
        ];
    }

    public static function perevotFileStatus($id = null)
    {
        $data = [
            0 => 'File yo\'q',
            1 => 'Kelib tushgan',
            2 => 'Tasdiqlandi',
            3 => 'Bekor qilindi',
        ];
        if ($id == null) {
            return $data;
        }

        return $data[$id];
    }

    public static function perStatus()
    {
        return [
            0 => 'Yuborilmagan',
            1 => 'Kelib tushgan',
            2 => 'Tasdiqlandi',
            3 => 'Bekor qilindi',
        ];
    }

    public static function examStatus()
    {
        return [
            0 => 'Online',
            1 => 'Offline',
        ];
    }

    public static function getExamStatus($id)
    {
        $data = [
            0 => 'Online',
            1 => 'Offline',
        ];
        return $data[$id];
    }

    public static function questionLevel($id = null)
    {
        $data = [
            self::LEVEL_1 => 'Oson',
            self::LEVEL_2 => 'O\'rta',
            self::LEVEL_3 => 'Qiyin',
        ];
        if ($id == null) {
            return $data;
        } else {
            return $data[$id];
        }
    }


    public static function step($id = null)
    {
        $data = [
            1 => 'Pasport ma\'lumotini kiritmagan',
            2 => 'Qabul turini tanlamagan',
            3 => 'Yo\'nalish tanlamagan',
            4 => 'Tasdiqdalamagan',
            5 => 'To\'liq ro\'yhatdan o\'gan',
        ];
        if ($id == null) {
            return $data;
        } else {
            return $data[$id];
        }
    }

    public static function questionLevelId($id)
    {
        return [
            self::LEVEL_1 => 'Oson',
            self::LEVEL_2 => 'O\'rta',
            self::LEVEL_3 => 'Qiyin',
        ];
    }

    public static function optionIsCorrect()
    {
        return [
            self::IN_CORRECT => 'Noto\'g\'ri javob',
            self::CORRECT => 'To\'g\'ri javob',
        ];
    }

    public static function month($id)
    {
        $data = [
            1 => 'Yanvar',
            2 => 'Fevral',
            3 => 'Mart',
            4 => 'Aprel',
            5 => 'May',
            6 => 'Iyun',
            7 => 'Iyul',
            8 => 'Avgust',
            9 => 'Sentabr',
            10 => 'Oktabr',
            11 => 'Noyabr',
            12 => 'Dekabr',
        ];
        if ($id == null) {
            return $data;
        } else {
            return $data[$id * 1];
        }
    }
}