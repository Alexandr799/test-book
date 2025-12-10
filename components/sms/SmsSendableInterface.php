<?php

namespace app\components\sms;

/**
 * Интерфейс для отправки SMS
 */
interface SmsSendableInterface
{
    /**
     * Отправить SMS сообщение
     *
     * @param string $phone Номер телефона
     * @param string $message Текст сообщения
     * @return array Результат отправки ['success' => bool, 'message' => string, 'id' => string|null]
     */
    public function send(string $phone, string $message): array;

    /**
     * Проверить доступность сервиса
     *
     * @return bool
     */
    public function isAvailable(): bool;
}

