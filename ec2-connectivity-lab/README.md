# EC2 连通性问题实验

## 实验概述

在本实验中，你将学习如何使用Amazon Q CLI来诊断和解决EC2实例的连接问题。实验将模拟一个常见的场景：EC2实例已经部署，但由于安全组配置和网络ACL限制，无法通过SSH连接到该实例。

## 实验步骤

### 1. 部署资源

使用提供的CloudFormation模板部署实验资源：
```bash
aws cloudformation deploy --template-file template.yaml --stack-name ec2-connectivity-lab --capabilities CAPABILITY_IAM
```

部署完成后，获取EC2实例的公有IP地址：
```bash
aws cloudformation describe-stacks --stack-name ec2-connectivity-lab --query "Stacks[0].Outputs[?OutputKey=='PublicIP'].OutputValue" --output text
```

### 2. 验证HTTP连接

首先，通过HTTP访问EC2实例，确认实例已启动且公有IP可连通：
```bash
# 使用curl命令验证HTTP连接
curl http://<EC2实例公有IP>

# 或者在浏览器中访问
# http://<EC2实例公有IP>
```

你应该能看到一个简单的HTML页面，显示"EC2 Connectivity Lab"和成功连接的消息。这表明EC2实例已正常运行，且HTTP端口(80)是开放的。

### 3. 尝试SSH连接

接下来，尝试使用SSH连接到EC2实例：
```bash
ssh ec2-user@<EC2实例公有IP>
```

你会发现无法通过SSH连接到实例，这是因为安全组和网络ACL的限制。

### 4. 使用Amazon Q CLI诊断问题

使用Amazon Q CLI来诊断连接问题：
```bash
q chat
```

在聊天中，描述你遇到的问题，例如：
"我无法SSH连接到我的EC2实例，请帮我诊断问题并提供解决方案。"

### 5. 解决问题

按照Amazon Q CLI的建议，解决以下问题：
- 安全组配置问题：添加允许SSH访问的规则
- 网络ACL限制：修改网络ACL以允许必要的入站和出站流量

### 6. 验证连接

完成上述步骤后，再次尝试SSH连接到EC2实例，验证问题是否已解决：
```bash
ssh ec2-user@<EC2实例公有IP>
```

### 7. 资源清理

实验完成后，请清理所有资源以避免不必要的费用：
```bash
# 删除CloudFormation堆栈
aws cloudformation delete-stack --stack-name ec2-connectivity-lab

# 验证堆栈是否已删除
aws cloudformation describe-stacks --stack-name ec2-connectivity-lab
```

如果最后一个命令返回错误"Stack with id ec2-connectivity-lab does not exist"，则表示资源已成功清理。

## 实验总结

通过本实验，你将学习：
- 如何使用Amazon Q CLI诊断EC2连接问题
- 如何识别和解决安全组配置问题
- 如何识别和解决网络ACL限制问题
- 如何验证连接问题是否已解决
- 如何正确清理AWS资源
