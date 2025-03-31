<?php 
require 'config.php';
use StudentEnrollment\EnrollmentSystem;

$enrollmentSystem = new EnrollmentSystem($supabase);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $courseId = $_POST['course_id'];

    $enrollmentResult = $enrollmentSystem->enrollStudent($studentId, $courseId);

    $message = $enrollmentResult
    ? "Enrollment successful!"
    : "Enrollment failed. Check prerequisites.";
}

$courses = $supabase->from('courses')->select('*')->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Enrollment System</title>
</head>
<body>
    <h1>Student Enrollment</h1>

    <?php if (isset($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Student ID: <input type="number" name="student_id" required></label>
            <label>Course:
            <select name="course_id" required>
             <?php foreach ($courses->getData() as $course): ?>
               <option value="<?=$course['course_id'] ?>">
                  <?= htmlspecialchars($course['course_name']) ?>
               </option>
            <?php endforeach; ?>
          </select>
        </label>
      <button type="submit">Enroll</button>
    </form>
</body> 
</html>