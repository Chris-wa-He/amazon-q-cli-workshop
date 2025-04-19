import boto3
import datetime
import os
from datetime import timezone

def lambda_handler(event, context):
    """
    检查EC2实例，找出超过30天未启动的实例，并发送SNS通知
    Check EC2 instances, identify those that haven't been started for over 30 days, and send SNS notifications
    """
    # 初始化EC2和SNS客户端 | Initialize EC2 and SNS clients
    ec2_client = boto3.client('ec2')
    sns_client = boto3.client('sns')
    
    # 获取SNS主题ARN | Get SNS topic ARN
    sns_topic_arn = os.environ.get('SNS_TOPIC_ARN')
    if not sns_topic_arn:
        raise Exception("未设置SNS_TOPIC_ARN环境变量 | SNS_TOPIC_ARN environment variable is not set")
    
    # 获取当前时间 | Get current time
    current_time = datetime.datetime.now(timezone.utc)
    
    # 获取所有EC2实例 | Get all EC2 instances
    response = ec2_client.describe_instances()
    
    # 存储超过30天未启动的实例 | Store instances that haven't been started for over 30 days
    inactive_instances = []
    
    # 遍历所有实例 | Iterate through all instances
    for reservation in response['Reservations']:
        for instance in reservation['Instances']:
            instance_id = instance['InstanceId']
            instance_state = instance['State']['Name']
            
            # 检查实例是否正在运行 | Check if the instance is running
            if instance_state == 'running':
                continue
            
            # 获取实例的启动时间记录 | Get the instance's launch time
            launch_time = instance.get('LaunchTime')
            if not launch_time:
                continue
            
            # 计算实例未启动的天数 | Calculate days the instance has been inactive
            days_inactive = (current_time - launch_time).days
            
            # 如果超过30天未启动，添加到列表 | If inactive for over 30 days, add to the list
            if days_inactive >= 30:
                instance_info = {
                    'InstanceId': instance_id,
                    'State': instance_state,
                    'DaysInactive': days_inactive,
                    'InstanceType': instance.get('InstanceType', 'Unknown'),
                    'Tags': instance.get('Tags', [])
                }
                inactive_instances.append(instance_info)
    
    # 如果有超过30天未启动的实例，发送SNS通知 | If there are instances inactive for over 30 days, send SNS notification
    if inactive_instances:
        # 构建消息 | Build message
        message = "以下EC2实例超过30天未启动 | The following EC2 instances haven't been started for over 30 days:\n\n"
        
        for instance in inactive_instances:
            instance_name = "未命名 | Unnamed"
            for tag in instance.get('Tags', []):
                if tag['Key'] == 'Name':
                    instance_name = tag['Value']
                    break
            
            message += f"实例ID | Instance ID: {instance['InstanceId']}\n"
            message += f"实例名称 | Instance Name: {instance_name}\n"
            message += f"实例类型 | Instance Type: {instance['InstanceType']}\n"
            message += f"当前状态 | Current State: {instance['State']}\n"
            message += f"未启动天数 | Days Inactive: {instance['DaysInactive']}\n"
            message += "----------------------------\n"
        
        # 发送SNS通知 | Send SNS notification
        sns_client.publish(
            TopicArn=sns_topic_arn,
            Subject="EC2实例超过30天未启动警报 | EC2 Instances Inactive for Over 30 Days Alert",
            Message=message
        )
        
        return {
            'statusCode': 200,
            'body': f'发现{len(inactive_instances)}个超过30天未启动的EC2实例，已发送通知 | Found {len(inactive_instances)} EC2 instances inactive for over 30 days, notification sent'
        }
    else:
        return {
            'statusCode': 200,
            'body': '没有发现超过30天未启动的EC2实例 | No EC2 instances found inactive for over 30 days'
        }
