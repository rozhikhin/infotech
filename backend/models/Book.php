<?php

namespace backend\models;

use backend\services\FileServices;
use backend\services\SubscribeServices;
use yii\db\ActiveQuery;
use yii\web\HttpException;

/**
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $photo
 * @property int $count
 *
 * @property array $authorBooks
 * @property array authorDropdown
 * @property Subscriber[] $subscribers
 */
class Book extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            [['name', 'year', 'isbn'], 'required', 'message'=>'Поле {attribute} не может быть пустым.'],
            [['year', 'count'], 'integer'],
            [['description'], 'string'],
            [['name', 'isbn'], 'string', 'max' => 255],
            [['authorBooks'], 'safe'],
            [['imageFile'], 'file',  'extensions' => 'png, jpg, jpeg']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'Isbn',
            'photo' => 'Фото',
            'count' => 'Количество',
            'authorBooks' => 'Авторы',
            'imageFile' => 'Изображение'
        ];
    }

    public function getAuthorBooks(): array
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id'])->select('author_id')->column();
    }

    public function setAuthorBooks($authorsIds)
    {
        $this->authorBooks = $authorsIds;
    }

    public function getSubscribers(): ActiveQuery
    {
        return $this->hasMany(Subscriber::class, ['book_id' => 'id']);
    }

    /**
     * @throws HttpException
     */
    public function beforeSave($insert): bool
    {
        if (!FileServices::upload($this)) {
            throw new HttpException(500, 'Невозможно загрузить файл');
        };
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->authorBooks){
            AuthorBook::deleteAll(['book_id' => $this->id]);
            foreach ($this->authorBooks as $authorId) {
                $authorLink = new AuthorBook();
                $authorLink->book_id = $this->id;
                $authorLink->author_id = $authorId;
                $authorLink->save();
            }
        };
        SubscribeServices::sendSMSToSubbscribers($this);
        parent::afterSave($insert, $changedAttributes);
    }

}
