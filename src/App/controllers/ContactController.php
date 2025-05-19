<?php

namespace App\controllers;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class ContactController extends Controller
{

    public function index()
    {
        $contact = $this->model->get('Contact');
        $contacts = $contact->getContacts($_SESSION['customer']['id']);
        //session_start();
        if (isset($_SESSION['customer'])) {
            $token = uniqid('', true);
            $_SESSION['token'] = $token;
            $this->view(
                'contacts.index',
                [
                    'contacts' => $contacts,
                    'token' => $token
                ]
            );
        } else {
            header('Location: ' . '/login');
        }
    }

    public function send()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $customer_id = $_POST['customer_id'];
        $contact = $this->model->get('Contact');
        $contacts = $contact->getContacts($customer_id);

        $validation = new Validation();
        list($isError, $errMessage) = $validation->validateForm([
            'message' => 'required',
        ]);

        if ($isError) {
            $token = uniqid('', true);
            $_SESSION['token'] = $token;
            $this->view(
                'contacts.index',
                [
                    'message' => $_POST['message'],
                    'contacts' => $contacts,
                    'token' => $token,
                    'errMessage' => $errMessage
                ]
            );
        } else {
            $customer_id = $_SESSION['customer']['id'];

            if (isset($_POST['token']) &&  isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
                unset($_SESSION['token']);
                $contact = $this->model->get('Contact');
                $sender = 'customer';
                $contacts = $contact->sendMessage($customer_id, $sender);
                // header('Location: ' . '/register/completed');
                header('Location: ' . '/mypage/contact');
            } else {
                header('Location: ' . '/mypage/contact');
            }
        }
    }
}
