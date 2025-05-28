#!/bin/bash
# 直接在前台运行stress-ng,使用更激进的CPU负载参数
stress-ng --cpu 1 --cpu-load 95 --timeout 30s --metrics-brief

# 显示运行期间的CPU使用情况
top -b -n 1
