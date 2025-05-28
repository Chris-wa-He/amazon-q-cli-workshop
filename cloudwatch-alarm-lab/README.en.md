# CloudWatch Alarm Configuration Lab

This lab will guide you on how to use Amazon Q CLI's conversational interaction to batch configure CPU utilization alarms for EC2 instances and trigger notifications when thresholds are exceeded. This is a hands-on lab where you'll complete configuration tasks through natural language dialogue with Amazon Q CLI, rather than just executing predefined commands.

## Lab Overview

In this lab, you will:
1. Deploy two EC2 instances using a CloudFormation template, each with a web interface for generating CPU load
2. Query the deployed EC2 instances using conversational interaction with Amazon Q CLI
3. Batch configure CloudWatch alarms for these EC2 instances to monitor CPU utilization exceeding 20% for 1 minute
4. Set up SNS notifications through dialogue to send email alerts when alarms are triggered
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

**Expected Result**: Amazon Q CLI will respond conversationally, displaying a list of EC2 instances in your account, including the two instances you just deployed. It will show instance IDs, status, instance types, and other relevant information.

### Step 3: Batch Configure CloudWatch Alarms

1. In the Amazon Q CLI session, request help to batch create CloudWatch alarms:

```
Please help me batch create CloudWatch alarms for the two EC2 instances I just deployed, to trigger when CPU utilization exceeds 20% for 1 minute
```

2. Follow the guidance provided by Amazon Q CLI to create the alarms. Amazon Q CLI will generate the necessary AWS CLI commands that you can execute directly or ask for further explanation.

**Expected Result**: Amazon Q CLI will generate AWS CLI commands to create CloudWatch alarms and explain the purpose of each parameter. After executing these commands, you will have created CPU utilization alarms for both EC2 instances.

### Step 4: Set Up SNS Notifications

1. In the Amazon Q CLI session, request help to create an SNS topic and subscription:

```
Please help me create an SNS topic and add my email as a subscription to receive CloudWatch alarm notifications
```

2. Follow the guidance provided by Amazon Q CLI to create the SNS topic and subscription. You'll need to replace the example email address with your own.

3. Confirm the subscription email you receive.

**Expected Result**: Amazon Q CLI will generate AWS CLI commands to create an SNS topic and add a subscription. After executing these commands, you will receive a confirmation email that you need to click to activate the subscription.

### Step 5: Associate SNS Topic with CloudWatch Alarms

1. In the Amazon Q CLI session, request help to associate the SNS topic with the CloudWatch alarms:

```
Please help me associate the SNS topic I just created with all the CPU utilization alarms
```

2. Follow the guidance provided by Amazon Q CLI to complete the association. You may need to provide the SNS topic ARN and alarm names.

**Expected Result**: Amazon Q CLI will generate AWS CLI commands to modify the CloudWatch alarms to add SNS notification actions. After executing these commands, your alarms will be configured to send notifications to the SNS topic when triggered.

### Step 6: Test Alarm Functionality

1. Access the web interface of the EC2 instances using the URLs obtained in Step 1.

2. Click the "Start CPU Load" button to begin generating CPU load. This will run a CPU-intensive task.

3. Observe the CloudWatch alarm status changes and check if you receive alarm notification emails. You can query the alarm status through the AWS Management Console or using Amazon Q CLI:

```
Please query the current status of all CloudWatch alarms in my account
```

4. If needed, you can click the "Stop CPU Load" button to stop the CPU load test early.

**Expected Result**: After starting the CPU load, the CPU utilization of the EC2 instance will increase. After a few minutes, the CloudWatch alarm status will change from "OK" to "ALARM", and you will receive an alarm notification email. After stopping the CPU load, the alarm will eventually return to the "OK" state.

## Clean Up Resources

After completing the lab, you can clean up resources by:

1. In the Amazon Q CLI session, request help to delete all created resources:

```
Please help me delete all resources created in this lab, including CloudWatch alarms, SNS topics, and the CloudFormation stack
```

2. Alternatively, use the following command to delete the CloudFormation stack (this will delete the EC2 instances but not the manually created CloudWatch alarms and SNS topic):

```bash
aws cloudformation delete-stack --stack-name cloudwatch-alarm-lab
```

**Expected Result**: All lab resources will be deleted, preventing unnecessary charges.

## Lab Summary

Through this lab, you have learned how to:
- Query EC2 instance information using Amazon Q CLI
- Batch configure CloudWatch CPU utilization alarms for multiple EC2 instances
- Set up SNS notification mechanisms
- Test and verify CloudWatch alarm functionality using a web interface

These skills can help you monitor AWS resources more effectively and promptly identify and resolve potential issues.
