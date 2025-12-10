<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    
    // SMSPilot API конфигурация
    'smspilot' => [
        'apikey' => $_ENV['SMSPILOT_API_KEY'] ?? '',
    ],
];
