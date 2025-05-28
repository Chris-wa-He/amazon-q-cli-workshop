# CloudWatch告警配置实验

本实验将指导您如何使用Amazon Q CLI为多个EC2实例批量配置CPU使用率告警，并在超过阈值时触发通知。

## 实验概述

在本实验中，您将：
1. 使用CloudFormation模板部署两个EC2实例，每个实例都有一个Web界面用于生成CPU负载
2. 使用Amazon Q CLI查询已部署的EC2实例
3. 通过Amazon Q CLI为这些EC2实例批量配置CPU使用率超过20%的CloudWatch告警，持续1分钟即触发
4. 设置SNS通知，当告警触发时发送邮件通知
5. 通过Web界面测试告警功能

## 前提条件

- 已安装并配置AWS CLI
- 已安装Amazon Q CLI
- 拥有适当的AWS权限来创建和管理EC2实例、CloudWatch告警和SNS主题

## 实验步骤

### 步骤1：部署EC2实例

1. 使用以下命令部署CloudFormation模板，创建两个EC2实例：

```bash
aws cloudformation create-stack \
  --stack-name cloudwatch-alarm-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

2. 等待堆栈创建完成：

```bash
aws cloudformation wait stack-create-complete --stack-name cloudwatch-alarm-lab
```

3. 获取EC2实例的Web界面URL：

```bash
aws cloudformation describe-stacks \
  --stack-name cloudwatch-alarm-lab \
  --query "Stacks[0].Outputs[?OutputKey=='Instance1URL' || OutputKey=='Instance2URL'].{Key:OutputKey,Value:OutputValue}" \
  --output table
```

### 步骤2：使用Amazon Q CLI查询EC2实例

1. 启动Amazon Q CLI交互式会话：

```bash
q chat
```

2. 询问Amazon Q CLI关于您账户中的EC2实例：

```
请列出我当前账户中的所有EC2实例及其状态
```

3. 记录下您想要监控的EC2实例ID。

### 步骤3：批量配置CloudWatch告警

1. 在Amazon Q CLI会话中，请求帮助批量创建CloudWatch告警：

```
请帮我为刚才部署的两个EC2实例批量创建CloudWatch告警，当CPU使用率超过20%持续1分钟时触发
```

2. 按照Amazon Q CLI提供的指导创建告警。

### 步骤4：设置SNS通知

1. 在Amazon Q CLI会话中，请求帮助创建SNS主题和订阅：

```
请帮我创建一个SNS主题，并添加我的邮箱作为订阅，用于接收CloudWatch告警通知
```

2. 按照Amazon Q CLI提供的指导创建SNS主题和订阅。

3. 确认您收到的订阅确认邮件。

### 步骤5：将SNS主题与CloudWatch告警关联

1. 在Amazon Q CLI会话中，请求帮助将SNS主题与CloudWatch告警关联：

```
请帮我将刚才创建的SNS主题与所有CPU使用率告警关联起来
```

2. 按照Amazon Q CLI提供的指导完成关联。

### 步骤6：测试告警功能

1. 使用步骤1中获取的URL访问EC2实例的Web界面。

2. 点击"Start CPU Load"按钮开始生成CPU负载。系统将运行一个CPU密集型任务。

3. 观察CloudWatch告警状态变化，并检查是否收到告警通知邮件。

4. 如果需要，可以点击"Stop CPU Load"按钮提前停止CPU负载测试。

## 清理资源

实验完成后，使用以下命令删除所有资源：

```bash
aws cloudformation delete-stack --stack-name cloudwatch-alarm-lab
```

## 实验总结

通过本实验，您学习了如何：
- 使用Amazon Q CLI查询EC2实例信息
- 为多个EC2实例批量配置CloudWatch CPU使用率告警
- 设置SNS通知机制
- 通过Web界面测试和验证CloudWatch告警功能

这些技能可以帮助您更有效地监控AWS资源，及时发现和解决潜在问题。
