<?php
require_once 'config.php';

function hasUserTakenQuiz($con, $admin_id) {
    $sql = "SELECT COUNT(*) as quiz_count FROM quiz_attempts WHERE admin_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        return $row['quiz_count'] > 0;
    }
    
    return false;
}
?>