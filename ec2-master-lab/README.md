# 全栈EC2运维大师实验（EC2 Full-Stack Operations Master Lab）

本实验整合了EC2连通性问题、网络架构分析和CloudWatch告警配置三个实验，创建一个端到端的实践场景。通过完成本实验，您将学习如何使用Amazon Q CLI诊断和解决EC2连接问题、分析网络架构并配置监控告警。

## 实验目标

通过本实验，您将学习如何：

1. 使用Amazon Q CLI诊断和解决EC2连接问题
2. 分析AWS网络架构并生成网络架构图
3. 配置CloudWatch告警监控EC2实例的CPU使用率
4. 触发CPU负载测试并验证告警通知

## 前提条件

在开始本实验之前，请确保您已经：

1. 安装并配置了AWS CLI
2. 安装了Amazon Q CLI
3. 拥有适当的AWS权限来创建和管理实验中使用的资源

### 所需IAM权限

本实验需要特定的IAM权限，我们将权限分为两个角色：

1. **CloudFormation部署角色** - 用于创建实验所需的CloudFormation资源
2. **实验操作角色** - 用于执行实验中的操作任务

您可以使用提供的IAM角色模板来创建这些角色：

```bash
# 部署CloudFormation角色
aws cloudformation create-stack \
  --stack-name ec2-master-lab-cf-role \
  --template-body file://cloudformation-role.yaml \
  --capabilities CAPABILITY_IAM

# 部署操作角色
aws cloudformation create-stack \
  --stack-name ec2-master-lab-ops-role \
  --template-body file://operations-role.yaml \
  --capabilities CAPABILITY_IAM
```

## 实验架构

本实验将部署以下资源：

- 一个VPC，包含一个公有子网和一个私有子网
- 一个位于公有子网的EC2实例，带有CPU负载测试网页
- 一个位于私有子网的EC2实例，用于网络分析
- 安全组（初始配置不允许SSH访问）
- 网络ACL（限制公网访问）
- IAM角色和实例配置文件

## 实验步骤

### 步骤1：部署CloudFormation模板

1. 下载本实验目录中的`template.yaml`文件
2. 使用AWS CLI或AWS管理控制台部署CloudFormation模板：

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

3. 等待堆栈创建完成（约5-10分钟）

### 步骤2：诊断和解决EC2连接问题

1. 尝试通过SSH连接到EC2实例（这将失败）：

```bash
# 获取EC2实例的公有IP地址
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text

# 尝试SSH连接
ssh ec2-user@<公有IP地址>
```

2. 使用Amazon Q CLI诊断连接问题：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
我的EC2实例无法通过SSH连接，请帮我诊断问题
```

3. 按照Amazon Q CLI的建议，修改安全组以允许SSH访问：

```bash
# 获取安全组ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# 添加SSH规则
aws ec2 authorize-security-group-ingress \
  --group-id <安全组ID> \
  --protocol tcp \
  --port 22 \
  --cidr 0.0.0.0/0
```

4. 按照Amazon Q CLI的建议，修改网络ACL以允许SSH访问：

```bash
# 获取网络ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text

# 添加入站SSH规则
aws ec2 create-network-acl-entry \
  --network-acl-id <网络ACL ID> \
  --ingress \
  --rule-number 110 \
  --protocol 6 \
  --port-range From=22,To=22 \
  --cidr-block 0.0.0.0/0 \
  --rule-action allow
```

5. 再次尝试SSH连接，验证问题是否已解决：

```bash
ssh ec2-user@<公有IP地址>
```

### 步骤3：分析网络架构

1. 使用Amazon Q CLI分析网络架构：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
分析我的VPC架构，包括子网、路由表和网关
```

2. 请求生成网络架构图：

```
基于我的VPC资源生成一个网络架构图
```

3. 分析公有子网和私有子网之间的连接：

```
分析公有子网和私有子网之间的连接
```

### 步骤4：配置CloudWatch告警

