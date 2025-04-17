<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram".
 *
 * @property int $id
 * @property string|null $chat_id
 * @property int|null $step
 * @property int|null $lang_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $phone
 * @property string|null $passport_serial
 * @property string|null $passport_number
 * @property string|null $passport_pin
 * @property int|null $gender
 * @property string|null $birthday
 * @property string|null $confirm_date
 * @property string|null $username
 * @property string|null $passport_issued_date
 * @property string|null $passport_given_date
 * @property string|null $passport_given_by
 * @property int|null $edu_year_type_id
 * @property int|null $edu_year_form_id
 * @property int|null $direction_id
 * @property int|null $language_id
 * @property int|null $direction_course_id
 * @property int|null $exam_type
 * @property string|null $edu_name
 * @property string|null $edu_direction
 * @property int|null $is_deleted
 *
 * @property Direction $direction
 * @property DirectionCourse $directionCourse
 * @property EduYearForm $eduYearForm
 * @property EduYearType $eduYearType
 * @property Languages $language
 */
class Telegram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step', 'lang_id', 'gender', 'edu_year_type_id', 'edu_year_form_id', 'direction_id', 'language_id', 'direction_course_id', 'exam_type', 'is_deleted' , 'bot_status'], 'integer'],
            [['chat_id', 'first_name', 'last_name', 'middle_name', 'phone', 'passport_serial', 'passport_number', 'passport_pin', 'birthday', 'passport_issued_date', 'passport_given_date', 'passport_given_by', 'edu_name', 'edu_direction' , 'confirm_date' , 'username'], 'string', 'max' => 255],
            [['direction_course_id'], 'exist', 'skipOnError' => true, 'targetClass' => DirectionCourse::class, 'targetAttribute' => ['direction_course_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['edu_year_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearForm::class, 'targetAttribute' => ['edu_year_form_id' => 'id']],
            [['edu_year_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduYearType::class, 'targetAttribute' => ['edu_year_type_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chat_id' => 'Chat ID',
            'step' => 'Step',
            'lang_id' => 'Lang ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'phone' => 'Phone',
            'passport_serial' => 'Passport Serial',
            'passport_number' => 'Passport Number',
            'passport_pin' => 'Passport Pin',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'passport_issued_date' => 'Passport Issued Date',
            'passport_given_date' => 'Passport Given Date',
            'passport_given_by' => 'Passport Given By',
            'edu_year_type_id' => 'Edu Year Type ID',
            'edu_year_form_id' => 'Edu Year Form ID',
            'direction_id' => 'Direction ID',
            'language_id' => 'Language ID',
            'direction_course_id' => 'Direction Course ID',
            'exam_type' => 'Exam Type',
            'edu_name' => 'Edu Name',
            'edu_direction' => 'Edu Direction',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[Direction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Direction::class, ['id' => 'direction_id']);
    }

    /**
     * Gets query for [[DirectionCourse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectionCourse()
    {
        return $this->hasOne(DirectionCourse::class, ['id' => 'direction_course_id']);
    }

    /**
     * Gets query for [[EduYearForm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearForm()
    {
        return $this->hasOne(EduYearForm::class, ['id' => 'edu_year_form_id']);
    }

    /**
     * Gets query for [[EduYearType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEduYearType()
    {
        return $this->hasOne(EduYearType::class, ['id' => 'edu_year_type_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }

    public static function confirm($model)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $errors = [];

        if ($model->step != 15) {
            $errors[] = ["Ariza to'liq topshirilmagan!"];
        } else {
            if ($model->bot_status == 1) {
                $direction = Direction::findOne($model->direction_id);
                if (!$direction) {
                    $errors[] = ["Yo'nalish mavjud emas!"];
                } else {
                    $phone = Telegram::formatPhoneNumber($model->phone);
                    $userFind = User::findOne(['username' => $phone]);
                    if ($userFind) {
                        $errors[] = ["Telefon raqam avval ro'yhatga olingan!!!"];
                    } else {
                        $user = new User();
                        $user->username = $phone;
                        $user->user_role = 'student';
                        $parol = 123456;
                        $user->setPassword($parol);
                        $user->generateAuthKey();
                        $user->generateEmailVerificationToken();
                        $user->generatePasswordResetToken();
                        $user->status = 10;
                        $user->step = 5;

                        if ($user->save(false)) {
                            $newAuth = new AuthAssignment();
                            $newAuth->item_name = 'student';
                            $newAuth->user_id = $user->id;
                            $newAuth->created_at = time();
                            $newAuth->save(false);

                            $newStudent = new Student();
                            $newStudent->user_id = $user->id;
                            $newStudent->username = $user->username;
                            $newStudent->password = $phone;
                            $newStudent->first_name = $model->first_name;
                            $newStudent->last_name = $model->last_name;
                            $newStudent->middle_name = $model->middle_name;
                            $newStudent->passport_serial = $model->passport_serial;
                            $newStudent->passport_number = $model->passport_number;
                            $newStudent->passport_pin = $model->passport_pin;
                            $newStudent->gender = $model->gender;
                            $newStudent->birthday = $model->birthday;
                            $newStudent->passport_issued_date = $model->passport_issued_date;
                            $newStudent->passport_given_date = $model->passport_given_date;
                            $newStudent->passport_given_by = $model->passport_given_by;

                            $newStudent->exam_type = $model->exam_type;
                            $newStudent->edu_year_type_id = $direction->edu_year_type_id;
                            $newStudent->edu_year_form_id = $direction->edu_year_form_id;
                            $newStudent->direction_id = $direction->id;
                            $newStudent->language_id = $direction->language_id;
                            $newStudent->edu_form_id = $direction->edu_form_id;
                            $newStudent->edu_type_id = $direction->edu_type_id;

                            if ($newStudent->edu_type_id == 2) {
                                $directionCourse = DirectionCourse::find()
                                    ->where(['direction_id' => $direction->id, 'status' => 1, 'is_deleted' => 0])
                                    ->orderBy('id asc')
                                    ->one();
                                if (!$directionCourse) {
                                    $errors[] = ["Qabul qilinadigan bosqichda xatolik!!!"];
                                } else {
                                    $newStudent->direction_course_id = $directionCourse->id;
                                    $newStudent->course_id = $directionCourse->course_id;
                                }
                            }

                            $newStudent->created_by = 0;
                            $newStudent->updated_by = 0;
                            $newStudent->save(false);

                            if ($direction->oferta == 1) {
                                $oferta = new StudentOferta();
                                $oferta->user_id = $user->id;
                                $oferta->student_id = $newStudent->id;
                                $oferta->direction_id = $newStudent->direction_id;
                                $oferta->save(false);
                                $telegramOferta = TelegramOferta::findOne([
                                    'telegram_id' => $model->id,
                                    'file_status' => 1
                                ]);
                                if ($telegramOferta) {
                                    $fileName = basename($telegramOferta->file);
                                    $source = '@frontend/web/'.$telegramOferta->file;
                                    $destinationDir = '@frontend/web/uploads/'.$newStudent->id.'/';

                                    $destination = $destinationDir . $fileName;

                                    $sourcePath = Yii::getAlias($source);
                                    $destinationDirPath = Yii::getAlias($destinationDir);
                                    $destinationPath = Yii::getAlias($destination);

                                    if (!file_exists(\Yii::getAlias($destinationDirPath))) {
                                        mkdir(\Yii::getAlias($destinationDirPath), 0777, true);
                                    }

                                    if (rename($sourcePath, $destinationPath)) {
                                        $oferta->file = $fileName;
                                        $oferta->file_status = 1;
                                        $oferta->save(false);
                                        $telegramOferta->file = 'uploads/'.$newStudent->id.'/'.$fileName;
                                        $telegramOferta->save(false);
                                    } else {
                                        $errors[] = ['Fayl ko\'chirishda xatolik!!!'];
                                    }
                                } else {
                                    $errors[] = ['Oferta fayl mavjud emas. Adminga murojat qiling!!!'];
                                }
                            }

                            if ($newStudent->edu_type_id == 1) {
                                $exam = new Exam();
                                $exam->user_id = $user->id;
                                $exam->student_id = $newStudent->id;
                                $exam->direction_id = $newStudent->direction_id;
                                $exam->language_id = $newStudent->language_id;
                                $exam->edu_year_form_id = $newStudent->edu_year_form_id;
                                $exam->edu_year_type_id = $newStudent->edu_year_type_id;
                                $exam->edu_type_id = $newStudent->edu_type_id;
                                $exam->edu_form_id = $newStudent->edu_form_id;
                                $exam->save(false);

                                $directionSubjects = DirectionSubject::find()
                                    ->where([
                                        'direction_id' => $exam->direction_id,
                                        'status' => 1,
                                        'is_deleted' => 0
                                    ])->all();
                                if (count($directionSubjects) > 0) {
                                    foreach ($directionSubjects as $directionSubject) {
                                        $examSubject = new ExamSubject();
                                        $examSubject->user_id = $user->id;
                                        $examSubject->student_id = $newStudent->id;
                                        $examSubject->exam_id = $exam->id;
                                        $examSubject->direction_id = $exam->direction_id;
                                        $examSubject->direction_subject_id = $directionSubject->id;
                                        $examSubject->subject_id = $directionSubject->subject_id;
                                        $examSubject->language_id = $exam->language_id;
                                        $examSubject->edu_year_form_id = $exam->edu_year_form_id;
                                        $examSubject->edu_year_type_id = $exam->edu_year_type_id;
                                        $examSubject->edu_type_id = $exam->edu_type_id;
                                        $examSubject->edu_form_id = $exam->edu_form_id;
                                        $examSubject->save(false);
                                    }
                                } else {
                                    $errors[] = ['Yo\'nalishda fanlar mavjud emas! Aloqaga chiqing!'];
                                }
                            } elseif ($newStudent->edu_type_id == 2) {
                                $perevot = new StudentPerevot();
                                $perevot->user_id = $user->id;
                                $perevot->student_id = $newStudent->id;
                                $perevot->direction_id = $newStudent->direction_id;
                                $perevot->direction_course_id = $newStudent->direction_course_id;
                                $perevot->course_id = $newStudent->course_id;
                                $perevot->edu_name = $newStudent->edu_name;
                                $perevot->edu_direction = $newStudent->edu_direction;
                                $perevot->save(false);

                                $telegramPerevot = TelegramPerevot::findOne([
                                    'telegram_id' => $model->id,
                                    'file_status' => 1
                                ]);
                                if ($telegramPerevot) {
                                    $fileName = basename($telegramPerevot->file);
                                    $source = '@frontend/web/'.$telegramPerevot->file;
                                    $destinationDir = '@frontend/web/uploads/'.$newStudent->id.'/';

                                    $destination = $destinationDir . $fileName;

                                    $sourcePath = Yii::getAlias($source);
                                    $destinationDirPath = Yii::getAlias($destinationDir);
                                    $destinationPath = Yii::getAlias($destination);

                                    if (!file_exists(\Yii::getAlias($destinationDirPath))) {
                                        mkdir(\Yii::getAlias($destinationDirPath), 0777, true);
                                    }

                                    if (rename($sourcePath, $destinationPath)) {
                                        $perevot->file = $fileName;
                                        $perevot->file_status = 1;
                                        $perevot->save(false);
                                        $telegramPerevot->file = 'uploads/'.$newStudent->id.'/'.$fileName;
                                        $telegramPerevot->save(false);
                                    } else {
                                        $errors[] = ['Fayl ko\'chirishda xatolik!!!'];
                                    }
                                } else {
                                    $errors[] = ['Oferta fayl mavjud emas. Adminga murojat qiling!!!'];
                                }

                            } else {
                                $errors[] = ['Type ERRORS!!!'];
                            }
                        } else {
                            $errors[] = ['Student not saved.'];
                        }
                    }
                }
            } else {
                $errors[] = ["Ariza holati tasdiqash jarayonida emas!"];
            }
        }

        if (count($errors) == 0) {
            $transaction->commit();
            return ['is_ok' => true];
        }else {
            $transaction->rollBack();
            return ['is_ok' => false , 'errors' => $errors];
        }
    }
    public static function formatPhoneNumber($phoneNumber) {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        $formattedNumber = sprintf('+998 (%s) %s-%s-%s',
            substr($phoneNumber, 3, 2),
            substr($phoneNumber, 5, 3),
            substr($phoneNumber, 8, 2),
            substr($phoneNumber, 10, 2)
        );

        return $formattedNumber;
    }

    public static function sendChatSms($model)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $telegram = Yii::$app->telegram;

        $ariza = "✅  *Arizangiz muvaffaqiyatli tasdiqlandi\\.* \n\n";

        $text = "_Shartnomangiz holatini qabul\\.tpu\\.uz sayti orqali tekshirishingiz mumkin\\._ \n\n";

        $aloqa = "👩‍💻 _Aloqa uchun\\: 771292929_";

        $model->bot_status = 2;
        $model->save(false);

        return $telegram->sendMessage([
            'chat_id' => $model->chat_id,
            'text' => $ariza.$text.$aloqa,
            'parse_mode' => 'MarkdownV2',
            'reply_markup' => json_encode([
                'remove_keyboard' => true
            ])
        ]);
    }

    public static function sendCancel($model)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $telegram = Yii::$app->telegram;

        $ariza = "🚫  *Arizangiz bekor qilindi\\.* \n\n";

        $text = "_Qayta ariza berishingiz mumkin\\._ \n\n";

        $aloqa = "👩‍💻 _Aloqa uchun\\: 771292929_";

        $model->bot_status = 3;
        $model->is_deleted = 1;
        $model->save(false);

        $newUser = new Telegram();
        $newUser->chat_id = $model->chat_id;
        $newUser->username = $model->username;
        $newUser->phone = $model->phone;
        $newUser->step = 3;
        $newUser->is_deleted = 0;
        $newUser->language_id = 1;
        $newUser->save(false);

        return $telegram->sendMessage([
            'chat_id' => $model->chat_id,
            'text' => $ariza.$text.$aloqa,
            'parse_mode' => 'MarkdownV2',
            'reply_markup' => self::getLanguages()
        ]);
    }

    public static function getLanguages()
    {
        return json_encode([
            'keyboard' => [
                [
                    ['text' => "🇺🇿O‘zbek🇺🇿"],
                    ['text' => "🇷🇺Русский🇷🇺"],
                ],
            ], 'resize_keyboard' => true
        ]);
    }


}
