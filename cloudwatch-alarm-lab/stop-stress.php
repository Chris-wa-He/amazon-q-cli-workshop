<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>停止CPU负载测试</h3>";

// 停止所有可能的CPU负载进程
shell_exec('pkill -f stress-ng 2>/dev/null');
shell_exec('pkill -f "yes > /dev/null" 2>/dev/null');
shell_exec('pkill -f "dd if=/dev/zero" 2>/dev/null');

// 检查是否有PID文件
if (file_exists('/tmp/cpu_load_pid')) {
    $pid = file_get_contents('/tmp/cpu_load_pid');
    shell_exec("kill -9 $pid 2>/dev/null");
    unlink('/tmp/cpu_load_pid');
    echo "已终止进程ID: $pid<br>";
}

// 检查是否使用了方法2
if (file_exists('/tmp/using_method2')) {
    unlink('/tmp/using_method2');
    echo "已终止所有yes进程<br>";
}

// 显示当前进程
echo "<h3>当前运行的进程</h3>";
echo "<pre>";
echo shell_exec("ps aux | grep -E 'stress|yes|dd' | grep -v grep");
echo "</pre>";

// 显示当前CPU负载
$load = sys_getloadavg();
echo "<h3>当前系统负载</h3>";
echo "1分钟平均负载: <strong>" . $load[0] . "</strong><br>";
echo "5分钟平均负载: <strong>" . $load[1] . "</strong><br>";
echo "15分钟平均负载: <strong>" . $load[2] . "</strong><br>";

// 显示CPU使用率
echo "<h3>CPU使用率</h3>";
$cpu_usage = shell_exec("top -bn1 | grep 'Cpu(s)' | awk '{print $2 + $4}'");
echo "CPU使用率: <strong>" . trim($cpu_usage) . "%</strong><br>";

echo "<h3>测试结果</h3>";
echo "<div id='result' style='padding: 10px; background-color: #f0f0f0; border-left: 4px solid #f44336;'>";
echo "CPU负载测试已停止。<br>";
echo "系统负载应该会在几分钟内恢复正常。<br>";
echo "</div>";
?>
