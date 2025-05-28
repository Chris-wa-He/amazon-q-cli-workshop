<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 清理任何现有的stress进程
shell_exec('pkill -f stress-ng 2>/dev/null');
shell_exec('pkill -f stress 2>/dev/null');
sleep(1);

// 检查stress-ng是否安装
$stress_check = shell_exec('which stress-ng 2>&1');
echo "<h3>环境检查</h3>";
echo "stress-ng路径: " . ($stress_check ? $stress_check : "未找到") . "<br>";

// 尝试使用不同的CPU压力工具
$methods = [
    // 方法1: stress-ng使用yes方法 (通常效果很好)
    "stress-ng --cpu $(nproc) --cpu-method yes --timeout 600s > /tmp/stress.log 2>&1 & echo $!",
    
    // 方法2: 使用原生yes命令 (几乎在所有系统上都可用)
    "for i in $(seq 1 $(nproc)); do yes > /dev/null & done; echo $!",
    
    // 方法3: 使用dd命令生成CPU负载
    "for i in $(seq 1 $(nproc)); do dd if=/dev/zero of=/dev/null & done; echo $!"
];

// 尝试第一种方法
echo "<h3>启动CPU负载测试</h3>";
echo "尝试方法1: stress-ng with yes method<br>";
$pid = trim(shell_exec($methods[0]));
echo "进程ID: $pid<br>";

// 保存PID到文件
file_put_contents('/tmp/cpu_load_pid', $pid);
chmod('/tmp/cpu_load_pid', 0666);

// 等待进程启动
sleep(2);

// 检查进程是否运行
$ps_output = shell_exec("ps -p $pid");
if (strpos($ps_output, $pid) !== false) {
    echo "<div style='color:green; font-weight:bold;'>✓ 方法1成功启动</div>";
} else {
    echo "<div style='color:red;'>✗ 方法1未能启动</div>";
    
    // 尝试方法2
    echo "尝试方法2: 多个yes进程<br>";
    shell_exec($methods[1]);
    echo "<div style='color:blue;'>已启动yes进程</div>";
    
    // 保存一个标记文件表示使用了方法2
    file_put_contents('/tmp/using_method2', '1');
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
echo "<div id='result' style='padding: 10px; background-color: #f0f0f0; border-left: 4px solid #4CAF50;'>";
echo "CPU负载测试已启动，请等待1-2分钟后检查CloudWatch指标。<br>";
echo "如果您看到系统负载开始上升，说明测试正在生效。<br>";
echo "</div>";

// 添加自动刷新
echo "<script>
setTimeout(function() {
    location.reload();
}, 30000); // 30秒后自动刷新
</script>";

echo "<p>页面将在30秒后自动刷新以显示最新状态</p>";
?>
