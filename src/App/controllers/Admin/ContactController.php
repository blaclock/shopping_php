<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class ContactController extends Controller
{

    public function index()
    {
        // 管理者ログインしていたら
        if (\App\models\Auth::checkAdmin()) {
            // Productモデルのインスタンスを取得
            $contact = $this->model->get('Contact');
            $messages = $contact->getContacts();
            $contacts = $contact->getCustomers($messages);

            $this->view(
                'admins.contacts.index',
                [
                    'contacts' => $contacts
                ]
            );
        } else {
            header("Location: " . "/admin/login");
        }
    }

    public function show()
    {
        // 管理者ログインしていたら
        if (\App\models\Auth::checkAdmin()) {
            // Productモデルのインスタンスを取得
            $contact = $this->model->get('Contact');
            $contacts = $contact->getContacts($_GET['customer_id']);

            $token = uniqid('', true);
            $_SESSION['token'] = $token;

            $this->view(
                'admins.contacts.show',
                [
                    'contacts' => $contacts,
                    'token' => $token
                ]
            );
        } else {
            header("Location: " . "/admin/login");
        }
    }

    public function send()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $contact = $this->model->get('Contact');
        $customer_id = $_POST['customer_id'];

        $validation = new Validation();
        list($isError, $errMessage) = $validation->validateForm([
            'message' => 'required',
        ]);

        if ($isError) {
            $token = uniqid('', true);
            $_SESSION['token'] = $token;
            $contacts = $contact->getContacts($customer_id);
            $this->view(
                'admins.contacts.show',
                [
                    'message' => $_POST['message'],
                    'contacts' => $contacts,
                    'token' => $token,
                    'errMessage' => $errMessage
                ]
            );
        } else {
            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $sender = 'admin';
                var_dump($customer_id);
                $contact->sendMessage($customer_id, $sender);
                // header('Location: ' . '/register/completed');
                header('Location: ' . '/admin/contact?customer_id=' . $customer_id);
            } else {
                header('Location: ' . '/admin/contact?customer_id=' . $customer_id);
            }
        }
    }
}
