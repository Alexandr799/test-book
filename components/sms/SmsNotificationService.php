<?php

namespace app\components\sms;

use app\models\Subscription;
use Yii;

/**
 * Сервис для отправки SMS уведомлений
 * Использует паттерн Dependency Injection для работы с разными провайдерами
 */
class SmsNotificationService
{
    /**
     * @var SmsSendableInterface
     */
    private $smsProvider;

    /**
     * @param SmsSendableInterface $smsProvider
     */
    public function __construct(SmsSendableInterface $smsProvider)
    {
        $this->smsProvider = $smsProvider;
    }

    /**
     * Отправить уведомление о новой книге всем подписчикам
     *
     * @param string $bookTitle Название книги
     * @return array ['sent' => int, 'failed' => int]
     */
    public function notifyNewBook(string $bookTitle): array
    {
        $subscriptions = Subscription::find()
            ->where(['is_active' => true])
            ->all();

        $sent = 0;
        $failed = 0;
        $providerName = $this->getProviderName();

        Yii::info("Начало отправки SMS уведомлений о книге '{$bookTitle}' через {$providerName}", 'sms');

        foreach ($subscriptions as $subscription) {
            $message = "Новая книга в каталоге: {$bookTitle}";
            $result = $this->smsProvider->send($subscription->phone, $message);
            
            if ($result['success']) {
                $sent++;
            } else {
                $failed++;
            }
        }

        Yii::info("Отправка завершена. Успешно: {$sent}, ошибок: {$failed}", 'sms');

        return [
            'sent' => $sent,
            'failed' => $failed,
        ];
    }

    /**
     * Отправить произвольное SMS
     *
     * @param string $phone Номер телефона
     * @param string $message Текст сообщения
     * @return array Результат отправки
     */
    public function send(string $phone, string $message): array
    {
        return $this->smsProvider->send($phone, $message);
    }

    /**
     * Получить текущий провайдер
     *
     * @return SmsSendableInterface
     */
    public function getProvider(): SmsSendableInterface
    {
        return $this->smsProvider;
    }

    /**
     * Получить имя текущего провайдера
     *
     * @return string
     */
    public function getProviderName(): string
    {
        $className = get_class($this->smsProvider);
        return basename(str_replace('\\', '/', $className));
    }

    /**
     * Проверить доступность сервиса
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->smsProvider->isAvailable();
    }
}

