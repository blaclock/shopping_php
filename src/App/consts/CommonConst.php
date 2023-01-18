<?php

namespace App\consts;

class CommonConst
{
    const APP_DIR = '/var/www/html/app/';
    const APP_URL = 'http://localhost:50080/';
    const IMG_PATH = self::APP_URL . 'App/resources/img/';
    const IMG_DIR = self::APP_DIR . 'resources/img/';
    const CSS_PATH = self::APP_URL . 'App/resources/css/';
    const JS_PATH = self::APP_URL . 'App/resources/js/';
    const REGISTER_CONFIRM = '登録確認';
    const REGISTER_BACK = '戻る';
    const REGISTER_COMPLETE = '登録完了';
    const UPDATE_CONFIRM = '更新する';
    const UPDATE_COMPLETE = '更新';
    const PAGINATION = 5;
}
