<?php

namespace App\Controllers;

use App\Models\UserModel;

class SuperAdminController extends BaseController
{
    public function settings()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'superadmin') {
            return redirect()->to('auth/login');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->findAll(); // Show all users, including admins

        return view('superadmin/settings', $data);
    }

    public function addUser()
    {
        if (!$this->request->isAJAX() && !$this->request->is('post')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'superadmin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'first_name' => 'required|min_length[3]',
            'last_name'  => 'required|min_length[3]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
            'role'       => 'required|in_list[admin,hr,interviewer]',
            'location'   => 'required',
            'department' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode(', ', $this->validator->getErrors())
            ]);
        }

        $userModel = new UserModel();
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getPost('role'),
            'location'   => $this->request->getPost('location'),
            'department' => $this->request->getPost('department')
        ];

        try {
            $userModel->insert($data);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add user: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteUser()
    {
        if (!$this->request->isAJAX() && !$this->request->is('post')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'superadmin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = $this->request->getPost('id');
        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'User ID is required']);
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }
      
        if(in_array($user['role'], ['admin', 'superadmin'])){
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot delete admin or superadmin users']);
        
        }

        try {
            $userModel->delete($userId);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ]);
        }
    }

    public function editUser()
    {
        if (!$this->request->isAJAX() && !$this->request->is('post')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'superadmin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }
        $userId = $this->request->getPost('id');
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        if (!$user || in_array($user['role'], ['admin','superadmin'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot edit this user']);
        }
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'role'       => $this->request->getPost('role'),
            'location'   => $this->request->getPost('location'),
            'department' => $this->request->getPost('department'),
        ];
        try {
            $userModel->update($userId, $data);
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }
} 