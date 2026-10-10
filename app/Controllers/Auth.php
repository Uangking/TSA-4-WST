<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn') === true) {
            return redirect()->to(site_url('customers'));
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if (! $this->validate([
            'username' => 'required|max_length[50]',
            'password' => 'required|max_length[255]',
        ])) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->with('login_username', $username);
        }

        $user = (new UserModel())->findForLogin($username);

        if ($user === null || ! is_string($user['password']) || $user['password'] === ''
            || ! password_verify($password, $user['password'])
        ) {
            return redirect()->back()
                ->with('errors', ['credentials' => 'The username or password is incorrect.'])
                ->with('login_username', $username);
        }

        session()->regenerate(true);
        session()->set([
            'userId'      => (int) $user['id'],
            'username'    => $user['username'],
            'isLoggedIn'  => true,
        ]);

        return redirect()->to(site_url('customers'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
