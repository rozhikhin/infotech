<?php

namespace frontend\models;

use backend\models\AuthorBook;
use backend\models\Subscriber;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property string $isbn
 * @property string|null $photo
 * @property int $count
 *
 * @property AuthorBook[] $authorBooks
 * @property Subscriber[] $subscribers
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'year', 'isbn'], 'required'],
            [['year', 'count'], 'integer'],
            [['description'], 'string'],
            [['name', 'isbn', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Subscribers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(Subscriber::class, ['book_id' => 'id']);
    }
}
