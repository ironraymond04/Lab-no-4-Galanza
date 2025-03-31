<?php
namespace StudentEnrollment;

class EnrollmentSystem {
    private $supabase;

    public function __construct($supabaseClient) {
        $this->supabase = $supabaseClient;
    }

    public function enrollStudent($studentId, $courseId) {
        try {
            $result = $this->supabase
                ->rpc('enroll_student', [
                    'p_student_id' => $studentId,
                    'p_course_id' => $courseId
                ])
                ->execute();

            return $result->getData()[0] ?? false;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getStudentCourses($studentId) {
        return $this->supabase
            ->from('enrollments')
            ->select('*, courses(course_name, course_code)')
            ->eq('student_id', $studentId)
            ->execute();
    }
}

$supabaseUrl = 'https://supabase.com/dashboard/project/vpmverorsfpgvjoyvpmj';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZwbXZlcm9yc2ZwZ3Zqb3l2cG1qIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDMzODA4MTYsImV4cCI6MjA1ODk1NjgxNn0.Zd-_FjcmPBdVb64tfzlehVkJdPu61SfDmNwFgV7vp5M';
$databasePassword = 'kX8WAVaE0XKpjgQj';

require 'vendor/autoload.php';
use Supabase\SupabaseClient;

$supabaseClient = new SupabaseClient($supabaseUrl, $supabaseKey);
$enrollmentSystem = new EnrollmentSystem($supabaseClient);
?>