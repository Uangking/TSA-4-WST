<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = (new CustomerModel())->findAll();

        return view('customers/index', ['customers' => $customers]);
    }

    public function new(): string
    {
        return view('customers/new');
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new CustomerModel();

        if (! $model->insert([
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ])) {
            log_message('error', 'Could not create a customer record.');

            return redirect()->back()->withInput()->with('errors', [
                'full_name' => 'The customer could not be saved. Please try again.',
            ]);
        }

        return redirect()->to(site_url('customers'))->with('message', 'Customer added successfully.');
    }

    public function edit(string $id): string
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('customers/edit', ['customer' => $customer]);
    }

    public function update(string $id)
    {
        $model    = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (! $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ])) {
            log_message('error', 'Could not update customer ID {id}.', ['id' => $id]);

            return redirect()->back()->withInput()->with('errors', [
                'full_name' => 'The customer could not be updated. Please try again.',
            ]);
        }

        return redirect()->to(site_url('customers'))->with('message', 'Customer updated successfully.');
    }
}
