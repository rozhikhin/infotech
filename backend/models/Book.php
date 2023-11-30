<?php

namespace backend\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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
    public static function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            [['name', 'year', 'isbn'], 'required'],
            [['year', 'count'], 'integer'],
            [['description'], 'string'],
            [['name', 'isbn', 'photo'], 'string', 'max' => 255],
            [['authorBooks'], 'safe']
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
            'authorBooks' => 'Авторы'
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
        parent::afterSave($insert, $changedAttributes);
    }
}
