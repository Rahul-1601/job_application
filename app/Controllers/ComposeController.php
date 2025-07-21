<?php

namespace App\Controllers;

use App\Models\MessageModel;
use CodeIgniter\Controller;

class ComposeController extends Controller
{
    public function demo()
    {
        return view('compose_demo');
    }

    public function save()
    {
        $model = new MessageModel();
        $content = $this->request->getPost('content');

        if (!$this->validate(['content' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Content is required.');
        }

        $model->save(['content' => $content]);
        return redirect()->to('compose-demo')->with('success', 'Message saved!');
    }
} 