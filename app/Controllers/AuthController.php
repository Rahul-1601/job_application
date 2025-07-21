<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
  {
     public function login()
     {
        helper(['form']);
        $session= session();
//die("o");
//echo $this->request->getMethod();
        if($this->request->getMethod()==='POST')
        {
            $email= $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $selectedRole = $this->request->getPost('role');

            $userModel = new UserModel();
            $user= $userModel->where('email',$email)->first();

            if($user && password_verify($password, $user['password'])){
                if ($user['role'] !== $selectedRole) {
                    $errors = ['email' => 'Selected role does not match your account role.'];
                    return redirect()->back()->withInput()->with('errors', $errors);
                }
                $session->set('isLoggedIn', true);
                $session->set('user_id', $user['id']);
                $session->set('role', $user['role']);
                return redirect()->to('/applications');
            } else {
                $errors = [];
                if(!$user) {
                    $errors['email'] = 'No account found with this email.';
                } else {
                    $errors['password'] = 'Incorrect password.';
                }
                return redirect()->back()->withInput()->with('errors', $errors);
            }
        }
        return view('login_view');
     }

     public function logout()
     {
        session()->destroy();
        return redirect()->to('auth/login');
     }

  }