<?php

use \App\models\Model;

class Validation extends Model
{
    private $validator;
    private $errMessage;
    private $formData;

    public function __construct()
    {
        unset($_POST['send']);
        $this->formData = $_POST;

        $this->initValidator();
    }

    public function getFormData()
    {
        return $this->formData;
    }

    private function initValidator()
    {
        $this->validator = [
            'required' => 'checkEmpty', //入力されているか
            'max' => 'checkMaxLength', //
            'min' => 'checkMinLength', //
            'unique' => 'checkUnique', //
            'email' => 'checkEmail', //
            'tel' => 'checkTel', //
            'zip' => 'checkZip', //
            'num' => 'checkNumerical', //
            'string' => 'checkString', //
            'image' => 'checkImage', //
            'csv' => 'checkCSV', //
            'radio' => 'checkRadio', //
            'password' => 'checkPassword', //
        ];
    }

    public function validateForm($validateData)
    {
        // エラーメッセージの配列を初期化する
        $this->initErrMessage($validateData);

        foreach ($validateData as $column => $rule) {
            $validateFunctions = explode('|', $rule);
            foreach ($validateFunctions as $function) {
                $this->executeValidateFunction($function, $column);
            }
        }

        $errFlag = false;
        foreach ($this->errMessage as $val) {
            if ($val !== []) {
                $errFlag = true;
                break;
            }
        }

        return [$errFlag, $this->errMessage];
    }

    private function initErrMessage($validateData)
    {
        foreach ($validateData as $key => $val) {
            $this->errMessage[$key] = [];
        }
    }

    private function executeValidateFunction($function, $column)
    {
        $function = explode(':', $function);
        if ($function[0] === 'image' || $function[0] === 'csv') {
            $this->formData[$column] = isset($_FILES[$column]) ? $_FILES[$column] : '';
            $this->errMessage[$column] = [];
        } else {
            if ($function[0] === 'radio') {
                $this->formData[$column] = isset($_POST[$column]) ? $_POST[$column] : '';
                $this->errMessage[$column] = [];
            }
        }
        // バリデーションのメソッドにオプションが指定されているか
        if (count($function) === 1) {
            $action = $this->validator[$function[0]];
            $this->$action($column, $this->formData[$column]);
        } else {
            $action = $this->validator[$function[0]];
            $option = $function[1];
            $this->$action($column, $this->formData[$column], $option);
        }
    }

