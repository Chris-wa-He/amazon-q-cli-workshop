# EC2 Full-Stack Operations Master Lab

This lab integrates three experiments: EC2 connectivity issues, network architecture analysis, and CloudWatch alarm configuration, creating an end-to-end practical scenario. By completing this lab, you will learn how to use Amazon Q CLI to diagnose and solve EC2 connection problems, analyze network architecture, and configure monitoring alarms.

## Lab Objectives

Through this lab, you will learn how to:

1. Use Amazon Q CLI to diagnose and solve EC2 connection problems
2. Analyze AWS network architecture and generate network architecture diagrams
3. Configure CloudWatch alarms to monitor EC2 instance CPU usage
4. Trigger CPU load tests and verify alarm notifications

## Prerequisites

Before starting this lab, please ensure you have:

1. Installed and configured the AWS CLI
2. Installed the Amazon Q CLI
3. Appropriate AWS permissions to create and manage resources used in this lab

### Required IAM Permissions

This lab requires specific IAM permissions, which we've separated into two roles:

1. **CloudFormation Deployment Role** - For creating the CloudFormation resources needed for the lab
2. **Operations Role** - For performing operational tasks during the lab

You can use the provided IAM role templates to create these roles:

```bash
# Deploy CloudFormation role
aws cloudformation create-stack \
  --stack-name ec2-master-lab-cf-role \
  --template-body file://cloudformation-role.yaml \
  --capabilities CAPABILITY_IAM

# Deploy operations role
aws cloudformation create-stack \
  --stack-name ec2-master-lab-ops-role \
  --template-body file://operations-role.yaml \
  --capabilities CAPABILITY_IAM
```

## Lab Architecture

This lab will deploy the following resources:

- A VPC with one public subnet and one private subnet
- An EC2 instance in the public subnet with a CPU load test web page
- An EC2 instance in the private subnet for network analysis
- Security groups (initially not allowing SSH access)
- Network ACLs (restricting public access)
- IAM roles and instance profiles

## Lab Steps

### Step 1: Deploy CloudFormation Template

1. Download the `template.yaml` file from this lab directory
2. Deploy the CloudFormation template using AWS CLI or AWS Management Console:

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

3. Wait for the stack creation to complete (approximately 5-10 minutes)

### Step 2: Diagnose and Solve EC2 Connection Issues

1. Try to connect to the EC2 instance via SSH (this will fail):

```bash
# Get the EC2 instance's public IP address
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text

# Try SSH connection
ssh ec2-user@<public-ip-address>
```

2. Use Amazon Q CLI to diagnose connection issues:

```bash
q chat
```

In Amazon Q CLI, ask:
```
My EC2 instance cannot be connected via SSH, please help me diagnose the problem
```

3. Following Amazon Q CLI's recommendations, modify the security group to allow SSH access:

```bash
# Get security group ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# Add SSH rule
aws ec2 authorize-security-group-ingress \
  --group-id <security-group-id> \
  --protocol tcp \
  --port 22 \
  --cidr 0.0.0.0/0
```

4. Following Amazon Q CLI's recommendations, modify the network ACL to allow SSH access:

```bash
# Get network ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text

# Add inbound SSH rule
aws ec2 create-network-acl-entry \
  --network-acl-id <network-acl-id> \
  --ingress \
  --rule-number 110 \
  --protocol 6 \
  --port-range From=22,To=22 \
  --cidr-block 0.0.0.0/0 \
  --rule-action allow
```

5. Try SSH connection again to verify the issue is resolved:

```bash
ssh ec2-user@<public-ip-address>
```

### Step 3: Analyze Network Architecture

1. Use Amazon Q CLI to analyze network architecture:

```bash
q chat
```

In Amazon Q CLI, ask:
```
Analyze my VPC architecture, including subnets, route tables, and gateways
```

2. Request to generate a network architecture diagram:

```
Generate a network architecture diagram based on my VPC resources
```

3. Analyze the connection between public and private subnets:

```
Analyze the connection between public and private subnets
```

