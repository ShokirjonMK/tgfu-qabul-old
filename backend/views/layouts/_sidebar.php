<?php
use yii\helpers\Url;
use common\models\Menu;
use common\models\Education;
use common\models\Permission;
use common\models\EduYear;
use common\models\EduYearType;

$user = Yii::$app->user->identity;
$role = $user->authItem;
$logo = "/admin/edu-assets/image/home-image/logo.svg";
$eduYear = EduYear::find()->where(['is_deleted' => 0 , 'status' => 1])->one();
$eduYearTypes = EduYearType::find()
    ->where(['edu_year_id' => $eduYear->id, 'status' => 1, 'is_deleted' => 0])->all();

function getActive($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return [
            'style' => 'display: block;',
            'class' => 'menu_active',
        ];
    } else {
        return [
            'style' => '',
            'class' => '',
        ];
    }
}

function getActiveSubMenu($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return "sub_menu_active";
    } else {
        return false;
    }
}

function getActiveTwo($cont, $act)
{
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if ($controller == $cont && $action == $act) {
        return "active_menu";
    } else {
        return false;
    }
}
?>

<div id="sidebar" class="root_left">
    <div class="sidebar-item">
        <div class="close_button">
            <span></span>
            <span></span>
        </div>
        <div class="sidebar-logo">
            <a href="<?= Url::to(['/site/index']) ?>">
                <img src="/frontend/web/images/tgfu-logo-notext.svg" alt="">
            </a>
        </div>

        <div class="sidebar_menu">
            <ul class="sidebar_ul">
                <li class="sidebar_li">
                    <a href="<?= Url::to(['/']) ?>" class="sidebar_li_link <?= getActiveTwo( 'site', ''); ?>">
                        <i class="i-n fa-solid fa-house"></i>
                        <span>Bosh sahifa</span>
                    </a>
                </li>

                <?php if ($role->name == 'supper_admin' || $role->name == 'admin') : ?>
                    <li class="sidebar_li">
                        <a href="<?= Url::to(['employee/index']) ?>" class="sidebar_li_link">
                            <i class="i-n fa-solid fa-user-group"></i>
                            <span>Xodimlar</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role->name == 'supper_admin') : ?>
                    <li class="sidebar_li">
                        <a href="<?= Url::to(['constalting/index']) ?>" class="sidebar_li_link">
                            <i class="i-n fa-solid fa-handshake"></i>
                            <span>Hamkorlar</span>
                        </a>
                    </li>

                    <li class="sidebar_li">
                        <a href="<?= Url::to(['subjects/index']) ?>" class="sidebar_li_link <?= getActiveTwo( 'subjects', 'index'); ?>">
                            <i class="i-n fa-solid fa-book"></i>
                            <span>Fanlar</span>
                        </a>
                    </li>

                    <li class="sidebar_li">
                        <a href="<?= Url::to(['edu-year/index']) ?>" class="sidebar_li_link">
                            <i class="i-n fa-solid fa-calendar-days"></i>
                            <span>Ta'lim yillari</span>
                        </a>
                    </li>

                    <li class="sidebar_li sidebar_drop">
                        <a href="javascript: void(0);" class="sidebar_li_link">
                            <i class="i-n fa-solid fa-graduation-cap"></i>
                            <span>
                            Ta'lim shakillari
                        </span>
                            <i class="icon-n fa-solid fa-chevron-right"></i>
                        </a>
                        <div class="menu_drop">
                            <ul class="sub_menu_ul">
                                <li class="sub_menu_li">
                                    <a href="<?= Url::to(['edu-form/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                        Ta'lim shakillari
                                    </a>
                                </li>
                                <li class="sub_menu_li">
                                    <a href="<?= Url::to(['edu-year-form/index']) ?>">
                                        Yil bo'yicha
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar_li sidebar_drop">
                        <a href="javascript: void(0);" class="sidebar_li_link">
                            <i class="i-n fa-solid fa-graduation-cap"></i>
                            <span>
                            Qabul turlari
                        </span>
                            <i class="icon-n fa-solid fa-chevron-right"></i>
                        </a>
                        <div class="menu_drop">
                            <ul class="sub_menu_ul">
                                <li class="sub_menu_li">
                                    <a href="<?= Url::to(['edu-type/index']) ?>" class="<?= getActiveSubMenu('', '') ?>">
                                        Qabul turlari
                                    </a>
                                </li>
                                <li class="sub_menu_li">
                                    <a href="<?= Url::to(['edu-year-type/index']) ?>">
                                        Yil bo'yicha
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php endif; ?>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['direction/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-bars-staggered"></i>
                        <span>Yo'nalishlar</span>
                    </a>
                </li>

                <li class="sidebar_li sidebar_drop">
                    <a href="javascript: void(0);" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-graduation-cap"></i>
                        <span>
                            Arizalar
                        </span>
                        <i class="icon-n fa-solid fa-chevron-right"></i>
                    </a>
                    <div class="menu_drop">
                        <ul class="sub_menu_ul">
                            <?php if (count($eduYearTypes) > 0) : ?>
                                <?php foreach ($eduYearTypes as $eduYearType) : ?>
                                    <li class="sub_menu_li">
                                        <a href="<?= Url::to(['student/index' , 'id' => $eduYearType->id]) ?>">
                                            <?= $eduYearType->eduType->name_uz ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['student/user-step']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-graduation-cap"></i>
                        <span>Chala arizalar</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['telegram/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-brands fa-telegram"></i>
                        <span>Telegram bot</span>
                    </a>
                </li>

                <li class="sidebar_li">
                    <a href="<?= Url::to(['filial/index']) ?>" class="sidebar_li_link">
                        <i class="i-n fa-solid fa-bars-staggered"></i>
                        <span>Filiallar</span>
                    </a>
                </li>


            </ul>
        </div>

    </div>
</div>