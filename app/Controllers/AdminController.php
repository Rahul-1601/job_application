<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    public function settings()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to('auth/login');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->where('role !=', 'admin')->findAll();

        return view('admin/settings', $data);
    }

    public function addUser()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'first_name' => 'required|min_length[3]',
            'last_name'  => 'required|min_length[3]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
            'role'       => 'required|in_list[hr,interviewer]',
            'location'   => 'required'
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
            'location'   => $this->request->getPost('location')
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
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
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

        if ($user['role'] === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot delete admin users']);
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
} 