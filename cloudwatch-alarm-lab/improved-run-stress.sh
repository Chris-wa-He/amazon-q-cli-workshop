#!/bin/bash
# Run stress-ng with higher CPU load (using 2 CPU cores)
/usr/bin/stress-ng --cpu 2 --cpu-load 90 --timeout 600s > /tmp/stress.log 2>&1 &
echo $! > /tmp/cpu_load_pid
chmod 666 /tmp/cpu_load_pid
echo "Started stress-ng with PID: $(cat /tmp/cpu_load_pid)"
