<?php
use yii\helpers\Url;
use common\models\Student;
use common\models\StudentPerevot;
use yii\helpers\Html;
use common\models\StudentOferta;
use common\models\StudentDtm;
use common\models\StudentMagistr;


/** @var Student $student */
/** @var Student $direction */

$lang = Yii::$app->language;
$this->title = Yii::t("app" , "a44");
$direction = $student->direction;
if ($direction->oferta == 1) {
    $oferta = StudentOferta::findOne(['direction_id' =>$direction->id,'student_id' => $student->id,'status' => 1, 'is_deleted' => 0]);
}
?>
<div class="hpage">
    <div class="htitle">
        <h5><?= Yii::t("app" , "a44") ?></h5>
        <span></span>
    </div>


    <div class="row top40">
            <?php if ($student->edu_type_id == 2) :  ?>
                <?php
                    $perevot = StudentPerevot::findOne(['direction_id' => $direction->id , 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0]);
                ?>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="cfile_box">
                        <?php if ($perevot->file_status == 0) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a82") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 1) : ?>
                            <div class="cfile_box_head_right">
                                <p><?= Yii::t("app" , "a83") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 2) : ?>
                            <div class="cfile_box_head_right active">
                                <p><?= Yii::t("app" , "a84") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 3) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a85") ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="cfile_box_head">
                            <div class="cfile_box_head_left">
                                <h5> <span></span> <?= Yii::t("app" , "a86") ?></h5>
                            </div>
                        </div>

                            <?php if ($perevot->file_status == 0) : ?>
                                <div class="cfile_box_content_question">
                                    <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a137") ?></p>
                                </div>

                                <div class="cfile_box_content_upload">
                                    <?php
                                    $url = Url::to(['file/create-tr', 'id' => $perevot->id]);
                                    echo Html::a(Yii::t("app" , "a88"), $url, [
                                        "data-bs-toggle" => "modal",
                                        "data-bs-target" => "#studentTrCreate",
                                    ]);
                                    ?>
                                </div>
                            <?php else: ?>
                                <div class="cfile_box_content">
                                    <div class="cfile_box_content_file">
                                        <div class="cfile_box_content_file_left">
                                            <a href="/frontend/web/uploads/<?= $student->id ?>/<?= $perevot->file ?>" target="_blank">
                                                <span><i class="fa-solid fa-file-export"></i></span><?= Yii::t("app" , "a89") ?>
                                            </a>
                                        </div>
                                        <div class="cfile_box_content_file_right">
                                            <?php if ($perevot->file_status != 2) :  ?>
                                                <?php
                                                $url = Url::to(['file/del-tr', 'id' => $perevot->id]);
                                                echo Html::a('<i class="fa-solid fa-trash"></i>', $url, [
                                                    'title' => Yii::t('app', 'a90'),
                                                    'class' => "sertificat_box_trash",
                                                    'id' => "sertificat_box_trashId",
                                                    "data-bs-toggle" => "modal",
                                                    "data-bs-target" => "#studentTrDelete",
                                                ]);
                                                ?>
                                            <?php endif;  ?>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            <?php elseif ($student->edu_type_id == 3) :  ?>
                <?php
                $perevot = StudentDtm::findOne(['direction_id' => $direction->id , 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0]);
                ?>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="cfile_box">
                        <?php if ($perevot->file_status == 0) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a82") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 1) : ?>
                            <div class="cfile_box_head_right">
                                <p><?= Yii::t("app" , "a83") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 2) : ?>
                            <div class="cfile_box_head_right active">
                                <p><?= Yii::t("app" , "a84") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 3) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a85") ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="cfile_box_head">
                            <div class="cfile_box_head_left">
                                <h5> <span></span> <?= Yii::t("app" , "a148") ?></h5>
                            </div>
                        </div>

                        <?php if ($perevot->file_status == 0) : ?>
                            <div class="cfile_box_content_question">
                                <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a149") ?></p>
                            </div>

                            <div class="cfile_box_content_upload">
                                <?php
                                $url = Url::to(['file/create-dtm', 'id' => $perevot->id]);
                                echo Html::a(Yii::t("app" , "a150"), $url, [
                                    "data-bs-toggle" => "modal",
                                    "data-bs-target" => "#studentTrCreate",
                                ]);
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="cfile_box_content">
                                <div class="cfile_box_content_file">
                                    <div class="cfile_box_content_file_left">
                                        <a href="/frontend/web/uploads/<?= $student->id ?>/<?= $perevot->file ?>" target="_blank">
                                            <span><i class="fa-solid fa-file-export"></i></span><?= Yii::t("app" , "a89") ?>
                                        </a>
                                    </div>
                                    <div class="cfile_box_content_file_right">
                                        <?php if ($perevot->file_status != 2) :  ?>
                                            <?php
                                            $url = Url::to(['file/del-dtm', 'id' => $perevot->id]);
                                            echo Html::a('<i class="fa-solid fa-trash"></i>', $url, [
                                                'class' => "sertificat_box_trash",
                                                'id' => "sertificat_box_trashId",
                                                "data-bs-toggle" => "modal",
                                                "data-bs-target" => "#studentTrDelete",
                                            ]);
                                            ?>
                                        <?php endif;  ?>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif ($student->edu_type_id == 4) :  ?>
                <?php
                $perevot = StudentMagistr::findOne(['direction_id' => $direction->id , 'student_id' => $student->id, 'status' => 1, 'is_deleted' => 0]);
                ?>
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="cfile_box">
                        <?php if ($perevot->file_status == 0) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a82") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 1) : ?>
                            <div class="cfile_box_head_right">
                                <p><?= Yii::t("app" , "a83") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 2) : ?>
                            <div class="cfile_box_head_right active">
                                <p><?= Yii::t("app" , "a84") ?></p>
                            </div>
                        <?php elseif ($perevot->file_status == 3) : ?>
                            <div class="cfile_box_head_right danger">
                                <p><?= Yii::t("app" , "a85") ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="cfile_box_head">
                            <div class="cfile_box_head_left">
                                <h5> <span></span> <?= Yii::t("app" , "a151") ?></h5>
                            </div>
                        </div>

                        <?php if ($perevot->file_status == 0) : ?>
                            <div class="cfile_box_content_question">
                                <p><span><i class="fa-solid fa-question"></i></span> <?= Yii::t("app" , "a152") ?></p>
                            </div>

                            <div class="cfile_box_content_upload">
                                <?php
                                $url = Url::to(['file/create-mg', 'id' => $perevot->id]);
                                echo Html::a(Yii::t("app" , "a153"), $url, [
                                    "data-bs-toggle" => "modal",
                                    "data-bs-target" => "#studentTrCreate",
                                ]);
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="cfile_box_content">
                                <div class="cfile_box_content_file">
                                    <div class="cfile_box_content_file_left">
                                        <a href="/frontend/web/uploads/<?= $student->id ?>/<?= $perevot->file ?>" target="_blank">
                                            <span><i class="fa-solid fa-file-export"></i></span><?= Yii::t("app" , "a89") ?>
                                        </a>
                                    </div>
                                    <div class="cfile_box_content_file_right">
                                        <?php if ($perevot->file_status != 2) :  ?>
                                            <?php
                                            $url = Url::to(['file/del-mg', 'id' => $perevot->id]);
                                            echo Html::a('<i class="fa-solid fa-trash"></i>', $url, [
                                                'class' => "sertificat_box_trash",
                                                'id' => "sertificat_box_trashId",
                                                "data-bs-toggle" => "modal",
                                                "data-bs-target" => "#studentTrDelete",
                                            ]);
                                            ?>
                                        <?php endif;  ?>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;  ?>


        <?php if ($direction->oferta == 1) : ?>
            <div class="col-lg-6 col-md-12 mb-3">
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
                            echo Html::a(Yii::t("app" , "a128"), $url, [
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
        <?php endif; ?>
    </div>

</div>


<div class="modal fade" id="studentTrCreate" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="ikmodel">
                    <div class="ikmodel_item">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="studentTrCreateBody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="studentTrDelete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="ikmodel">
                <div class="ikmodel_item">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="studentTrDeleteBody">

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
    
    $('#studentTrCreate').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentTrCreateBody').load(url);
    });
    $('#studentTrDelete').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#studentTrDeleteBody').load(url);
    });
});
JS;
$this->registerJs($js);
?>