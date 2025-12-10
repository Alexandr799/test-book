<?php

namespace app\components\sms;

use Yii;

/**
 * Реализация отправки SMS через SMSPilot API
 * @link https://smspilot.ru/apikey.php?tab=api1
 */
class SmsPilotService implements SmsSendableInterface
{
    /**
     * @var string API ключ
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey = '')
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $phone, string $message): array
    {
        try {
            $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
            
            // Формируем URL согласно документации SMSPilot
            $url = 'https://smspilot.ru/api.php?' . http_build_query([
                'send' => $message,
                'to' => $cleanPhone,
                'apikey' => $this->apiKey,
                'format' => 'json',
            ]);
            
            // Отправляем запрос
            $response = @file_get_contents($url);
            
            if ($response === false) {
                throw new \Exception('Не удалось подключиться к SMSPilot API');
            }
            
            $result = json_decode($response, true);
            
            // Проверяем результат
            if (isset($result['error'])) {
                throw new \Exception($result['error']['description_ru'] ?? $result['error']['description']);
            }
            
            if (isset($result['send'][0]['server_id'])) {
                Yii::info("SMS успешно отправлено на {$phone}. ID: {$result['send'][0]['server_id']}", 'sms');
                
                return [
                    'success' => true,
                    'message' => 'SMS отправлено через SMSPilot',
                    'id' => $result['send'][0]['server_id'],
                ];
            }
            
            throw new \Exception('Неожиданный формат ответа от API');
            
        } catch (\Exception $e) {
            Yii::error("Ошибка отправки SMS на {$phone}: " . $e->getMessage(), 'sms');
            
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'id' => null,
            ];
        }
    }
}

