# CloudWatch Alarm Configuration Lab

This lab will guide you on how to use Amazon Q CLI to batch configure CPU utilization alarms for EC2 instances and trigger notifications when thresholds are exceeded.

## Lab Overview

In this lab, you will:
1. Deploy two EC2 instances using a CloudFormation template, each with a web interface for generating CPU load
2. Query the deployed EC2 instances using Amazon Q CLI
3. Batch configure CloudWatch alarms for these EC2 instances to monitor CPU utilization exceeding 80% for 1 minute
4. Set up SNS notifications to send email alerts when alarms are triggered
5. Test the alarm functionality using the web interface

## Prerequisites

- AWS CLI installed and configured
- Amazon Q CLI installed
- Appropriate AWS permissions to create and manage EC2 instances, CloudWatch alarms, and SNS topics

## Lab Steps

### Step 1: Deploy EC2 Instances

1. Deploy the CloudFormation template to create two EC2 instances:

```bash
aws cloudformation create-stack \
  --stack-name cloudwatch-alarm-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

2. Wait for the stack creation to complete:

```bash
aws cloudformation wait stack-create-complete --stack-name cloudwatch-alarm-lab
```

3. Get the web interface URLs for the EC2 instances:

```bash
aws cloudformation describe-stacks \
  --stack-name cloudwatch-alarm-lab \
  --query "Stacks[0].Outputs[?OutputKey=='Instance1URL' || OutputKey=='Instance2URL'].{Key:OutputKey,Value:OutputValue}" \
  --output table
```

### Step 2: Query EC2 Instances Using Amazon Q CLI

1. Start an interactive Amazon Q CLI session:

```bash
q chat
```

2. Ask Amazon Q CLI about the EC2 instances in your account:

```
Please list all EC2 instances in my current account and their status
```

3. Note the IDs of the EC2 instances you want to monitor.

### Step 3: Batch Configure CloudWatch Alarms

1. In the Amazon Q CLI session, request help to batch create CloudWatch alarms:

```
Please help me batch create CloudWatch alarms for the two EC2 instances I just deployed, to trigger when CPU utilization exceeds 80% for 1 minute
```

2. Follow the guidance provided by Amazon Q CLI to create the alarms.

### Step 4: Set Up SNS Notifications

1. In the Amazon Q CLI session, request help to create an SNS topic and subscription:

```
Please help me create an SNS topic and add my email as a subscription to receive CloudWatch alarm notifications
```

2. Follow the guidance provided by Amazon Q CLI to create the SNS topic and subscription.

3. Confirm the subscription email you receive.

### Step 5: Associate SNS Topic with CloudWatch Alarms

1. In the Amazon Q CLI session, request help to associate the SNS topic with the CloudWatch alarms:

```
Please help me associate the SNS topic I just created with all the CPU utilization alarms
```

2. Follow the guidance provided by Amazon Q CLI to complete the association.

### Step 6: Test Alarm Functionality

1. Access the web interface of the EC2 instances using the URLs obtained in Step 1.

2. Click the "Start CPU Load" button to begin generating CPU load. This will run a CPU-intensive task.

3. Observe the CloudWatch alarm status changes and check if you receive alarm notification emails.

4. If needed, you can click the "Stop CPU Load" button to stop the CPU load test early.

## Clean Up Resources

After completing the lab, delete all resources using the following command:

```bash
aws cloudformation delete-stack --stack-name cloudwatch-alarm-lab
```

## Lab Summary

Through this lab, you have learned how to:
- Query EC2 instance information using Amazon Q CLI
- Batch configure CloudWatch CPU utilization alarms for multiple EC2 instances
- Set up SNS notification mechanisms
- Test and verify CloudWatch alarm functionality using a web interface

These skills can help you monitor AWS resources more effectively and promptly identify and resolve potential issues.
