<?php
use common\models\Student;
use common\models\Status;
use common\models\Course;
use yii\helpers\Url;
use common\models\Exam;

/** @var $student */

$lang = Yii::$app->language;
$this->title = Yii::t("app" , "a40");
$direction = $student->direction;
if ($student->edu_type_id == 1) {
    $exam = Exam::findOne([
        'student_id' => $student->id,
        'direction_id' => $direction->id,
        'is_deleted' => 0
    ]);
}
?>
<div class="hpage">
    <div class="htitle">
        <h5><?= Yii::t("app" , "a40") ?></h5>
        <span></span>
    </div>

    <?php if ($student->edu_type_id == 1) : ?>
        <?php if ($exam) : ?>
            <div class="down_box mt-4">
                <div class="down_content">
                    <div class="d-flex justify-content-center top30">
                        <a href="<?= Url::to(['cabinet/exam']) ?>" class="linkExam">
                            <?php if ($exam->status == 1) : ?>
                                <?= Yii::t("app" , "a130") ?>
                            <?php elseif ($exam->status == 2) : ?>
                                <?= Yii::t("app" , "a131") ?>
                            <?php elseif ($exam->status == 3) : ?>
                                <?= Yii::t("app" , "a132") ?>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-end index_edit top30 bot15">
        <a href="<?= Url::to(['cabinet/step' , 'id' => 1]) ?>"><?= Yii::t("app" , "a133") ?></a>
    </div>
    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-solid fa-person"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a65") ?></h6>
        </div>

        <div class="down_content">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a66") ?></p>
                            <h6><?= $student->last_name ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a67") ?></p>
                            <h6><?= $student->first_name ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a68") ?></p>
                            <h6><?= $student->middle_name ?></h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a70") ?></p>
                            <h6><?= $student->passport_serial.' '.$student->passport_number ?></h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a69") ?></p>
                            <h6><?= $student->birthday ?></h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a134") ?></p>
                            <h6><?= $student->user->username ?></h6>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a135") ?></p>
                            <h6 style="text-decoration: line-through"><?= $student->password ?></h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end index_edit top30 bot15">
        <a href="<?= Url::to(['cabinet/step' , 'id' => 2]) ?>"><?= Yii::t("app" , "a133") ?></a>
    </div>
    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-brands fa-slack"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a136") ?></h6>
        </div>

        <div class="down_content">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a136") ?></p>
                            <h6><?= $direction->eduType['name_'.$lang] ?></h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex justify-content-end index_edit top30 bot15">
        <a href="<?= Url::to(['cabinet/step' , 'id' => 3]) ?>"><?= Yii::t("app" , "a133") ?></a>
    </div>
    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-brands fa-slack"></i> &nbsp;&nbsp; <?= $direction->code." - ".$direction['name_'.$lang] ?></h6>
        </div>

        <div class="down_content">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a59") ?></p>
                            <h6><?= $direction->language['name_'.$lang] ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="down_content_box">
                        <div class="down_content_box_left">
                            <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <div class="down_content_box_right">
                            <p><?= Yii::t("app" , "a60") ?></p>
                            <h6><?= $direction->eduForm['name_'.$lang] ?></h6>
                        </div>
                    </div>
                </div>

                <?php if ($student->edu_type_id == 1) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="down_content_box">
                            <div class="down_content_box_left">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                            <div class="down_content_box_right">
                                <p><?= Yii::t("app" , "a64") ?></p>
                                <h6><?= Status::getExamStatus($student->exam_type) ?></h6>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($student->edu_type_id == 2) : ?>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="down_content_box">
                            <div class="down_content_box_left">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                            <div class="down_content_box_right">
                                <p><?= Yii::t("app" , "a81") ?></p>
                                <?php $courseName = Course::findOne(['id' => ($student->course_id + 1)]) ?>
                                <h6><?= $courseName['name_'.$lang] ?></h6>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>

</div>


