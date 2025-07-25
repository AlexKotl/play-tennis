<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Мовні ресурси нагадування пароля
    |--------------------------------------------------------------------------
    |
    | Наступні мовні рядки повертаються брокером паролів на невдалі
    | спроби оновлення пароля в таких випадках, як помилковий код скидання
    | пароля або невірний новий пароль.
    |
    */

    'reset'     => 'Ваш пароль було скинуто!',
    'sent'      => 'Посилання для скидання пароля було надіслано!',
    'throttled' => 'Будь ласка, зачекайте перед повторною спробою.',
    'token'     => 'Помилковий код скидання пароля.',
    'user'      => 'Не вдалося знайти користувача з вказаною електронною адресою.',
];
