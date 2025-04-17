<?php

function current_user()
{
    return \Yii::$app->user->identity;
}

// Get current user id
function current_user_id($role)
{
    $user = \Yii::$app->user;
    $user_id = Yii::$app->user->identity;
    return is_numeric($user_id) ? $user_id : 0;
}
function isRole($string) {
    $user = Yii::$app->user->identity;
    if ($user->user_role == $string) {
        return true;
    }
    return false;
}


function current_education_id()
{
    $user = Yii::$app->user->identity;
    return $user->id;
}



function dd($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    die;
}

function getDomainFromURL($url) {
    // URL dan domen nomini ajratib olish
    $parsedUrl = parse_url($url);
    $domain = $parsedUrl['host'];

    return $domain;
}

function getIpAddress()
{
    return \Yii::$app->request->getUserIP();
}
