<?php
use yii\helpers\Url;
use common\models\Student;
use common\models\StudentPerevot;
use yii\helpers\Html;
use common\models\StudentOferta;
use common\models\Direction;
use common\models\Exam;
use common\models\Course;
use common\models\Status;
use common\models\ExamSubject;

/** @var Student $student */
/** @var Direction $direction */

$this->title = Yii::t("app" , "a120");
$lang = Yii::$app->language;
$direction = $student->direction;
if ($student->edu_type_id == 1) {
    $exam = Exam::findOne([
        'student_id' => $student->id,
        'direction_id' => $direction->id,
        'is_deleted' => 0
    ]);
    $subjects = ExamSubject::find()
        ->where([
            'direction_id' => $direction->id,
            'exam_id' => $exam->id,
            'student_id' => $student->id,
            'status' => 1,
            'is_deleted' => 0
        ])->all();
}
if ($direction->oferta == 1) {
    $oferta = StudentOferta::findOne(['direction_id' =>$direction->id,'student_id' => $student->id,'status' => 1, 'is_deleted' => 0]);
}

?>


<div class="hpage">
    <div class="htitle">
        <h5><?= Yii::t("app" , "a120") ?></h5>
        <span></span>
    </div>

    <?php if ($exam->status == 3) : ?>
        <?php if ($exam->contract_type == 1) : ?>
            <div class="down_box top30">
                <div class="down_title">
                    <h6><i class="fa-solid fa-wand-magic-sparkles"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a113") ?></h6>
                </div>
                <div class="down_content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 2]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a114") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 3]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a115") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php elseif ($exam->contract_type > 1) : ?>
            <div class="down_box top30">
                <div class="down_title">
                    <h6><i class="fa-solid fa-wand-magic-sparkles"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a118") ?></h6>
                </div>
                <div class="down_content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 2]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a114") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 3]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a115") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php elseif ($exam->contract_type < 1) : ?>
            <div class="down_box top30">
                <div class="down_title">
                    <h6><i class="fa-solid fa-wand-magic-sparkles"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a117") ?></h6>
                </div>
                <div class="down_content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 2]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a114") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a href="<?= Url::to(['file/contract' , 'type' => 3]) ?>" class="down_content_box">
                                <div class="down_content_box_left">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </div>
                                <div class="down_content_box_right">
                                    <p><?= Yii::t("app" , "a115") ?></p>
                                    <h6><?= Yii::t("app" , "a116") ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="down_box top30">

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
                            <p><?= Yii::t("app" , "a80") ?></p>
                            <h6><?= $direction->eduType['name_'.$lang] ?></h6>
                        </div>
                    </div>
                </div>
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

                <?php if ($student->exam_type == 0) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="down_content_box">
                            <div class="down_content_box_left">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                            <div class="down_content_box_right">
                                <p><?= Yii::t("app" , "a121") ?></p>
                                <h6><?= Yii::t("app" , "a122") ?></h6>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($exam->status == 3 && $exam->ball > 60) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="down_content_box">
                            <div class="down_content_box_left">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                            <div class="down_content_box_right">
                                <p><?= Yii::t("app" , "a123") ?></p>
                                <h6><?= $exam->ball ?> <?= Yii::t("app" , "a99") ?></h6>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>
    </div>


    <div class="down_box">

        <div class="down_title">
            <h6><i class="fa-solid fa-book"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a95") ?></h6>
        </div>

        <div class="down_content">

            <div class="row">
                <?php foreach ($subjects as $subject) : ?>
                    <?php $directionSubject = $subject->directionSubject ?>
                    <?php $questions = $subject->studentQuestions ?>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <div class="cfile_box">

                            <?php if ($student->exam_type == 0) : ?>
                                <?php if ($subject->file_status == 0) : ?>
                                    <div class="cfile_box_head_right danger">
                                        <p><?= Yii::t("app" , "a124") ?></p>
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
                                            <p><?= $directionSubject->ball ?> <?= Yii::t("app" , "a99") ?></p>
                                        </div>
                                    </div>

                                    <?php if ($student->exam_type == 0) : ?>
                                        <?php if ($exam->status == 3 && $exam->ball > 60 && count($questions) > 0) : ?>
                                            <div class="cfile_box_head_left_info">
                                                <div class="cfile_box_head_left_info_left">
                                                    <p><?= Yii::t("app" , "a98") ?> </p>
                                                </div>
                                                <div class="cfile_box_head_left_info_right">
                                                    <p><?= $subject->ball ?> <?= Yii::t("app" , "a99") ?></p>
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
                                        <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a125") ?></p>
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
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>



        <?php if ($direction->oferta == 1) : ?>
            <div class="down_box">

                <div class="down_title">
                    <h6><i class="fa-solid fa-check-to-slot"></i> &nbsp;&nbsp; <?= Yii::t("app" , "a103") ?></h6>
                </div>

                <div class="down_content">

                    <div class="row">
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="cfile_box">
                                <?php if ($oferta->file_status == 0) : ?>
                                    <div class="cfile_box_head_right danger">
                                        <p><?= Yii::t("app" , "a126") ?></p>
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
                                        <h5> <span></span> <?= Yii::t("app" , "a127") ?></h5>
                                    </div>
                                </div>

                                <?php if ($oferta->file_status == 0) : ?>
                                    <div class="cfile_box_content_question">
                                        <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a128") ?></p>
                                    </div>

                                    <div class="cfile_box_content_upload">
                                        <?php
                                        $url = Url::to(['file/create-oferta', 'id' => $oferta->id]);
                                        echo Html::a(Yii::t("app" , "a129"), $url, [
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
                                                        'title' => Yii::t('app', Yii::t("app" , "a94")),
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

                </div>
            </div>
        <?php endif; ?>

    <?php if ($student->exam_type == 0) : ?>
        <?php if ($exam->status < 3) : ?>
            <div class="d-flex justify-content-center top30">
                <a href="<?= Url::to(['cabinet/test']) ?>" class="linkExam">
                    <?php if ($exam->status == 1) : ?>
                        <?= Yii::t("app" , "a130") ?>
                    <?php elseif ($exam->status == 2) : ?>
                        <?= Yii::t("app" , "a131") ?>
                    <?php endif; ?>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

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

<?php
$js = <<<JS
$(document).ready(function() {
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
    
    $('#studentSerCreate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerCreateBody').load(url);
    });
    $('#studentSerDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentSerDeleteBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>