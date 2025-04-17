<?php
use yii\helpers\Url;
use common\models\EduYearType;
use common\models\User;
use common\models\Student;
use yii\db\Expression;
use common\models\Flayer;
use Da\QrCode\QrCode;

/** @var yii\web\View $this */
/** @var EduYearType $eduYearTypes */
/** @var User $currentUser */

$this->title = 'TOSHKENT GUMANITAR FANLAR UNIVERSITETI';
$baseQuery = Student::find()
    ->alias('s')
    ->innerJoin('user u', 's.user_id = u.id')
    ->where(['u.cons_id' => $currentUser->cons_id, 'u.user_role' => 'student']);

$falyer = Flayer::find()->where(['is_deleted' => 0]);

$user = Yii::$app->user->identity;
$thisRole = $user->user_role;
?>

<div class="ik_title_h5 mt-2 mb-4">
    <h5>Statistika</h5>
</div>

<?php if ($thisRole == 'admin' || $thisRole == 'supper_admin'): ?>
    <div class="ik_page">
        <div class="row">
            <?php if (count($eduYearTypes) > 0) : ?>
                <?php foreach ($eduYearTypes as $eduYearType) : ?>
                    <?php
                        $color = 'ik-blue';
                        if ($eduYearType->eduType->id == 2) {
                            $color = 'ik-red';
                        } elseif ($eduYearType->eduType->id == 3) {
                            $color = 'ik-blue2';
                        }
                    $query = (clone $baseQuery)
                        ->andWhere([
                            's.edu_year_type_id' => $eduYearType->id,
                            'u.step' => 5,
                            'u.cons_id' => $currentUser->cons_id,
                        ]);

                    $totalCount = $query->count();
                    $currentTime = time();
                    $startOfMonth = strtotime('first day of this month 00:00:00');
                    $endOfMonth = strtotime('last day of this month 23:59:59');
                    $currentMonthCount = (clone $query)
                        ->andWhere(['>=', 'u.created_at', $startOfMonth])
                        ->andWhere(['<=', 'u.created_at', $endOfMonth])
                        ->count();

                    $last7DaysCounts = [];
                    for ($i = 5; $i >= 0; $i--) {
                        $startOfDay = strtotime("-$i day", strtotime('today midnight'));
                        $endOfDay = $startOfDay + 86400 - 1;
                        $count = (clone $query)
                            ->andWhere(['>=', 'u.created_at', $startOfDay])
                            ->andWhere(['<=', 'u.created_at', $endOfDay])
                            ->count();
                        $last7DaysCounts[date('Y-m-d', $startOfDay)] = $count;
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 <?= $color ?> mb-4">
                        <div class="ik_edu_types">
                            <div class="ik_edu_types_item">
                                <div class="ik_edu_types_title">
                                    <h6><span></span> &nbsp;&nbsp; <?= $eduYearType->eduType->name_uz ?></h6>
                                </div>

                                <div class="ik_total_count">
                                    <div class="ik_total_count_left">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </div>
                                    <div class="ik_total_count_right">
                                        <h5><?= $totalCount ?></h5>
                                        <p>Jami arizalar soni</p>
                                    </div>
                                </div>

                                <div class="ik_old_days">
                                    <?php foreach ($last7DaysCounts as $date => $count): ?>
                                        <div class="ik_old_days_item">
                                            <div class="ik_old_days_item_box">
                                                <h6><?= date("d" , strtotime($date)) ?></h6>
                                                <p><?= date("F" , strtotime($date)) ?></p>
                                            </div>
                                            <div class="ik_old_days_item_count">
                                                <h6><?= $count ?></h6>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="col-lg-4 col-md-6 col-sm-12 <?= $color ?> mb-4">
                <div class="ik_edu_types">
                    <div class="ik_edu_types_item">
                        <div class="ik_edu_types_title">
                            <h6><span></span> &nbsp;&nbsp; Flayer</h6>
                        </div>

                        <div class="ik_total_count">
                            <div class="ik_total_count_left">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div class="ik_total_count_right">
                                <h5><?= $falyer->count() ?></h5>
                                <p>Jami soni</p>
                            </div>
                        </div>

                        <div class="ik_old_days">
                            <?php
                            $flayerLast7DaysCounts = [];
                            for ($i = 5; $i >= 0; $i--) {
                                $startOfDay = strtotime("-$i day", strtotime('today midnight'));
                                $endOfDay = $startOfDay + 86400 - 1;
                                $count = (clone $falyer)
                                    ->andWhere(['>=', 'created_at', $startOfDay])
                                    ->andWhere(['<=', 'created_at', $endOfDay])
                                    ->count();
                                $flayerLast7DaysCounts[date('Y-m-d', $startOfDay)] = $count;
                            }
                            ?>
                            <?php foreach ($flayerLast7DaysCounts as $date => $count): ?>
                                <div class="ik_old_days_item">
                                    <div class="ik_old_days_item_box">
                                        <h6><?= date("d" , strtotime($date)) ?></h6>
                                        <p><?= date("F" , strtotime($date)) ?></p>
                                    </div>
                                    <div class="ik_old_days_item_count">
                                        <h6><?= $count ?></h6>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="ik_chala">
            <div class="row">
                <div class="col-12 ik-blue mb-4">
                    <div class="ik_edu_types">
                        <div class="ik_edu_types_item">
                            <div class="ik_edu_types_title">
                                <h6><span></span> &nbsp;&nbsp; To'liq ro'yxatdan o'tmaganlar</h6>
                            </div>

                            <div class="grid-view">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Qadamlar</th>
                                        <?php
                                        for ($y = 5; $y >= 0; $y--) {
                                            $startOfDay = strtotime("-$y day", strtotime('today midnight'));
                                            $endOfDay = $startOfDay + 86400 - 1;
                                        ?>
                                            <th><?= date('F', $startOfDay). ' - '.date('d', $startOfDay) ?></th>
                                        <?php } ?>
                                        <th>Jami</th>
                                        <th>Batafsil</th>
                                    </tr>
                                    </thead>
                                    <tbodt>
                                        <?php for ($i = 1; $i < 6; $i ++): ?>
                                            <?php
                                                $text = '';
                                                if ($i == 1) {
                                                    $text = 'SMS kod tasdiqlamaganlar';
                                                } elseif ($i == 2) {
                                                    $text = 'Pasport ma\'lumotini kiritmaganlar';
                                                } elseif ($i == 3) {
                                                    $text = 'Qabul turini tanlamaganlar';
                                                } elseif ($i == 4) {
                                                    $text = 'Yo\'nalish tanlamaganlar';
                                                } elseif ($i == 5) {
                                                    $text = 'Tasdiqlamaganlar';
                                                }
                                                $lastMonthCounts = [];
                                                for ($y = 5; $y >= 0; $y--) {
                                                    $startOfDay = strtotime("-$y day", strtotime('today midnight'));
                                                    $endOfDay = $startOfDay + 86400 - 1;
                                                    if ($i == 1) {
                                                        $montQuery = (clone $baseQuery)
                                                            ->andWhere([
                                                                'u.status' => 9,
                                                                'u.step' => 1
                                                            ]);
                                                    } else {
                                                        $montQuery = (clone $baseQuery)
                                                            ->andWhere([
                                                                'u.status' => 10,
                                                                'u.step' => $i - 1
                                                            ]);
                                                    }
                                                    $allCount = $montQuery->count();
                                                    $count = (clone $montQuery)
                                                        ->andWhere(['>=', 'u.created_at', $startOfDay])
                                                        ->andWhere(['<=', 'u.created_at', $endOfDay])
                                                        ->count();
                                                    $lastMonthCounts[date('Y-m-d', $startOfDay)] = ['count' => $count , 'all' => $allCount];
                                                }
                                            ?>
                                            <tr>
                                                <td date-label="Qadamlar"><?= $text ?></td>
                                                <?php foreach ($lastMonthCounts as $date => $data) : ?>
                                                    <td date-label="<?= date('F', $startOfDay). ' - '.date('d', $startOfDay) ?>"><?= $data['count'] ?></td>
                                                <?php endforeach; ?>
                                                <td date-label="Jami"><?= $data['all'] ?></td>
                                                <td date-label="Batafsil">
                                                    <?php
                                                    if ($i == 1) {
                                                        $params = [
                                                            'StudentSearch' => [
                                                                'status' => 9,
                                                                'step' => 1
                                                            ]
                                                        ];
                                                    } else {
                                                        $params = [
                                                            'StudentSearch' => [
                                                                'status' => 10,
                                                                'step' => $i - 1
                                                            ]
                                                        ];
                                                    }
                                                    ?>
                                                    <a href="<?= Url::to((array_merge(['student/user-step'], $params))) ?>" class='badge-table-div active'><span>Batafsil</span></a>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbodt>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
