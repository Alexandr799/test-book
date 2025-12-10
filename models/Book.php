<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * Book model
 *
 * @property int $id
 * @property string $title Название книги
 * @property int $year Год издания
 * @property string|null $description Краткое описание
 * @property string|null $isbn ISBN
 * @property string|null $cover_image Изображение обложки
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Author[] $authors
 */
class Book extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $coverFile;

    /**
     * @var array IDs авторов для связи many-to-many
     */
    public $author_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y') + 10],
            [['description'], 'string'],
            [['title', 'cover_image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'trim'],
            [['isbn'], 'default', 'value' => null],
            [['isbn'], 'unique', 'message' => 'Книга с таким ISBN уже существует'],
            [['isbn'], 'match', 'pattern' => '/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i', 'message' => 'Неверный формат ISBN', 'skipOnEmpty' => true],
            [['coverFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
            [['author_ids'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название книги',
            'year' => 'Год издания',
            'description' => 'Краткое описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Изображение обложки',
            'coverFile' => 'Загрузить обложку',
            'author_ids' => 'Авторы',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('{{%book_author}}', ['book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->author_ids = $this->getAuthors()->select('id')->column();
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Обновляем связи с авторами
        $this->unlinkAll('authors', true);
        if (!empty($this->author_ids)) {
            foreach ($this->author_ids as $author_id) {
                $this->link('authors', Author::findOne($author_id));
            }
        }

        // Отправляем SMS-уведомления при создании новой книги
        if ($insert) {
            $this->sendNotifications();
        }
    }

    /**
     * Загрузка изображения обложки
     */
    public function upload()
    {
        if ($this->coverFile) {
            $filename = 'book_' . $this->id . '_' . time() . '.' . $this->coverFile->extension;
            $path = Yii::getAlias('@webroot/uploads/') . $filename;
            
            // Создаём папку если её нет
            $uploadDir = Yii::getAlias('@webroot/uploads/');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if ($this->coverFile->saveAs($path)) {
                // Удаляем старое изображение
                if ($this->cover_image) {
                    $oldFile = Yii::getAlias('@webroot/uploads/') . $this->cover_image;
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                $this->cover_image = $filename;
                return $this->save(false);
            }
        }
        return false;
    }

    /**
     * Отправка SMS-уведомлений о новой книге
     */
    protected function sendNotifications()
    {
        /** @var \app\components\sms\SmsNotificationService $smsService */
        $smsService = Yii::$app->smsService;
        $result = $smsService->notifyNewBook($this->title);
        
        Yii::info("SMS уведомления о книге '{$this->title}': отправлено {$result['sent']}, ошибок {$result['failed']}", 'sms');
    }
}

