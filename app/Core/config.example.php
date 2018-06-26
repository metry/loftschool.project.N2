<?php
/*
 * Приложение находится в режиме логгирования ошибок
 * Для отключения логирования, необходимо закомментировать строку ниже
 */
const APPLICATION_TYPE = 'log';

/*
 * Задание соли для хэширования паролей
 */
const PASSWORD_SALT = '12a7gd6GA4SaD2GAs6gavJo2188';

/*
 * Количество фейковых пользователей и пароль к ним, при создании с использованием Faker
 */
const COUNT_FAKE_USERS = 20;
const DEFAULT_PASSWORD = 12345;

/*
 * Настройки для работы с БД
 */
const HOST = 'localhost';
const DBNAME = 'database';
const USER = 'root';
const PASS = 'password';
