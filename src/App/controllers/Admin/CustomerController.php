<?php

namespace App\controllers\Admin;

use App\controllers\Controller;
use HttpNotFoundException;
use Validation;

class CustomerController extends Controller
{

    public function index()
    {
        if (\App\models\Auth::checkAdmin()) {
            $customer = $this->model->get('Customer');
            list($customers, $customerNum, $pagination) = $customer->getCustomers();

            $this->view(
                'admins.customers.index',
                [
                    'customers' => $customers,
                    'customerNum' => $customerNum,
                    'pagination' => $pagination,
                ]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function top()
    {
        if (\App\models\Auth::checkAdmin()) {
            $this->view(
                'admins.customers.top',
                []
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function show()
    {
        if (\App\models\Auth::checkAdmin()) {
            $customer = $this->model->get('Customer');
            $this->view(
                'admins.customers.show',
                [
                    'customer' => $customer->getCustomer($_GET['id'])
                ]
            );
        } else {
            header('Location: ' . '/admin/login');
        }
    }

    public function destroy()
    {
        if (\App\models\Auth::checkAdmin()) {
            //session_start();
            $this->model->get('Customer')->deleteCustomer($_GET['customer_id']);
            header('Location: ' . '/admin/customers');
            // $this->view(
            //     'customers.withdraw',
            //     []
            // );
        } else {
            throw new HttpNotFoundException();
        }
    }
}
