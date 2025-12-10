<?php

namespace app\components\sms;

use Yii;

/**
 * Эмулятор отправки SMS (для разработки/тестирования)
 * Логирует сообщения вместо реальной отправки
 */
class SmsEmulatorService implements SmsSendableInterface
{
    /**
     * {@inheritdoc}
     */
    public function isAvailable(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $phone, string $message): array
    {
        Yii::info("[ЭМУЛЯТОР] SMS to {$phone}: {$message}", 'sms');
        
        return [
            'success' => true,
            'message' => 'SMS эмулировано (логирование)',
            'id' => 'emulator_' . uniqid(),
        ];
    }
}

