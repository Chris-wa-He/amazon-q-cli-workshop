# EC2 Connectivity Lab

## Lab Overview

In this lab, you will learn how to use Amazon Q CLI to diagnose and solve connectivity issues with EC2 instances. The lab simulates a common scenario: an EC2 instance has been deployed, but due to security group configurations and network ACL restrictions, you cannot connect to the instance via SSH.

## Lab Steps

### 1. Deploy Resources

Use the provided CloudFormation template to deploy lab resources:
```bash
aws cloudformation deploy --template-file template.yaml --stack-name ec2-connectivity-lab --capabilities CAPABILITY_IAM
```

After deployment is complete, get the public IP address of the EC2 instance:
```bash
aws cloudformation describe-stacks --stack-name ec2-connectivity-lab --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" --output text
```

### 2. Verify HTTP Connection

First, access the EC2 instance via HTTP to confirm that the instance is running and the public IP is reachable:
```bash
# Use curl command to verify HTTP connection
curl http://<EC2-instance-public-IP>

# Or visit in a browser
# http://<EC2-instance-public-IP>
```

You should see a simple HTML page displaying "EC2 Connectivity Lab" and a successful connection message. This indicates that the EC2 instance is running normally and the HTTP port (80) is open.

### 3. Try SSH Connection

Next, try to connect to the EC2 instance using SSH:
```bash
ssh ec2-user@<EC2-instance-public-IP>
```

You will find that you cannot connect to the instance via SSH due to security group and network ACL restrictions.

### 4. Use Amazon Q CLI to Diagnose the Problem

Use Amazon Q CLI to diagnose the connection issue:
```bash
q chat
```

In the chat, describe the problem you're experiencing, for example:
"I cannot SSH connect to my EC2 instance. Please help me diagnose the problem and provide a solution."

### 5. Solve the Problem

Following Amazon Q CLI's recommendations, solve the following issues:
- Security group configuration issue: Add rules to allow SSH access
- Network ACL restrictions: Modify network ACLs to allow necessary inbound and outbound traffic

### 6. Verify Connection

After completing the above steps, try to connect to the EC2 instance via SSH again to verify that the problem has been resolved:
```bash
ssh ec2-user@<EC2-instance-public-IP>
```

### 7. Resource Cleanup

After completing the lab, clean up all resources to avoid unnecessary charges:
```bash
# Delete CloudFormation stack
aws cloudformation delete-stack --stack-name ec2-connectivity-lab

# Verify the stack has been deleted
aws cloudformation describe-stacks --stack-name ec2-connectivity-lab
```

If the last command returns an error "Stack with id ec2-connectivity-lab does not exist", it indicates that the resources have been successfully cleaned up.

## Lab Summary

Through this lab, you will learn:
- How to use Amazon Q CLI to diagnose EC2 connectivity issues
- How to identify and resolve security group configuration issues
- How to identify and resolve network ACL restrictions
- How to verify if connection issues have been resolved
- How to properly clean up AWS resources
