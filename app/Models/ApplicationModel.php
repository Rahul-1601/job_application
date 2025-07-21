<?php
namespace App\Models;
use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name', 'last_name', 'email', 'experience_level',
        'last_salary', 'total_experience', 'resume',
        'preferred_location', 'current_location',
        'status', 'created_at','position',
        'interview_date', 'interview_time'
    ];
    
}