    private function checkEmpty($column, $val)
    {
        if (empty($val)) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['empty' => '入力してください']);
        }
    }

    private function checkNumerical($column, $val, $characters = 0)
    {
        if (preg_match('/^\d+$/', $val) === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['num' => '0以上の数値を半角で入力してください']);
        }

        if ($characters !== 0) {
        }
    }

    private function checkUnique($column, $val, $table)
    {
        $where = " {$column} = ? ";

        $model = new Model();
        $res = $model->db->select($table, $column, $where, [$val]);
        if (count($res) > 0) {
            $this->errMessage[$column]['unique'] = '使用不可(既に登録されています)';
        }
    }

    private function checkEmail($column, $val)
    {
        if (preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $val) === 0 && !empty($val)) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], [$column => 'メールアドレスを正しい形式で入力してください']);
        }
    }

    private function checkTel($column, $val)
    {
        if (preg_match('/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/', $val) === 0 && !empty($val)) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], [$column => '電話番号を正しい形式で入力してください']);
        }
    }

    private function checkZip($column, $val)
    {
        if (preg_match('/^[0-9]{3}-[0-9]{4}$/', $val) === 0 && !empty($val)) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], [$column => '郵便番号を正しい形式で入力してください']);
        }
    }

    private function checkRadio($column, $val)
    {
        if (!isset($_POST[$column])) {
            $this->formData[$column] = '';
            $this->errMessage[$column] = ['empty' => '選択してください'];
        }
    }

    private function checkPassword($column, $val)
    {
        if (preg_match('/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i', $val) === 0 && !empty($val)) {
            // パスワード入力形式をチェック
            $this->errMessage[$column] = array_merge($this->errMessage[$column], [$column => 'パスワードを正しい形式で入力してください']);
            // 確認用パスワードが一致するかを確認
            if ($column === 'password_confirm' && $this->formData['password'] !== $val) {
                $this->errMessage[$column] = array_merge($this->errMessage[$column], ['notSame' => '確認用パスワードが一致しません']);
            }
        }
    }

    private function checkImage($column, $val, $option = '')
    {
        // var_dump($val);
        if ($option === 'update') {
            if (!empty($_FILES[$column]['name'])) {
                if ($val['error'] !== 0 && $val['size'] === 0) {
                    // var_dump($_FILES);
                    $this->errMessage[$column] = array_merge($this->errMessage[$column], ['empty' => '画像を選択してください']);
                } else {
                    if (is_uploaded_file($val['tmp_name']) === true) {
                        $image_info = getimagesize($val['tmp_name']);
                        $image_mime = ($image_info === false) ? '' : $image_info['mime'];
                        // 画像サイズが利用できるサイズいないかどうか
                        if ($val['size'] > 1048576) {
                            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['size' => 'アップロードできる画像のサイズは、1MBまでです']);
                        } elseif ((preg_match('/^image\/jpeg$/', $image_mime) === 0) && (preg_match('/^image\/png$/', $image_mime) === 0)) { // 画像の形式が利用できるタイプかどうか
                            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['type' => 'アップロードできる画像の形式は、JPEG、もしくはPNG形式だけです']);
                            // move_uploaded_file(ファイル名,名前)：アップされたファイルを新しい位置に移動させる。第二
                        } elseif (move_uploaded_file($val['tmp_name'], App\consts\CommonConst::IMG_DIR . 'products/' . $val['name']) === true) {
                            // elseif (move_uploaded_file($val['tmp_name'], './../' . 'products/' . $val['name']) === true) {
                            // echo '画像のアップロードが完了しました';
                        } else {
                            $this->errMessage[$column] = ['uploadErr' => 'ファイルをアップロードできませんでした'];
                        }
                    }
                }
            } else {
                return;
            }
        } else {
            if ($val['error'] !== 0 && $val['size'] === 0) {
                $this->errMessage[$column] = array_merge($this->errMessage[$column], ['empty' => '画像を選択してください']);
            } else {
                if (is_uploaded_file($val['tmp_name']) === true) {
                    $image_info = getimagesize($val['tmp_name']);
                    $image_mime = ($image_info === false) ? '' : $image_info['mime'];
                    // 画像サイズが利用できるサイズいないかどうか
                    if ($val['size'] > 1048576) {
                        $this->errMessage[$column] = array_merge($this->errMessage[$column], ['size' => 'アップロードできる画像のサイズは、1MBまでです']);
                    } elseif ((preg_match('/^image\/jpeg$/', $image_mime) === 0) && (preg_match('/^image\/png$/', $image_mime) === 0)) { // 画像の形式が利用できるタイプかどうか
                        $this->errMessage[$column] = array_merge($this->errMessage[$column], ['type' => 'アップロードできる画像の形式は、JPEG、もしくはPNG形式だけです']);
                        // move_uploaded_file(ファイル名,名前)：アップされたファイルを新しい位置に移動させる。第二
                    } elseif (move_uploaded_file($val['tmp_name'], App\consts\CommonConst::IMG_DIR . 'products/' . $val['name']) === true) {
                        // elseif (move_uploaded_file($val['tmp_name'], './../' . 'products/' . $val['name']) === true) {
                        // echo '画像のアップロードが完了しました';
                    } else {
                        $this->errMessage[$column] = ['uploadErr' => 'ファイルをアップロードできませんでした'];
                    }
                }
            }
        }
    }

    public function checkCSV($column, $val)
    {
        // var_dump($val);
        if ($val['error'] !== 0 && $val['size'] === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['empty' => 'ファイルを選択してください']);
        } else {
            if (is_uploaded_file($val['tmp_name']) === true) {
                $csv_type = $val['type'];
                // 画像サイズが利用できるサイズいないかどうか
                if ((preg_match('/^text\/csv$/', $csv_type) === 0)) { // 画像の形式が利用できるタイプかどうか
                    $this->errMessage[$column] = array_merge($this->errMessage[$column], ['type' => 'アップロードできるファイルの形式は、CSV形式だけです']);
                    // move_uploaded_file(ファイル名,名前)：アップされたファイルを新しい位置に移動させる。第二
                } elseif (move_uploaded_file($val['tmp_name'], App\consts\CommonConst::RESOURCE_DIR . 'csv/' . $val['name']) === true) {
                    // elseif (move_uploaded_file($val['tmp_name'], './../' . 'products/' . $val['name']) === true) {
                    // echo '画像のアップロードが完了しました';
                } else {
                    $this->errMessage[$column] = ['uploadErr' => 'ファイルをアップロードできませんでした'];
                }
            }
        }
    }
}
