<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kill any existing stress-ng processes first
shell_exec('pkill -f stress-ng 2>/dev/null');

// Run stress-ng with higher CPU load
$output = shell_exec('/usr/bin/stress-ng --cpu 2 --cpu-load 90 --timeout 600s > /tmp/stress.log 2>&1 & echo $!');
$pid = trim($output);

// Save PID to file
file_put_contents('/tmp/cpu_load_pid', $pid);
chmod('/tmp/cpu_load_pid', 0666);

echo "Command executed.<br>";
echo "Started stress-ng with PID: <strong>$pid</strong><br>";

// Verify the process is running
sleep(2);
if (file_exists('/tmp/cpu_load_pid')) {
    $pid = file_get_contents('/tmp/cpu_load_pid');
    $ps_output = shell_exec("ps -p $pid");
    echo "Process status: <pre>$ps_output</pre>";
    
    // Show CPU usage
    echo "Current CPU usage: <pre>";
    echo shell_exec("top -b -n 1 | head -20");
    echo "</pre>";
    
    // Add auto-refresh meta tag to see updated CPU usage
    echo "<script>
        setTimeout(function() {
            // Fetch updated CPU info
            fetch('/cpu-status.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('cpu-status').innerHTML = data;
                });
        }, 5000);
    </script>";
    
    echo "<div id='cpu-status'></div>";
} else {
    echo "Warning: PID file not created. Process may not have started.";
}
?>