1. 使用Amazon Q CLI为EC2实例配置CPU使用率告警：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
为我的EC2实例创建一个CPU使用率超过20%的CloudWatch告警
```

2. 按照Amazon Q CLI的建议，创建SNS主题并配置告警通知：

```bash
# 创建SNS主题
aws sns create-topic --name EC2MasterLabAlarmTopic

# 订阅SNS主题（替换为您的电子邮件地址）
aws sns subscribe \
  --topic-arn <SNS主题ARN> \
  --protocol email \
  --notification-endpoint your-email@example.com
```

3. 创建CloudWatch告警：

```bash
# 获取EC2实例ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text

# 创建告警
aws cloudwatch put-metric-alarm \
  --alarm-name EC2MasterLabCPUAlarm \
  --alarm-description "Alarm when CPU exceeds 20%" \
  --metric-name CPUUtilization \
  --namespace AWS/EC2 \
  --statistic Average \
  --period 300 \
  --threshold 20 \
  --comparison-operator GreaterThanThreshold \
  --dimensions Name=InstanceId,Value=<实例ID> \
  --evaluation-periods 1 \
  --alarm-actions <SNS主题ARN>
```

### 步骤5：触发CPU负载测试

1. 访问EC2实例的CPU负载测试页面：

```bash
# 获取EC2实例URL
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. 在浏览器中打开URL，点击"Start CPU Load"按钮

3. 等待几分钟，观察CloudWatch告警状态变化

4. 验证是否收到告警通知电子邮件

### 步骤6：验证和总结

1. 使用Amazon Q CLI查看告警状态：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
查看我的CloudWatch告警的当前状态
```

2. 停止CPU负载测试：
   - 返回EC2实例的CPU负载测试页面
   - 点击"Stop CPU Load"按钮

3. 等待几分钟，观察告警状态恢复正常

## 清理资源

完成实验后，请删除所有创建的资源，以避免产生不必要的费用：

```bash
# 删除CloudWatch告警
aws cloudwatch delete-alarms --alarm-names EC2MasterLabCPUAlarm

# 删除SNS主题（可选）
aws sns delete-topic --topic-arn <SNS主题ARN>

# 删除CloudFormation堆栈
aws cloudformation delete-stack --stack-name ec2-master-lab

# 删除IAM角色堆栈
aws cloudformation delete-stack --stack-name ec2-master-lab-ops-role
aws cloudformation delete-stack --stack-name ec2-master-lab-cf-role
```

## 总结

通过完成本实验，您已经学习了如何：

1. 使用Amazon Q CLI诊断和解决EC2连接问题
2. 分析AWS网络架构并理解不同组件之间的关系
3. 配置CloudWatch告警监控EC2实例的性能
4. 触发和验证告警通知

这些技能对于在AWS环境中进行日常运维和故障排除非常有价值。Amazon Q CLI提供了一种简单而强大的方式来执行这些任务，无需记住复杂的AWS CLI命令或导航AWS管理控制台。

1. 下载本实验目录中的`template.yaml`文件
2. 使用AWS CLI或AWS管理控制台部署CloudFormation模板：

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

3. 等待堆栈创建完成（约5-10分钟）

### 步骤2：诊断和解决EC2连接问题

1. 尝试通过SSH连接到EC2实例（这将失败）：

```bash
# 获取EC2实例的公有IP地址
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text

# 尝试SSH连接
ssh ec2-user@<公有IP地址>
```

2. 使用Amazon Q CLI诊断连接问题：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
我的EC2实例无法通过SSH连接，请帮我诊断问题
```

3. 按照Amazon Q CLI的建议，修改安全组以允许SSH访问：

```bash
# 获取安全组ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# 添加SSH规则
aws ec2 authorize-security-group-ingress \
  --group-id <安全组ID> \
  --protocol tcp \
  --port 22 \
  --cidr 0.0.0.0/0
```