### Step 4: Configure CloudWatch Alarms

1. Use Amazon Q CLI to configure CPU usage alarms for the EC2 instance:

```bash
q chat
```

In Amazon Q CLI, ask:
```
Create a CloudWatch alarm for my EC2 instance when CPU usage exceeds 20%
```

2. Following Amazon Q CLI's recommendations, create an SNS topic and configure alarm notifications:

```bash
# Create SNS topic
aws sns create-topic --name EC2MasterLabAlarmTopic

# Subscribe to SNS topic (replace with your email address)
aws sns subscribe \
  --topic-arn <sns-topic-arn> \
  --protocol email \
  --notification-endpoint your-email@example.com
```

3. Create CloudWatch alarm:

```bash
# Get EC2 instance ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text

# Create alarm
aws cloudwatch put-metric-alarm \
  --alarm-name EC2MasterLabCPUAlarm \
  --alarm-description "Alarm when CPU exceeds 20%" \
  --metric-name CPUUtilization \
  --namespace AWS/EC2 \
  --statistic Average \
  --period 300 \
  --threshold 20 \
  --comparison-operator GreaterThanThreshold \
  --dimensions Name=InstanceId,Value=<instance-id> \
  --evaluation-periods 1 \
  --alarm-actions <sns-topic-arn>
```

### Step 5: Trigger CPU Load Test

1. Access the EC2 instance's CPU load test page:

```bash
# Get EC2 instance URL
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. Open the URL in a browser and click the "Start CPU Load" button

3. Wait a few minutes and observe the CloudWatch alarm status change

4. Verify that you receive an alarm notification email

### Step 6: Verify and Summarize

1. Use Amazon Q CLI to view alarm status:

```bash
q chat
```

In Amazon Q CLI, ask:
```
View the current status of my CloudWatch alarm
```

2. Stop the CPU load test:
   - Return to the EC2 instance's CPU load test page
   - Click the "Stop CPU Load" button

3. Wait a few minutes and observe the alarm status return to normal

## Clean Up Resources

After completing the lab, delete all created resources to avoid unnecessary charges:

```bash
# Delete CloudWatch alarm
aws cloudwatch delete-alarms --alarm-names EC2MasterLabCPUAlarm

# Delete SNS topic (optional)
aws sns delete-topic --topic-arn <sns-topic-arn>

# Delete CloudFormation stack
aws cloudformation delete-stack --stack-name ec2-master-lab

# Delete IAM role stacks
aws cloudformation delete-stack --stack-name ec2-master-lab-ops-role
aws cloudformation delete-stack --stack-name ec2-master-lab-cf-role
```

## Summary

By completing this lab, you have learned how to:

1. Use Amazon Q CLI to diagnose and solve EC2 connection problems
2. Analyze AWS network architecture and understand the relationships between different components
3. Configure CloudWatch alarms to monitor EC2 instance performance
4. Trigger and verify alarm notifications

These skills are valuable for daily operations and troubleshooting in AWS environments. Amazon Q CLI provides a simple yet powerful way to perform these tasks without having to remember complex AWS CLI commands or navigate the AWS Management Console.

1. Download the `template.yaml` file from this lab directory
2. Deploy the CloudFormation template using AWS CLI or AWS Management Console:

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

3. Wait for the stack creation to complete (approximately 5-10 minutes)

### Step 2: Diagnose and Solve EC2 Connection Issues

1. Try to connect to the EC2 instance via SSH (this will fail):

```bash
# Get the EC2 instance's public IP address
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text

# Try SSH connection
ssh ec2-user@<public-ip-address>
```

2. Use Amazon Q CLI to diagnose connection issues:

```bash
q chat
```

In Amazon Q CLI, ask:
```
My EC2 instance cannot be connected via SSH, please help me diagnose the problem
```

3. Following Amazon Q CLI's recommendations, modify the security group to allow SSH access:

```bash
# Get security group ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# Add SSH rule
aws ec2 authorize-security-group-ingress \
  --group-id <security-group-id> \
  --protocol tcp \
  --port 22 \
  --cidr 0.0.0.0/0
