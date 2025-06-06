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

- **CloudFormation Deployment Role** - For creating the CloudFormation resources needed for the lab
- **Operations Role** - For performing operational tasks during the lab

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

## Lab Steps

### Step 1: Deploy CloudFormation Template

Deploy the CloudFormation template to create the resources needed for the lab:

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

Wait for the stack creation to complete (approximately 5-10 minutes). You can check the deployment status using:

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].StackStatus"
```

### Step 2: Diagnose and Solve EC2 Connection Issues

1. Get the EC2 instance URL:

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. Open the URL in a browser to access the EC2 instance's CPU load test page, verifying network connectivity.
   - If the page loads normally, it confirms that HTTP (port 80) access is working and the network is basically connected.

3. Get the EC2 instance's public IP address:

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text
```

4. Try to connect to the EC2 instance via SSH (this will fail):

```bash
ssh ec2-user@<public-ip-address>
```

5. Use Amazon Q CLI to diagnose connection issues:

```bash
q chat
```

In Amazon Q CLI, you can ask:

```
My EC2 instance is accessible via HTTP but cannot be connected via SSH, please help me diagnose the problem
```

Amazon Q will analyze your environment and provide diagnostic results, potentially identifying issues such as:
- Security group not allowing SSH port (22)
- Network ACL restricting SSH traffic

6. Continue the conversation with Amazon Q, asking how to resolve these issues:

```
How can I modify the security group and network ACL to allow SSH access?
```

Amazon Q will guide you through making the necessary changes. You'll need to get the security group ID and network ACL ID:

```bash
# Get security group ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# Get network ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text
```

7. Follow Amazon Q's guidance to modify the security group and network ACL.

8. Try SSH connection again to verify the issue is resolved:

```bash
ssh ec2-user@<public-ip-address>
```

### Step 3: Analyze Network Architecture

1. Use Amazon Q CLI to analyze your network architecture:

```bash
q chat
```

In Amazon Q CLI, you can ask:

```
Analyze my VPC architecture, including subnets, route tables, and gateways
```

Amazon Q will provide a detailed analysis of your VPC architecture.

2. Request to generate a network architecture diagram:

```
Generate a network architecture diagram based on my VPC resources
```

3. Further explore the network configuration:

```
Analyze the connection between public and private subnets
```

4. **Challenge Step**: Request to generate a draw.io format network architecture diagram file:

```
Please generate a draw.io format network architecture diagram file that includes my VPC, subnets, route tables, security groups, and network ACLs
```

5. Save the generated draw.io file locally:

```bash
# Create a directory to save the architecture diagram
mkdir -p ~/network-diagrams
# Save the content to a file
cat > ~/network-diagrams/vpc-architecture.drawio << 'EOF'
[paste the draw.io content generated by Amazon Q]
EOF
```

6. Try to open the file using draw.io or diagrams.net (you may encounter format errors):
   - Visit https://app.diagrams.net/
   - Choose to open an existing diagram
   - Upload your saved vpc-architecture.drawio file

7. If the file opens with errors, use Amazon Q CLI to fix the problem:

```bash
q chat
```

In Amazon Q CLI, you can ask:

```
I tried to open the network architecture diagram file you generated in draw.io, but encountered format errors. Please help me fix this file.
```

Amazon Q might suggest solutions such as:
- Checking if the XML format is complete
- Fixing specific format issues
- Providing updated, compatible draw.io format content

8. Fix the file according to Amazon Q's recommendations and try opening it again:

```bash
# Update the file with the fixed content
cat > ~/network-diagrams/vpc-architecture-fixed.drawio << 'EOF'
[paste the fixed content provided by Amazon Q]
EOF
```

9. After successfully opening and viewing the network architecture diagram, you can further ask Amazon Q about specific components in the diagram:

```
Please explain how the security groups and network ACLs in this network architecture diagram control traffic
```

### Step 4: Configure CloudWatch Alarms

1. Use Amazon Q CLI to configure CPU usage alarms for the EC2 instance:

```bash
q chat
```

In Amazon Q CLI, ask:

```
Create a CloudWatch alarm for my EC2 instance when CPU usage exceeds 20% and notify me by email
```

2. Get the EC2 instance ID (Amazon Q might ask for this information):

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text
```

3. Interact with Amazon Q to get guidance on creating SNS topics and CloudWatch alarms:

```
Please provide steps to create an SNS topic, configure email subscription, and create a CloudWatch alarm
```

4. Following Amazon Q's guidance, perform these actions:
   - Create an SNS topic
   - Configure email subscription (and confirm the subscription)
   - Create a CloudWatch alarm with the SNS topic as the notification target

5. Verify that the alarm has been created:

```
How can I view the status of the CloudWatch alarm I just created?
```

### Step 5: Trigger CPU Load Test

1. Get the EC2 instance URL:

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. Open the URL in a browser to access the EC2 instance's CPU load test page.

3. Click the "Start CPU Load" button to begin the CPU load test.

4. Wait a few minutes and observe the CloudWatch alarm status change.

5. Verify that you receive an alarm notification email.

### Step 6: Verify and Summarize

1. Use Amazon Q CLI to view alarm status:

```bash
q chat
```

In Amazon Q CLI, you can ask:

```
View the current status of my CloudWatch alarm
```

2. Return to the EC2 instance's CPU load test page and click the "Stop CPU Load" button.

3. Wait a few minutes and observe the alarm status return to normal.

## Clean Up Resources

After completing the lab, delete all created resources to avoid unnecessary charges. You can use Amazon Q CLI for guidance on cleaning up resources:

```
How can I clean up all resources created in this lab?
```

Here are the basic commands for cleaning up resources:

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
