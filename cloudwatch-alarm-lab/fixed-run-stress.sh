#!/bin/bash
# 使用更激进的参数运行stress-ng
# --cpu-method matrixprod 使用矩阵乘法方法,这是一种计算密集型操作
# --cpu-load 95 设置95%的CPU负载
# --timeout 600s 运行10分钟
/usr/bin/stress-ng --cpu $(nproc) --cpu-method matrixprod --cpu-load 95 --timeout 600s > /tmp/stress.log 2>&1 &
echo $! > /tmp/cpu_load_pid
chmod 666 /tmp/cpu_load_pid
echo "Started stress-ng with PID: $(cat /tmp/cpu_load_pid)"
