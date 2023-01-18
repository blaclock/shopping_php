<?php

class Validation
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
            'num' => 'checkNumerical', //
            'string' => 'checkString', //
            'image' => 'checkImage', //
            'radio' => 'checkRadio', //
        ];
    }

    public function validateForm($validateData)
    {
        // エラーメッセージの配列を初期化する
        $this->initErrMessage($validateData);

        foreach ($validateData as $column => $rule) {
            $validateFunctions = explode('|', $rule);
            foreach ($validateFunctions as $function) {
                // var_dump($function);
                if ($function === 'image') {
                    $this->formData[$column] = isset($_FILES[$column]) ? $_FILES[$column] : '';
                    $this->errMessage[$column] = [];
                    // $this->executeValidateFunction($this->validator[$function], $column, $this->formData[$column]);
                } else {
                    if ($function === 'radio') {
                        $this->formData[$column] = isset($_POST[$column]) ? $_POST[$column] : '';
                        $this->errMessage[$column] = [];
                    }
                    // $this->executeValidateFunction($this->validator[$function], $column, $this->formData[$column]);
                }
                $this->executeValidateFunction($this->validator[$function], $column, $this->formData[$column]);
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

    private function executeValidateFunction($function, $column, $data)
    {
        $function = explode(':', $function);
        if (count($function) === 1) {
            $action = $function[0];
            $this->$action($column, $data);
        } else {
            // $function = explode(':', $function);
            $action = $function[0];
            $option = $function[1];
            $this->$action($column, $data, $option);
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
        if (preg_match('/^\d+$/', $val) === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['num' => '数値を入力してください']);
        }
    }

    private function checkEmail($column, $val)
    {
        if (preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $val) === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['email' => 'メールアドレスを正しい形式で入力してください']);
        }
    }

    private function checkTel($column, $val)
    {
        if (preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $val) === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['email' => 'メールアドレスを正しい形式で入力してください']);
        }
    }

    private function checkImage($column, $val)
    {
        // var_dump($val);
        if ($val['error'] !== 0 && $val['size'] === 0) {
            $this->errMessage[$column] = array_merge($this->errMessage[$column], ['empty' => '入力してください']);
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

    private function checkRadio($column, $val)
    {
        if (!isset($_POST[$column])) {
            $this->formData[$column] = '';
            $this->errMessage[$column] = ['empty' => '入力してください'];
        }
    }
}
