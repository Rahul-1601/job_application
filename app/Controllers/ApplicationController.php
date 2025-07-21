<?php
namespace App\Controllers;

use App\Models\ApplicationModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class ApplicationController extends BaseController
{
    public function index()
    {
        return view('application/formView');
    }

    public function submit()
    {
        helper(['form']);

        if (!$this->validate([
            'first_name'         => 'required',
            'last_name'          => 'required',
            'email'              => 'required|valid_email',
            'phone_number'       => 'required|numeric|min_length[10]|max_length[10]',
            'experience_level'   => 'required',
            'preferred_location' => 'required',
            'current_location'   => 'required',
            'resume'             => 'uploaded[resume]|ext_in[resume,pdf,doc,docx]|max_size[resume,5120]',
            'terms'              => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $resume = $this->request->getFile('resume');
        $resumeName = $resume->getRandomName();
        $resume->move(WRITEPATH . 'uploads', $resumeName);

        $data = [
            'first_name'         => $this->request->getPost('first_name'),
            'last_name'          => $this->request->getPost('last_name'),
            'email'              => $this->request->getPost('email'),
            'phone_number'       => $this->request->getPost('phone_number'),
            'experience_level'   => $this->request->getPost('experience_level'),
            'preferred_location' => $this->request->getPost('preferred_location'),
            'current_location'   => $this->request->getPost('current_location'),
            'resume'             => $resumeName,
        ];

        if ($data['experience_level'] === 'experienced') {
            $data['last_salary'] = $this->request->getPost('last_salary');
            $data['total_experience'] = $this->request->getPost('total_experience');
        }

        $data['status'] = 'Pending';
        $data['created_at'] = date('Y-m-d H:i:s');

        $model = new ApplicationModel();
        $model->save($data);

        return redirect()->to('/thank-you');
    }

    public function thankYou()
    {
        return view('application/thankyou_view');
    }

    public function viewApplications()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('auth/login');
        }

        $model = new ApplicationModel();
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        $status     = $this->request->getGet('status');
        $experience = $this->request->getGet('experience');
        $position   = $this->request->getGet('position');
        $search     = $this->request->getGet('search');
        $perPage    = $this->request->getGet('per_page') ?? 10;

        $builder = $model;

        if ($user && $user['role'] === 'interviewer') {
            $builder = $builder->where('status', 'Accepted')
                               ->where('preferred_location', $user['location'])
                               ->where('position', 'Tech');
        } elseif ($user && $user['role'] === 'hr') {
            $builder = $builder->where('preferred_location', $user['location']);
        }

        if (!empty($status) && $status !== 'All') {
            $builder = $builder->where('status', $status);
        }

        if (!empty($experience) && $experience !== 'All') {
            $builder = $builder->where('experience_level', $experience);
        }

        if (!empty($position) && $position !== 'All') {
            $builder = $builder->where('position', $position);
        }

       if (!empty($search)) {
            $builder = $builder->groupStart()
                ->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $data['applications'] = $builder->paginate($perPage);
        $data['pager'] = $builder->pager;
        $data['total'] = $builder->countAllResults(false);

        $data['stats'] = [
            'pending'          => $model->where('status', 'Pending')->countAllResults(),
            'under_review'     => $model->where('status', 'Under Review')->countAllResults(),
            'interview'        => $model->where('status', 'Interview Scheduled')->countAllResults(),
            'accepted'         => $model->where('status', 'Accepted')->countAllResults(),
            'rejected'         => $model->where('status', 'Rejected')->countAllResults(),
        ];

        $data['selectedStatus'] = $status;
        $data['selectedExperience'] = $experience;
        $data['selectedPosition'] = $position;
        $data['search'] = $search;
        $data['perPage'] = $perPage;

        return view('application/view_Application', $data);
    }

    public function ajaxApplications()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setBody('Unauthorized');
        }

        $model = new ApplicationModel();
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        $status     = $this->request->getGet('status');
        $experience = $this->request->getGet('experience');
        $position   = $this->request->getGet('position');
        $search     = $this->request->getGet('search');
        $perPage    = $this->request->getGet('per_page') ?? 10;

        $builder = $model;

        if ($user && $user['role'] === 'interviewer') {
            $builder = $builder->where('status', 'Accepted')
                               ->where('preferred_location', $user['location'])
                               ->where('position', $user['department']);
        } elseif ($user && $user['role'] === 'hr') {
            $builder = $builder->where('preferred_location', $user['location']);
        }

        if (!empty($status) && $status !== 'All') {
            $builder = $builder->where('status', $status);
        }

        if (!empty($experience) && $experience !== 'All') {
            $builder = $builder->where('experience_level', $experience);
        }

        if (!empty($position) && $position !== 'All') {
            $builder = $builder->where('position', $position);
        }

        if (!empty($search)) {
            $builder = $builder->groupStart()
                ->like('first_name', $search)
                ->orLike('last_name', $search)
                ->orLike('email', $search)
                ->orLike("CONCAT(first_name, ' ', last_name)", $search)
                ->groupEnd();
        }

        $data['applications'] = $builder->paginate($perPage);
        $data['pager'] = $builder->pager;
        $data['total'] = $builder->countAllResults(false);
        $data['perPage'] = $perPage;

        return view('application/_applications_table', $data);
    }

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $id = $this->request->getPost('id');
        $newStatus = $this->request->getPost('status');

        $model = new ApplicationModel();
        $application = $model->find($id);

        if (!$application) {
            return $this->response->setJSON(['success' => false, 'message' => 'Application not found']);
        }

        if ($application['status'] === 'Accepted') {
            return $this->response->setJSON(['success' => false, 'message' => 'Status already accepted and cannot be changed']);
        }

        $updated = $model->update($id, ['status' => $newStatus]);

        if ($updated && $newStatus === 'Accepted') {
            $this->sendAcceptanceEmail($application['email'], $application['first_name']);
        }

        return $this->response->setJSON(['success' => $updated]);
    }

    private function sendAcceptanceEmail($toEmail, $name)
    {
        $email = \Config\Services::email();

        $email->setTo($toEmail);
        $email->setSubject('Job Application Accepted');
        $email->setMessage("Dear $name,\n\nCongratulations! Your application has been accepted. We will contact you soon for further process.\n\nRegards,\nHR Team");

        if (!$email->send()) {
            log_message('error', 'Failed to send acceptance email to ' . $toEmail);
        }
    }

    public function updatePosition()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $id = $this->request->getPost('id');
        $position = $this->request->getPost('position');

        if (!$id || !$position) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing data']);
        }

        $model = new ApplicationModel();
        $update = $model->update($id, ['position' => $position]);

        return $this->response->setJSON(['success' => $update]);
    }

    public function updateInterviewSchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $id = $this->request->getPost('id');
        $date = $this->request->getPost('interview_date');
        $time = $this->request->getPost('interview_time');

        if (!$id || (!$date && !$time)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing data']);
        }

        $updateData = [];
        if ($date) {
            // Validate date format (YYYY-MM-DD)
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid date format']);
            }
            $updateData['interview_date'] = $date;
        }
        if ($time) {
            // Validate time format (HH:MM)
            if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid time format']);
            }
            $updateData['interview_time'] = $time;
        }

        $model = new \App\Models\ApplicationModel();
        $updated = $model->update($id, $updateData);

        return $this->response->setJSON(['success' => $updated]);
    }

    public function getStats()
    {
        $model = new ApplicationModel();
        $stats = [
            'pending'      => $model->where('status', 'Pending')->countAllResults(),
            'under_review' => $model->where('status', 'Under Review')->countAllResults(),
            'interview'    => $model->where('status', 'Interview Scheduled')->countAllResults(),
            'accepted'     => $model->where('status', 'Accepted')->countAllResults(),
            'rejected'     => $model->where('status', 'Rejected')->countAllResults(),
        ];
        return $this->response->setJSON($stats);
    }

    public function viewResume($filename)
    {
        if (empty($filename) || strpos($filename, '..') !== false) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        $filePath = WRITEPATH . 'uploads/' . $filename;

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File not found');
        }

        $fileInfo = pathinfo($filePath);
        $extension = strtolower($fileInfo['extension']);

        $contentTypes = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

        $this->response->setHeader('Content-Type', $contentType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');
        $this->response->setHeader('Content-Length', filesize($filePath));

        return $this->response->setBody(file_get_contents($filePath));
    }
}




