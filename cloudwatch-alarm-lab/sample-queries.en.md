# Amazon Q CLI Sample Queries

Below are sample Amazon Q CLI queries that can be used in the CloudWatch Alarm Configuration Lab:

## Query EC2 Instances

```
List all EC2 instances in my current account and their status
```

```
Find EC2 instances with tag names containing "CloudWatch-Alarm-Lab"
```

```
Get the public DNS names of the EC2 instances I just deployed
```

## Create CloudWatch Alarms

```
Batch create CloudWatch alarms for EC2 instances with IDs i-xxxxxxxxxx and i-yyyyyyyyyy to trigger when CPU utilization exceeds 20% for 1 minute
```

```
How can I use AWS CLI to batch create CloudWatch alarms for multiple EC2 instances?
```

```
Create a CloudWatch alarm that sends a notification when an EC2 instance's CPU utilization exceeds 20% for 1 minute
```

## Create SNS Topics and Subscriptions

```
Create an SNS topic named "EC2-CPU-Alarm" and add my email example@example.com as a subscription
```

```
How do I associate an SNS topic with CloudWatch alarms?
```

```
How can I check the subscription status of an SNS topic?
```

## Query and Manage CloudWatch Alarms

```
List all CloudWatch alarms in my account and their status
```

```
How can I view the history of a CloudWatch alarm's status?
```

```
How do I modify the threshold of an existing CloudWatch alarm?
```

## Clean Up Resources

```
How do I delete all CloudWatch alarms related to "CloudWatch-Alarm-Lab"?
```

```
How do I delete an SNS topic and all its subscriptions?
```

```
How can I use CloudFormation to delete all resources I deployed?
```