4. 按照Amazon Q CLI的建议，修改网络ACL以允许SSH访问：

```bash
# 获取网络ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text

# 添加入站SSH规则
aws ec2 create-network-acl-entry \
  --network-acl-id <网络ACL ID> \
  --ingress \
  --rule-number 110 \
  --protocol 6 \
  --port-range From=22,To=22 \
  --cidr-block 0.0.0.0/0 \
  --rule-action allow
```

5. 再次尝试SSH连接，验证问题是否已解决：

```bash
ssh ec2-user@<公有IP地址>
```

### 步骤3：分析网络架构

1. 使用Amazon Q CLI分析网络架构：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
分析我的VPC架构，包括子网、路由表和网关
```

2. 请求生成网络架构图：

```
基于我的VPC资源生成一个网络架构图
```

3. 分析公有子网和私有子网之间的连接：

```
分析公有子网和私有子网之间的连接
```

### 步骤4：配置CloudWatch告警

1. 使用Amazon Q CLI为EC2实例配置CPU使用率告警：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
为我的EC2实例创建一个CPU使用率超过20%的CloudWatch告警
```

2. 按照Amazon Q CLI的建议，创建SNS主题并配置告警通知：

```bash
# 创建SNS主题
aws sns create-topic --name EC2MasterLabAlarmTopic

# 订阅SNS主题（替换为您的电子邮件地址）
aws sns subscribe \
  --topic-arn <SNS主题ARN> \
  --protocol email \
  --notification-endpoint your-email@example.com
```

3. 创建CloudWatch告警：

```bash
# 获取EC2实例ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text

# 创建告警
aws cloudwatch put-metric-alarm \
  --alarm-name EC2MasterLabCPUAlarm \
  --alarm-description "Alarm when CPU exceeds 20%" \
  --metric-name CPUUtilization \
  --namespace AWS/EC2 \
  --statistic Average \
  --period 300 \
  --threshold 20 \
  --comparison-operator GreaterThanThreshold \
  --dimensions Name=InstanceId,Value=<实例ID> \
  --evaluation-periods 1 \
  --alarm-actions <SNS主题ARN>
```

### 步骤5：触发CPU负载测试

1. 访问EC2实例的CPU负载测试页面：

```bash
# 获取EC2实例URL
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. 在浏览器中打开URL，点击"Start CPU Load"按钮

3. 等待几分钟，观察CloudWatch告警状态变化

4. 验证是否收到告警通知电子邮件

### 步骤6：验证和总结

1. 使用Amazon Q CLI查看告警状态：

```bash
q chat
```

在Amazon Q CLI中，询问：
```
查看我的CloudWatch告警的当前状态
```

2. 停止CPU负载测试：
   - 返回EC2实例的CPU负载测试页面
   - 点击"Stop CPU Load"按钮

3. 等待几分钟，观察告警状态恢复正常

## 清理资源

完成实验后，请删除所有创建的资源，以避免产生不必要的费用：

```bash
# 删除CloudWatch告警
aws cloudwatch delete-alarms --alarm-names EC2MasterLabCPUAlarm

# 删除SNS主题（可选）
aws sns delete-topic --topic-arn <SNS主题ARN>

# 删除CloudFormation堆栈
aws cloudformation delete-stack --stack-name ec2-master-lab

# 删除IAM角色堆栈
aws cloudformation delete-stack --stack-name ec2-master-lab-iam
```

## 总结

通过完成本实验，您已经学习了如何：

1. 使用Amazon Q CLI诊断和解决EC2连接问题
2. 分析AWS网络架构并理解不同组件之间的关系
3. 配置CloudWatch告警监控EC2实例的性能
4. 触发和验证告警通知

这些技能对于在AWS环境中进行日常运维和故障排除非常有价值。Amazon Q CLI提供了一种简单而强大的方式来执行这些任务，无需记住复杂的AWS CLI命令或导航AWS管理控制台。
