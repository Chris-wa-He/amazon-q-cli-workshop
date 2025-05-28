<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 先杀掉所有现有的stress-ng进程
shell_exec('pkill -f stress-ng 2>/dev/null');
sleep(1);

// 直接在PHP中运行stress-ng命令,不使用中间脚本
$cmd = '/usr/bin/stress-ng --cpu $(nproc) --cpu-method matrixprod --cpu-load 95 --timeout 600s > /tmp/stress.log 2>&1 & echo $!';
$pid = trim(shell_exec($cmd));

// 保存PID到文件
file_put_contents('/tmp/cpu_load_pid', $pid);
chmod('/tmp/cpu_load_pid', 0666);

echo "命令已执行。<br>";
echo "启动stress-ng,进程ID: <strong>$pid</strong><br>";

// 给进程一点时间启动
sleep(3);

// 验证进程是否运行
if (file_exists('/tmp/cpu_load_pid')) {
    $pid = file_get_contents('/tmp/cpu_load_pid');
    $ps_output = shell_exec("ps -p $pid");
    
    echo "进程状态: <pre>$ps_output</pre>";
    
    // 显示当前CPU使用情况
    echo "当前CPU使用情况: <pre>";
    echo shell_exec("top -b -n 1 | head -20");
    echo "</pre>";
    
    // 显示stress-ng进程详情
    echo "stress-ng进程详情: <pre>";
    echo shell_exec("ps aux | grep stress-ng | grep -v grep");
    echo "</pre>";
} else {
    echo "警告: PID文件未创建。进程可能未启动。";
}
?>
