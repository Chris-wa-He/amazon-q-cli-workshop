#!/bin/bash
# 这个脚本用于测试CloudWatch告警功能，通过生成高CPU负载

# 使用stress工具生成CPU负载
# 如果没有安装stress，请先安装
if ! command -v stress &> /dev/null; then
    echo "正在安装stress工具..."
    sudo yum install -y stress || sudo apt-get install -y stress
fi

# 生成CPU负载，持续10分钟
echo "开始生成CPU负载，将持续10分钟..."
stress --cpu 1 --timeout 600s

echo "CPU负载测试完成。"
echo "请检查CloudWatch控制台查看告警状态变化。"
