<?php

namespace backend\services;

use backend\models\Book;
use backend\models\Subscriber;
use common\models\User;
use yii\db\StaleObjectException;
use yii\log\Logger;

class SubscribeServices
{

    public static function checkSubscribe($bookId): bool
    {
        return Subscriber::find()
            ->andWhere(['book_id' => $bookId])
            ->andWhere(['user_id' => \Yii::$app->user->getId()])
            ->exists();
    }

    public static function sendSMSToSubbscribers(Book $book)
    {
        $subscribers = Subscriber::find()
            ->andWhere(['book_id' => $book->id])
            ->all();
        if ($subscribers && $book->count) {
            include_once \Yii::getAlias('@backend') . '/components/smspilot.php';
            foreach ($subscribers as $subscriber) {
                $userPhone = User::find()
                    ->select('phone')
                    ->andWhere(['id' => $subscriber->user_id])
                    ->scalar();
                if ($userPhone) {
                    self::sendSMS($subscriber, $userPhone, $book->name);
                }
            }
        }
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    private static function sendSMS(Subscriber $subscriber, string $phone, string $bookName)
    {
        if (sms($phone,'The book ' . $bookName . ' goes on sale')) {
            $subscriber->delete();
            \Yii::getLogger()->log(
                'Успех 2 ',
                Logger::LEVEL_ERROR
            );
        } else {
            file_put_contents('TestSMS', 'Не удалось отправить сообщение подписчику на номер' . $phone . ' - ' . sms_error());
            \Yii::getLogger()->log(
                'Не удалось отправить сообщение подписчику на номер' . $phone . ' - ' . sms_error(),
                Logger::LEVEL_ERROR
            );
        }

    }

}