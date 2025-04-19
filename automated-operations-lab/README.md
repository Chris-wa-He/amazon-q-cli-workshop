# 自动化运维实验

本实验将指导您使用Amazon Q CLI来创建一个自动化运维解决方案，该解决方案可以检测长时间未启动的EC2实例并通过SNS发送通知。

## 实验概述

在这个实验中，您将：
1. 使用CloudFormation部署一个完整的解决方案，包括：
   - Lambda函数，用于检查EC2实例的状态
   - 必要的IAM角色和权限
   - SNS主题用于发送通知
   - CloudWatch Events触发器定期执行Lambda函数
2. 使用Amazon Q CLI辅助理解和修改解决方案
3. 测试解决方案的功能

## 前提条件

- AWS账户
- 已安装并配置AWS CLI
- 已安装Amazon Q CLI
- 适当的权限来创建CloudFormation堆栈

## 实验步骤

### 步骤1：查看实验文件

首先，查看以下文件，了解它们的功能：
- `lambda_function.py` - Lambda函数代码，用于检测长时间未启动的EC2实例
- `template.yaml` - CloudFormation模板，用于创建所有必要的资源

### 步骤2：部署CloudFormation堆栈

1. 打包Lambda函数代码：

```bash
# 创建部署包
zip ec2_monitor_function.zip lambda_function.py
```

2. 创建S3桶来存储Lambda代码（如果您还没有）：

```bash
aws s3 mb s3://your-deployment-bucket-name
```

3. 上传Lambda代码到S3：

```bash
aws s3 cp ec2_monitor_function.zip s3://your-deployment-bucket-name/
```

4. 部署CloudFormation堆栈：

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

5. 部署完成后，您将收到一封确认电子邮件，需要点击确认链接来订阅SNS主题。

### 步骤3：使用Amazon Q CLI了解解决方案

使用Amazon Q CLI来帮助理解解决方案的工作原理：

```bash
q chat "解释一下lambda_function.py中的代码是如何检测长时间未启动的EC2实例的?"
```

```bash
q chat "CloudFormation模板中的IAM权限是如何配置的，为什么需要这些权限?"
```

### 步骤4：使用Amazon Q CLI修改解决方案

假设您想要修改解决方案，例如更改检测的天数阈值或添加更多筛选条件，可以使用Amazon Q CLI获取帮助：

```bash
q chat "如何修改Lambda函数代码，将未启动天数的阈值从30天改为45天?"
```

```bash
q chat "如何在Lambda函数中添加额外的筛选条件，只检查带有特定标签的EC2实例?"
```

### 步骤5：测试解决方案

1. 手动调用Lambda函数来测试其功能：

```bash
# 获取Lambda函数的名称
LAMBDA_NAME=$(aws cloudformation describe-stacks --stack-name ec2-monitor-stack --query "Stacks[0].Outputs[?OutputKey=='LambdaFunctionName'].OutputValue" --output text)

# 调用Lambda函数
aws lambda invoke --function-name $LAMBDA_NAME output.txt
```

2. 查看CloudWatch Logs以检查函数执行情况：

```bash
# 查看最近的日志
aws logs get-log-events --log-group-name /aws/lambda/$LAMBDA_NAME --log-stream-name $(aws logs describe-log-streams --log-group-name /aws/lambda/$LAMBDA_NAME --order-by LastEventTime --descending --limit 1 --query 'logStreams[0].logStreamName' --output text)
```

### 步骤6：使用Amazon Q CLI进行故障排除

如果在测试过程中遇到问题，可以使用Amazon Q CLI获取帮助：

```bash
q chat "我的Lambda函数执行失败，CloudWatch日志显示错误: <错误信息>。如何解决这个问题?"
```

```bash
q chat "我没有收到SNS通知，如何检查SNS配置是否正确?"
```

## 清理资源

实验完成后，使用以下命令删除所有创建的资源：

1. 删除CloudFormation堆栈：

```bash
aws cloudformation delete-stack --stack-name ec2-monitor-stack
```

2. 删除S3桶中的Lambda部署包：

```bash
aws s3 rm s3://your-deployment-bucket-name/ec2_monitor_function.zip
```

3. 如果您专门为此实验创建了S3桶，也可以选择删除它：

```bash
# 确保桶为空
aws s3 rm s3://your-deployment-bucket-name --recursive

# 删除桶
aws s3 rb s3://your-deployment-bucket-name
```

这将删除所有为此实验创建的资源，包括Lambda函数、IAM角色、SNS主题、CloudWatch Events规则以及S3中的部署文件。
