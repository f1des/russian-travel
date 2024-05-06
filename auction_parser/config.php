<?php
  // Файл конфигурации
  // Защита от прямого доступа к этому файлу
  if (!defined('INCLUDE_CONFIG')) {
    die('111Прямой доступ к этому файлу запрещен');
  }

  // Определение константы для включения файла
  //define('INCLUDE_CONFIG', true);

  // Настройки базы данных
  $config = [
    'db' => [
      
      'host' => 'localhost', // Хост базы данных      
      'name' => 'itpbrosl_parus', // Имя базы данных      
      'user' => 'itpbrosl_parus', // Пользователь базы данных      
      'password' => ')W5DL d )YKhH[9af', // Пароль базы данных      
      'charset' => 'utf-8', // Кодировка базы данных
    ],
  ];

  $db = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['name']);
  $db->query('SET character_set_connection = ' . $config['db']['charset'] . ';');
  $db->query('SET character_set_client = ' . $config['db']['charset'] . ';');
  $db->query('SET character_set_results = ' . $config['db']['charset'] . ';');