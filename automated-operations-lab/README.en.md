# Automated Operations Lab

This lab will guide you in using Amazon Q CLI to create an automated operations solution that detects EC2 instances that haven't been started for a long time and sends notifications via SNS.

## Lab Overview

In this lab, you will:
1. Use CloudFormation to deploy a complete solution, including:
   - Lambda function to check EC2 instance status
   - Necessary IAM roles and permissions
   - SNS topic for sending notifications
   - CloudWatch Events trigger to periodically execute the Lambda function
2. Use Amazon Q CLI to help understand and modify the solution
3. Test the functionality of the solution

## Prerequisites

- AWS account
- AWS CLI installed and configured
- Amazon Q CLI installed
- Appropriate permissions to create CloudFormation stacks

## Lab Steps

### Step 1: Review Lab Files

First, review the following files to understand their functions:
- `lambda_function.py` - Lambda function code for detecting EC2 instances that haven't been started for a long time
- `template.yaml` - CloudFormation template for creating all necessary resources

### Step 2: Deploy CloudFormation Stack

1. Package the Lambda function code:

```bash
# Create deployment package
zip ec2_monitor_function.zip lambda_function.py
```

2. Create an S3 bucket to store the Lambda code (if you don't already have one):

```bash
aws s3 mb s3://your-deployment-bucket-name
```

3. Upload the Lambda code to S3:

```bash
aws s3 cp ec2_monitor_function.zip s3://your-deployment-bucket-name/
```

4. Deploy the CloudFormation stack:

```bash
aws cloudformation create-stack \
    --stack-name ec2-monitor-stack \
    --template-body file://template.yaml \
    --capabilities CAPABILITY_IAM \
    --parameters \
        ParameterKey=EmailAddress,ParameterValue=your-email@example.com \
        ParameterKey=S3BucketName,ParameterValue=your-deployment-bucket-name \
        ParameterKey=S3Key,ParameterValue=ec2_monitor_function.zip
```

5. After deployment is complete, you will receive a confirmation email. You need to click the confirmation link to subscribe to the SNS topic.

### Step 3: Use Amazon Q CLI to Understand the Solution

Use Amazon Q CLI to help understand how the solution works:

```bash
q chat "Explain how the code in lambda_function.py detects EC2 instances that haven't been started for a long time?"
```

```bash
q chat "How are the IAM permissions configured in the CloudFormation template, and why are these permissions needed?"
```

### Step 4: Use Amazon Q CLI to Modify the Solution

Suppose you want to modify the solution, such as changing the detection threshold or adding more filtering conditions. You can use Amazon Q CLI for help:

```bash
q chat "How can I modify the Lambda function code to change the threshold from 30 days to 45 days?"
```

```bash
q chat "How can I add additional filtering conditions to the Lambda function to only check EC2 instances with specific tags?"
```

### Step 5: Test the Solution

1. Manually invoke the Lambda function to test its functionality:

```bash
# Get the Lambda function name
LAMBDA_NAME=$(aws cloudformation describe-stacks --stack-name ec2-monitor-stack --query "Stacks[0].Outputs[?OutputKey=='LambdaFunctionName'].OutputValue" --output text)

# Invoke the Lambda function
aws lambda invoke --function-name $LAMBDA_NAME output.txt
```

2. Check CloudWatch Logs to verify the function execution:

```bash
# View recent logs
aws logs get-log-events --log-group-name /aws/lambda/$LAMBDA_NAME --log-stream-name $(aws logs describe-log-streams --log-group-name /aws/lambda/$LAMBDA_NAME --order-by LastEventTime --descending --limit 1 --query 'logStreams[0].logStreamName' --output text)
```

### Step 6: Use Amazon Q CLI for Troubleshooting

If you encounter issues during testing, you can use Amazon Q CLI for help:

```bash
q chat "My Lambda function execution failed, CloudWatch logs show error: <error message>. How can I resolve this issue?"
```

```bash
q chat "I'm not receiving SNS notifications. How can I check if the SNS configuration is correct?"
```

## Clean Up Resources

After completing the lab, use the following commands to delete all created resources:

1. Delete the CloudFormation stack:

```bash
aws cloudformation delete-stack --stack-name ec2-monitor-stack
```

2. Delete the Lambda deployment package from the S3 bucket:

```bash
aws s3 rm s3://your-deployment-bucket-name/ec2_monitor_function.zip
```

3. If you created an S3 bucket specifically for this lab, you can also choose to delete it:

```bash
# Make sure the bucket is empty
aws s3 rm s3://your-deployment-bucket-name --recursive

# Delete the bucket
aws s3 rb s3://your-deployment-bucket-name
```

This will delete all resources created for this lab, including the Lambda function, IAM roles, SNS topic, CloudWatch Events rule, and deployment files in S3.
