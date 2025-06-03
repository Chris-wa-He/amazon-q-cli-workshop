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

- **CloudFormation部署角色** - 用于创建实验所需的CloudFormation资源
- **实验操作角色** - 用于执行实验中的操作任务

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

## 实验步骤

### 步骤1：部署CloudFormation模板

使用CloudFormation模板部署实验所需的资源：

```bash
aws cloudformation create-stack \
  --stack-name ec2-master-lab \
  --template-body file://template.yaml \
  --capabilities CAPABILITY_IAM
```

等待堆栈创建完成（约5-10分钟）。您可以使用以下命令检查部署状态：

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].StackStatus"
```

### 步骤2：诊断和解决EC2连接问题

1. 获取EC2实例的URL：

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. 在浏览器中打开URL，访问EC2实例的CPU负载测试页面，验证网络连通性。
   - 如果页面能够正常加载，说明HTTP(80端口)访问是正常的，网络基本连通。

3. 获取EC2实例的公有IP地址：

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" \
  --output text
```

4. 尝试通过SSH连接到EC2实例（这将失败）：

```bash
ssh ec2-user@<公有IP地址>
```

5. 使用Amazon Q CLI诊断连接问题：

```bash
q chat
```

在Amazon Q CLI中，您可以询问：

```
我的EC2实例可以通过HTTP访问，但无法通过SSH连接，请帮我诊断问题
```

Amazon Q将分析您的环境并提供诊断结果，可能会发现以下问题：
- 安全组未开放SSH端口(22)
- 网络ACL限制了SSH流量

6. 继续与Amazon Q交流，询问如何解决这些问题：

```
如何修改安全组和网络ACL以允许SSH访问？
```

Amazon Q将指导您完成必要的更改。您需要获取安全组ID和网络ACL ID：

```bash
# 获取安全组ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='SecurityGroupId'].OutputValue" \
  --output text

# 获取网络ACL ID
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='NetworkAclId'].OutputValue" \
  --output text
```

7. 按照Amazon Q的指导，修改安全组和网络ACL。

8. 再次尝试SSH连接，验证问题是否已解决：

```bash
ssh ec2-user@<公有IP地址>
```

### 步骤3：分析网络架构

1. 使用Amazon Q CLI分析您的网络架构：

```bash
q chat
```

在Amazon Q CLI中，您可以询问：

```
分析我的VPC架构，包括子网、路由表和网关
```

Amazon Q将提供您的VPC架构的详细分析。

2. 请求生成网络架构图：

```
基于我的VPC资源生成一个网络架构图
```

3. 进一步探索网络配置：

```
分析公有子网和私有子网之间的连接
```

4. **挑战步骤**：请求生成draw.io格式的网络架构图文件：

```
请生成一个draw.io格式的网络架构图文件，包含我的VPC、子网、路由表、安全组和网络ACL
```

5. 将生成的draw.io文件保存到本地：

```bash
# 创建一个目录来保存架构图
mkdir -p ~/network-diagrams
# 将内容保存到文件
cat > ~/network-diagrams/vpc-architecture.drawio << 'EOF'
[粘贴Amazon Q生成的draw.io内容]
EOF
```

6. 尝试使用draw.io或diagrams.net打开文件（可能会遇到格式错误）：
   - 访问 https://app.diagrams.net/
   - 选择打开现有图表
   - 上传您保存的vpc-architecture.drawio文件

7. 如果文件打开出错，使用Amazon Q CLI修复问题：

```bash
q chat
```

在Amazon Q CLI中，您可以询问：

```
我尝试在draw.io中打开您生成的网络架构图文件，但遇到了格式错误。请帮我修复这个文件。
```

Amazon Q可能会建议以下解决方案：
- 检查XML格式是否完整
- 修复特定的格式问题
- 提供更新的、兼容的draw.io格式内容

8. 根据Amazon Q的建议修复文件，并再次尝试打开：

```bash
# 使用修复后的内容更新文件
cat > ~/network-diagrams/vpc-architecture-fixed.drawio << 'EOF'
[粘贴Amazon Q提供的修复后内容]
EOF
```

9. 成功打开并查看网络架构图后，您可以进一步询问Amazon Q关于图表中特定组件的问题：

```
请解释这个网络架构图中的安全组和网络ACL如何控制流量
```

### 步骤4：配置CloudWatch告警

1. 使用Amazon Q CLI为EC2实例配置CPU使用率告警：

```bash
q chat
```

在Amazon Q CLI中，询问：

```
为我的EC2实例创建一个CPU使用率超过20%的CloudWatch告警，并通过电子邮件通知我
```

2. 获取EC2实例ID（Amazon Q可能会要求此信息）：

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceId'].OutputValue" \
  --output text
```

3. 与Amazon Q交互，获取创建SNS主题和CloudWatch告警的指导：

```
请提供创建SNS主题、配置电子邮件订阅和创建CloudWatch告警的步骤
```

4. 按照Amazon Q的指导，执行以下操作：
   - 创建SNS主题
   - 配置电子邮件订阅（并确认订阅）
   - 创建CloudWatch告警，将SNS主题设为通知目标

5. 验证告警已创建：

```
如何查看我刚刚创建的CloudWatch告警的状态？
```

### 步骤5：触发CPU负载测试

1. 获取EC2实例的URL：

```bash
aws cloudformation describe-stacks \
  --stack-name ec2-master-lab \
  --query "Stacks[0].Outputs[?OutputKey=='InstanceURL'].OutputValue" \
  --output text
```

2. 在浏览器中打开URL，访问EC2实例的CPU负载测试页面。

3. 点击"Start CPU Load"按钮开始CPU负载测试。

4. 等待几分钟，观察CloudWatch告警状态变化。

5. 验证是否收到告警通知电子邮件。

### 步骤6：验证和总结

1. 使用Amazon Q CLI查看告警状态：

```bash
q chat
```

在Amazon Q CLI中，您可以询问：

```
查看我的CloudWatch告警的当前状态
```

2. 返回EC2实例的CPU负载测试页面，点击"Stop CPU Load"按钮停止CPU负载测试。

3. 等待几分钟，观察告警状态恢复正常。

## 清理资源

完成实验后，请删除所有创建的资源，以避免产生不必要的费用。您可以使用Amazon Q CLI获取清理资源的指导：

```
如何清理本实验创建的所有资源？
```

以下是清理资源的基本命令：

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
