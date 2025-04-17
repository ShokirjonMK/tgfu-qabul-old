<?php
use common\models\Student;
use common\models\Exam;
use common\models\Status;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\StudentOferta;

/** @var $model */
/** @var Student $student */
/** @var $id */

$lang = Yii::$app->language;
$exam = Exam::findOne(['student_id' => $student->id, 'direction_id' => $student->direction_id, 'is_deleted' => 0]);
$examSubjects = $exam->examSubjects;
$direction = $exam->direction;
$oferta = StudentOferta::findOne(['student_id' => $student->id, 'direction_id' => $student->direction_id, 'status' => 1, 'is_deleted' => 0]);
?>

<div class="qabul">


    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-brands fa-slack"></i> &nbsp;&nbsp; <?= $direction->code." - ".$direction['name_'.$lang] ?></h6>
        </div>

        <div class="down_content">

            <div class="down_content_box">
                <div class="down_content_box_left">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
                <div class="down_content_box_right">
                    <p><?= Yii::t("app" , "a80") ?></p>
                    <h6><?= $direction->eduType['name_'.$lang] ?></h6>
                </div>
            </div>

            <div class="down_content_box">
                <div class="down_content_box_left">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
                <div class="down_content_box_right">
                    <p><?= Yii::t("app" , "a59") ?></p>
                    <h6><?= $direction->language['name_'.$lang] ?></h6>
                </div>
            </div>

            <div class="down_content_box">
                <div class="down_content_box_left">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
                <div class="down_content_box_right">
                    <p><?= Yii::t("app" , "a60") ?></p>
                    <h6><?= $direction->eduForm['name_'.$lang] ?></h6>
                </div>
            </div>

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
    </div>


    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-solid fa-book"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a95") ?></h6>
        </div>

        <div class="down_content">

            <?php foreach ($examSubjects as $subject) : ?>
                <?php $directionSubject = $subject->directionSubject ?>
                <?php $questions = $subject->studentQuestions ?>
                <div class="cfile_box bot15">

                    <?php if ($student->exam_type == 0) : ?>
                        <?php if ($subject->file_status == 0) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a82") ?></p>
                            </div>
                        <?php elseif ($subject->file_status == 1) : ?>
                            <div class="cfile_box_head_right">
                                <p><?= Yii::t("app" , "a83") ?></p>
                            </div>
                        <?php elseif ($subject->file_status == 2) : ?>
                            <div class="cfile_box_head_right active">
                                <p><?= Yii::t("app" , "a84") ?></p>
                            </div>
                        <?php elseif ($subject->file_status == 3) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a85") ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="cfile_box_head">
                        <div class="cfile_box_head_left">
                            <h5> <span></span> <?= $subject->subject['name_'.$lang] ?></h5>

                            <div class="cfile_box_head_left_info">
                                <div class="cfile_box_head_left_info_left">
                                    <p><?= Yii::t("app" , "a96") ?> </p>
                                </div>
                                <div class="cfile_box_head_left_info_right">
                                    <p><?= $directionSubject->question_count ?></p>
                                </div>
                            </div>
                            <div class="cfile_box_head_left_info">
                                <div class="cfile_box_head_left_info_left">
                                    <p><?= Yii::t("app" , "a97") ?> </p>
                                </div>
                                <div class="cfile_box_head_left_info_right">
                                    <p><?= $directionSubject->ball ?> ball</p>
                                </div>
                            </div>

                            <?php if ($student->exam_type == 0) : ?>
                                <?php if ($exam->status == 3 && $exam->ball < 10) : ?>
                                    <div class="cfile_box_head_left_info">
                                        <div class="cfile_box_head_left_info_left">
                                            <p><?= Yii::t("app" , "a98") ?> </p>
                                        </div>
                                        <div class="cfile_box_head_left_info_right">
                                            <p><?= $subject->ball ?> <?= Yii::t("app" , "a99") ?> </p>
                                        </div>
                                    </div>

                                    <ul class="result_ul">
                                        <?php foreach ($questions as $question) : ?>
                                            <li class="<?php if ($question->is_correct == 1) { echo "active";} elseif ($question->option_id != null) { echo "danger";} ?>"><?= $question->order ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($student->exam_type == 0) : ?>
                        <?php if ($subject->file_status == 0) : ?>
                            <div class="cfile_box_content_question">
                                <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a100") ?> </p>
                            </div>

                            <div class="cfile_box_content_upload">
                                <?php
                                $url = Url::to(['file/create-sertificate', 'id' => $subject->id]);
                                echo Html::a(Yii::t("app" , "a101"), $url, [
                                    "data-bs-toggle" => "modal",
                                    "data-bs-target" => "#studentSerCreate",
                                ]);
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="cfile_box_content">
                                <div class="cfile_box_content_file">
                                    <div class="cfile_box_content_file_left">
                                        <a href="/frontend/web/uploads/<?= $student->id ?>/<?= $subject->file ?>" target="_blank">
                                            <span><i class="fa-solid fa-file-export"></i></span><?= Yii::t("app" , "a89") ?>
                                        </a>
                                    </div>
                                    <div class="cfile_box_content_file_right">
                                        <?php if ($subject->file_status != 2) :  ?>
                                            <?php
                                            $url = Url::to(['file/del-sertificate', 'id' => $subject->id]);
                                            echo Html::a('<i class="fa-solid fa-trash"></i>', $url, [
                                                'title' => Yii::t('app', 'a102'),
                                                'class' => "sertificat_box_trash",
                                                'id' => "sertificat_box_trashId",
                                                "data-bs-toggle" => "modal",
                                                "data-bs-target" => "#studentSerDelete",
                                            ]);
                                            ?>
                                        <?php endif;  ?>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>


    <?php if ($direction->oferta == 1) : ?>
        <div class="down_box">

            <div class="down_title">
                <h6><i class="fa-solid fa-check-to-slot"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a103") ?> </h6>
            </div>

            <div class="down_content">

                <div class="cfile_box">
                    <?php if ($oferta->file_status == 0) : ?>
                        <div class="cfile_box_head_right danger">
                            <p><?= Yii::t("app" , "a82") ?></p>
                        </div>
                    <?php elseif ($oferta->file_status == 1) : ?>
                        <div class="cfile_box_head_right">
                            <p><?= Yii::t("app" , "a83") ?></p>
                        </div>
                    <?php elseif ($oferta->file_status == 2) : ?>
                        <div class="cfile_box_head_right active">
                            <p><?= Yii::t("app" , "a84") ?></p>
                        </div>
                    <?php elseif ($oferta->file_status == 3) : ?>
                        <div class="cfile_box_head_right danger">
                            <p><?= Yii::t("app" , "a85") ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="cfile_box_head">
                        <div class="cfile_box_head_left">
                            <h5> <span></span> <?= Yii::t("app" , "a91") ?></h5>
                        </div>
                    </div>

                    <?php if ($oferta->file_status == 0) : ?>
                        <div class="cfile_box_content_question">
                            <p><span><i class="fa-solid fa-question"></i></span>
                                <?= Yii::t("app" , "a92") ?>
                            </p>
                        </div>

                        <div class="cfile_box_content_upload">
                            <?php
                            $url = Url::to(['file/create-oferta', 'id' => $oferta->id]);
                            echo Html::a(Yii::t("app" , "a93"), $url, [
                                "data-bs-toggle" => "modal",
                                "data-bs-target" => "#studentOfertaCreate",
                            ]);
                            ?>
                        </div>
                    <?php else: ?>
                        <div class="cfile_box_content">
                            <div class="cfile_box_content_file">
                                <div class="cfile_box_content_file_left">
                                    <a href="/frontend/web/uploads/<?= $student->id ?>/<?= $oferta->file ?>" target="_blank">
                                        <span><i class="fa-solid fa-file-export"></i></span><?= Yii::t("app" , "a89") ?>
                                    </a>
                                </div>
                                <div class="cfile_box_content_file_right">
                                    <?php if ($oferta->file_status != 2) :  ?>
                                        <?php
                                        $url = Url::to(['file/del-oferta', 'id' => $oferta->id]);
                                        echo Html::a('<i class="fa-solid fa-trash"></i>', $url, [
                                            'title' => Yii::t('app', 'a94'),
                                            'class' => "sertificat_box_trash",
                                            'id' => "sertificat_box_trashId",
                                            "data-bs-toggle" => "modal",
                                            "data-bs-target" => "#studentSerOfertaDelete",
                                        ]);
                                        ?>
                                    <?php endif;  ?>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    <?php endif; ?>

</div>

    <div class="modal fade" id="studentSerDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="ikmodel">
                    <div class="ikmodel_item">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="studentSerDeleteBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studentSerOfertaDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="ikmodel">
                    <div class="ikmodel_item">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="studentSerOfertaDeleteBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studentSerCreate" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="ikmodel">
                    <div class="ikmodel_item">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="studentSerCreateBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studentOfertaCreate" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="ikmodel">
                    <div class="ikmodel_item">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="studentOfertaCreateBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$js = <<<JS
$(document).ready(function() {
    $('#studentSerDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerDeleteBody').load(url);
    });
    
    $('#studentSerCreate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerCreateBody').load(url);
    });
    $('#studentOfertaCreate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentOfertaCreateBody').load(url);
    });
    $('#studentSerOfertaDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerOfertaDeleteBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>