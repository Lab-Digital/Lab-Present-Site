<?php
//numeric and string constants
define('ADMIN_ID', 1);
define('ADMIN_START_PAGE', '/admin/meta');
define('GENERAL_DATE_FORMAT', 'Y-m-d H:i:s');
define('MAX_SHORT_DESC_LEN', 180);

//errors messages
define('ERROR_QUERY', 'В данный момент невозможно подключение к базе данных.');
define('ERROR_LOGIN', 'Неверное имя пользователя или пароль.');
define('ERROR_PASS', 'Неверный пароль.');
define('ERROR_CONTACT_PHONE', 'Введен неверный номер телефона.');
define('INCORRECT_MAIL', 'Введен неверный e-mail.');

//database consts
define('opEQ', '=');
define('opNE', '<>');
define('opGT', '>');
define('opGE', '>=');
define('opLT', '<');
define('opLE', '<=');
define('cOR', 'OR');
define('cAND', 'AND');
define('cNONE', '');
define('OT_ASC', 'ASC');
define('OT_DESC', 'DESC');
define('OT_RAND', 'RAND()');
define('MYSQL_NOW', 'NOW()');

define('SMARTY_APP_NAME', 'lab-present');