```

4. Following Amazon Q CLI's recommendations, modify the network ACL to allow SSH access:

```bash
# Get network ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text

# Add inbound SSH rule
aws ec2 create-network-acl-entry \
  --network-acl-id <network-acl-id> \
  --ingress \
  --rule-number 110 \
  --protocol 6 \
  --port-range From=22,To=22 \
  --cidr-block 0.0.0.0/0 \
  --rule-action allow
```

5. Try SSH connection again to verify the issue is resolved:

```bash
ssh ec2-user@<public-ip-address>
```

### Step 3: Analyze Network Architecture

1. Use Amazon Q CLI to analyze network architecture:

```bash
q chat
```

In Amazon Q CLI, ask:
```
Analyze my VPC architecture, including subnets, route tables, and gateways
```

2. Request to generate a network architecture diagram:

```
Generate a network architecture diagram based on my VPC resources
```

3. Analyze the connection between public and private subnets:

```
Analyze the connection between public and private subnets
```

### Step 4: Configure CloudWatch Alarms

1. Use Amazon Q CLI to configure CPU usage alarms for the EC2 instance:

```bash
q chat
```

In Amazon Q CLI, ask:
```
Create a CloudWatch alarm for my EC2 instance when CPU usage exceeds 20%
```

2. Following Amazon Q CLI's recommendations, create an SNS topic and configure alarm notifications:

```bash
# Create SNS topic
aws sns create-topic --name EC2MasterLabAlarmTopic

# Subscribe to SNS topic (replace with your email address)
aws sns subscribe \
  --topic-arn <sns-topic-arn> \
  --protocol email \
  --notification-endpoint your-email@example.com
```

3. Create CloudWatch alarm:

```bash
# Get EC2 instance ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text

# Create alarm
aws cloudwatch put-metric-alarm \
  --alarm-name EC2MasterLabCPUAlarm \
  --alarm-description "Alarm when CPU exceeds 20%" \
  --metric-name CPUUtilization \
  --namespace AWS/EC2 \
  --statistic Average \
  --period 300 \
  --threshold 20 \
  --comparison-operator GreaterThanThreshold \
  --dimensions Name=InstanceId,Value=<instance-id> \
  --evaluation-periods 1 \
  --alarm-actions <sns-topic-arn>
```

### Step 5: Trigger CPU Load Test

1. Access the EC2 instance's CPU load test page:

```bash
# Get EC2 instance URL
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. Open the URL in a browser and click the "Start CPU Load" button

3. Wait a few minutes and observe the CloudWatch alarm status change

4. Verify that you receive an alarm notification email

### Step 6: Verify and Summarize

1. Use Amazon Q CLI to view alarm status:

```bash
q chat
```

In Amazon Q CLI, ask:
```
View the current status of my CloudWatch alarm
```

2. Stop the CPU load test:
   - Return to the EC2 instance's CPU load test page
   - Click the "Stop CPU Load" button

3. Wait a few minutes and observe the alarm status return to normal

## Clean Up Resources

After completing the lab, delete all created resources to avoid unnecessary charges:

```bash
# Delete CloudWatch alarm
aws cloudwatch delete-alarms --alarm-names EC2MasterLabCPUAlarm

# Delete SNS topic (optional)
aws sns delete-topic --topic-arn <sns-topic-arn>

# Delete CloudFormation stack
aws cloudformation delete-stack --stack-name ec2-master-lab

# Delete IAM role stack
aws cloudformation delete-stack --stack-name ec2-master-lab-iam
```

## Summary

By completing this lab, you have learned how to:

1. Use Amazon Q CLI to diagnose and solve EC2 connection problems
2. Analyze AWS network architecture and understand the relationships between different components
3. Configure CloudWatch alarms to monitor EC2 instance performance
4. Trigger and verify alarm notifications

These skills are valuable for daily operations and troubleshooting in AWS environments. Amazon Q CLI provides a simple yet powerful way to perform these tasks without having to remember complex AWS CLI commands or navigate the AWS Management Console.
