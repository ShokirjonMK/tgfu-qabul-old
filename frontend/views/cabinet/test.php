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
use common\models\Options;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Student $student */
/** @var Direction $direction */
/** @var Exam $exam */

$lang = Yii::$app->language;
$this->title = Yii::t("app" , "a141");
$questionData = $dataProvider->getModels();
$finishTime = (date("m/d/Y H:i:s", $exam->finish_time));
$examSubjects = $exam->examSubjects;
$direction = $student->direction;
?>


<div class="hpage">
    <div class="htitle">
        <h5><?= $direction->code." - ".$direction['name_'.$lang] ?></h5>
        <span></span>
    </div>

    <?php if (count($questionData) > 0) : ?>
        <div class="test_page top30">
            <div class="test_page_left">
                <?php $number = 1; ?>
                <?php foreach ($questionData as $examQuestions) : ?>
                    <?php  $question = $examQuestions->question;  ?>
                    <?php  $options = Options::options($question->id , $examQuestions->option); ?>
                    <div class="test_item">
                        <h6 class="test_item_title"><?= $examQuestions->order ?> - savol</h6>

                        <?php if ($question->text != null) : ?>
                            <div class="question-text">
                                <p><?= $question->text ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($question->image != null) : ?>
                            <div class="test_item_img">
                                <img src="/backend/web/uploads/questions/<?= $question->image ?>">
                            </div>
                        <?php endif; ?>

                        <br>

                        <div class="test_options">

                        <?php if (count($options) > 0) : ?>
                            <?php $varinat = 1; ?>
                            <?php foreach ($options as $option) : ?>

                            <div class="variants">
                                <input type="radio"
                                       name="question_name_<?= $examQuestions->order ?>"
                                       id="questionId_<?= $number ?>"
                                       data-question="<?= $examQuestions->id ?>"
                                       data-option="<?= $option->id ?>"
                                       data-order="<?= $examQuestions->order ?>"
                                    <?php if ($examQuestions->option_id == $option->id) { echo "checked";} ?>
                                       class="visually-hidden">

                                <label for="questionId_<?= $number ?>" class="test_options_label">
                                    <div class="test_options_abs">
                                        <?php
                                        $variants = ["A", "B", "C", "D", "E"];

                                        if ($varinat >= 1 && $varinat <= count($variants)) {
                                            echo $variants[$varinat - 1];
                                        } else {
                                            echo "X";
                                        }
                                        $varinat++;
                                        ?>
                                    </div>
                                    <div class="test_options_text">
                                        <?php if ($option->text != null) : ?>
                                            <div class="option-text">
                                                <?= $option->text ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($option->image != null) : ?>
                                            <div class="test_item_img">
                                                <img src="/backend/web/uploads/options/<?= $option->image ?>" alt="RASN MAVJUD EMAS">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </label>
                            </div>

                            <?php $number++ ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>

                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'linkOptions' => ['class' => 'paginationLink'],
                    'linkContainerOptions' => ['class' => 'paginationConOpt'],
                    'firstPageLabel' => '<i class="fa-solid fa-arrow-left-long"></i>',
                    'lastPageLabel' => '<i class="fa-solid fa-arrow-right-long"></i>',
                ]);
                ?>
            </div>


            <div class="test_page_right">
                <div class="test_page_right_clock">
                    <div>
                        <img src="/frontend/web/images/clock.svg" alt="">
                    </div>
                    <h5><span id="day1">00</span> : <span id="hour1">00</span> : <span id="minute1">00</span> : <span id="secund1">00</span></h5>
                </div>


                <?php if (count($examSubjects) > 0) : ?>
                    <?php foreach ($examSubjects as $examSubject) : ?>
                        <?php $subjectQuestions = $examSubject->studentQuestions; ?>
                        <div class="test_subjects">
                            <h6 class="test_subjects_title"><?= $examSubject->subject['name_'.$lang] ?></h6>
                            <?php if (count($subjectQuestions) > 0) : ?>

                                <ul>
                                    <?php foreach ($subjectQuestions as $subjectQuestion) : ?>

                                        <?php
                                            $page = (int)($subjectQuestion->order / 5);
                                            $urlPage = $page + 1;
                                        ?>

                                        <li id="order_<?= $subjectQuestion->order; ?>" class="<?php if ($subjectQuestion->option_id != null) { echo "active";} ?>">
                                            <a href="<?= Url::to(['cabinet/test' , 'page' => $urlPage , 'per-page' => 5]) ?>"><?= $subjectQuestion->order; ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="test_end top30">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><?= Yii::t("app" , "a142") ?></button>
                </div>

            </div>
        </div>
    <?php endif; ?>

</div>

    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="ikmodel">
                <div class="ikmodel_item">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert_question">
                            <div class="alert_danger_circle">
                                <div class="alert_danger_box">
                                    <i class="fa-solid fa-question"></i>
                                </div>
                            </div>
                            <p>
                                <?= Yii::t("app" , "a143") ?>
                            </p>
                        </div>

                        <div class="d-flex justify-content-around align-items-center top35">
                            <?= Html::button(Yii::t("app" , "a73"), ['class' => 'step_left_btn step_btn', 'data-bs-dismiss' => 'modal']) ?>
                            <?= Html::a(Yii::t("app" , "a144"), ['cabinet/finish', 'id' => $exam->id], ['class' => 'step_right_btn step_btn', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$js = <<<JS
    (function () {
        const   second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;
    
        const countDown = new Date(' $finishTime ').getTime();
        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = countDown - now;
            
            const d = Math.floor(distance / day);
            const h = Math.floor((distance % day) / hour);
            const m = Math.floor((distance % hour) / minute);
            const s = Math.floor((distance % minute) / second);
     
            document.getElementById("day1").innerText = formatTime(d);
            document.getElementById("hour1").innerText = formatTime(h);
            document.getElementById("minute1").innerText = formatTime(m);
            document.getElementById("secund1").innerText = formatTime(s);
            
            if (distance < 0) {
                clearInterval(x);
                window.location.reload();
                return;
            }
        }, 1000);
        
        function formatTime(time) {
            return time >= 0 ? (time < 10 ? "0" + time : time) : "--";
        }
    }());

    $(document).ready(function() {
        $(".variants input").on('change', function () {
            var question = $(this).data('question');
            var option = $(this).data('option');
            var order = $(this).data('order');
            $.ajax({
                url: '../file/option-change/',
                data: {
                    question: question,
                    option: option
                },
                type: 'POST',
                success: function (data) {
                    if (data == 1) {
                        $("#order_"+order).addClass('active');
                        $("#order1_"+order).addClass('active');
                    } else {
                        window.location.reload();   
                    }
                },
                error: function () {
                     window.location.reload();
                }
            });
        });
    });

    JS;
$this->registerJs($js);
?>