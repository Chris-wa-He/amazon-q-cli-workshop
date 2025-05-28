# CloudWatch告警配置实验

本实验将指导您如何使用Amazon Q CLI的对话式交互功能为多个EC2实例批量配置CPU使用率告警，并在超过阈值时触发通知。这是一个动手实验，您将通过与Amazon Q CLI进行自然语言对话来完成配置任务，而不是仅执行预定义的命令。

## 实验概述

在本实验中，您将：
1. 使用CloudFormation模板部署两个EC2实例，每个实例都有一个Web界面用于生成CPU负载
2. 使用Amazon Q CLI以对话方式查询已部署的EC2实例
3. 通过与Amazon Q CLI对话，为这些EC2实例批量配置CPU使用率超过20%的CloudWatch告警，持续1分钟即触发
4. 通过对话方式设置SNS通知，当告警触发时发送邮件通知
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

**预期结果**：Amazon Q CLI将以对话方式回复，显示您账户中的EC2实例列表，包括刚刚部署的两个实例。它会显示实例ID、状态、实例类型等信息。

### 步骤3：批量配置CloudWatch告警

1. 在Amazon Q CLI会话中，请求帮助批量创建CloudWatch告警：

```
请帮我为刚才部署的两个EC2实例批量创建CloudWatch告警，当CPU使用率超过20%持续1分钟时触发
```

2. 按照Amazon Q CLI提供的指导创建告警。Amazon Q CLI会生成必要的AWS CLI命令，您可以直接执行这些命令或请求进一步的解释。

**预期结果**：Amazon Q CLI将生成创建CloudWatch告警的AWS CLI命令，并解释每个参数的作用。执行这些命令后，您将为两个EC2实例创建CPU使用率告警。

### 步骤4：设置SNS通知

1. 在Amazon Q CLI会话中，请求帮助创建SNS主题和订阅：

```
请帮我创建一个SNS主题，并添加我的邮箱作为订阅，用于接收CloudWatch告警通知
```

2. 按照Amazon Q CLI提供的指导创建SNS主题和订阅。您需要将示例邮箱地址替换为您自己的邮箱。

3. 确认您收到的订阅确认邮件。

**预期结果**：Amazon Q CLI将生成创建SNS主题和添加订阅的AWS CLI命令。执行这些命令后，您将收到一封订阅确认邮件，需要点击确认链接来激活订阅。

### 步骤5：将SNS主题与CloudWatch告警关联

1. 在Amazon Q CLI会话中，请求帮助将SNS主题与CloudWatch告警关联：

```
请帮我将刚才创建的SNS主题与所有CPU使用率告警关联起来
```

2. 按照Amazon Q CLI提供的指导完成关联。您可能需要提供SNS主题ARN和告警名称等信息。

**预期结果**：Amazon Q CLI将生成修改CloudWatch告警以添加SNS通知操作的AWS CLI命令。执行这些命令后，您的告警将配置为在触发时发送通知到SNS主题。

### 步骤6：测试告警功能

1. 使用步骤1中获取的URL访问EC2实例的Web界面。

2. 点击"Start CPU Load"按钮开始生成CPU负载。系统将运行一个CPU密集型任务。

3. 观察CloudWatch告警状态变化，并检查是否收到告警通知邮件。您可以通过AWS管理控制台或使用Amazon Q CLI查询告警状态：

```
请查询我账户中所有CloudWatch告警的当前状态
```

4. 如果需要，可以点击"Stop CPU Load"按钮提前停止CPU负载测试。

**预期结果**：启动CPU负载后，EC2实例的CPU使用率将上升。几分钟后，CloudWatch告警状态将从"OK"变为"ALARM"，您将收到一封告警通知邮件。停止CPU负载后，告警最终会恢复到"OK"状态。

## 清理资源

实验完成后，您可以通过以下方式清理资源：

1. 在Amazon Q CLI会话中，请求帮助删除所有创建的资源：

```
请帮我删除本实验中创建的所有资源，包括CloudWatch告警、SNS主题和CloudFormation堆栈
```

2. 或者，使用以下命令删除CloudFormation堆栈（这将删除EC2实例，但不会删除手动创建的CloudWatch告警和SNS主题）：

```bash
aws cloudformation delete-stack --stack-name cloudwatch-alarm-lab
```

**预期结果**：所有实验资源将被删除，避免产生不必要的费用。

## 实验总结

通过本实验，您学习了如何：
- 使用Amazon Q CLI查询EC2实例信息
- 为多个EC2实例批量配置CloudWatch CPU使用率告警
- 设置SNS通知机制
- 通过Web界面测试和验证CloudWatch告警功能

这些技能可以帮助您更有效地监控AWS资源，及时发现和解决潜在问题。
