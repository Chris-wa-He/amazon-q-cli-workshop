<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>Updated CPU Status (as of " . date('H:i:s') . ")</h3>";

// Check if process is running
if (file_exists('/tmp/cpu_load_pid')) {
    $pid = file_get_contents('/tmp/cpu_load_pid');
    $ps_output = shell_exec("ps -p $pid");
    
    if (strpos($ps_output, $pid) !== false) {
        echo "<p style='color:green'>✓ Process is running with PID: $pid</p>";
        
        // Show CPU usage
        echo "<h4>Current CPU Usage:</h4>";
        echo "<pre>";
        echo shell_exec("top -b -n 1 | head -20");
        echo "</pre>";
        
        // Show CPU load average
        $load = sys_getloadavg();
        echo "<p>Load average: <strong>" . $load[0] . ", " . $load[1] . ", " . $load[2] . "</strong></p>";
        
        // Add refresh button
        echo "<button onclick='location.reload()'>Refresh CPU Status</button>";
    } else {
        echo "<p style='color:red'>✗ Process with PID $pid is not running</p>";
    }
} else {
    echo "<p>No CPU load test is currently running</p>";
}

// Add auto-refresh
echo "<script>setTimeout(function() { location.reload(); }, 10000);</script>";
?>
