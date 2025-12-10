<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . ($_ENV['DB_HOST'] ?? 'mysql') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'yii2_books'),
    'username' => $_ENV['DB_USER'] ?? 'yii2_user',
    'password' => $_ENV['DB_PASSWORD'] ?? 'yii2_password',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
