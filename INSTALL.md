# 照妖镜 - 详细搭建教程

本文档提供了在不同环境下部署照妖镜的详细步骤。

## 目录

1. [环境要求](#环境要求)
2. [Linux/宝塔面板部署](#linuxlinux宝塔面板部署)
3. [Windows本地部署](#windows本地部署)
4. [虚拟主机部署](#虚拟主机部署)
5. [常见问题解决](#常见问题解决)
6. [性能优化](#性能优化)

---

## 环境要求

### 最低要求

| 项目 | 要求 |
| :--- | :--- |
| **PHP版本** | 5.6 或更高 |
| **Web服务器** | Apache 2.4+ 或 Nginx 1.10+ |
| **操作系统** | Linux、Windows、macOS |
| **浏览器** | Chrome、Firefox、Safari、Edge（最新版本） |
| **协议** | HTTPS（必须） |

### 推荐配置

| 项目 | 推荐 |
| :--- | :--- |
| **PHP版本** | 7.4 或 8.0+ |
| **内存** | 512MB+ |
| **磁盘空间** | 1GB+ |
| **带宽** | 10Mbps+ |

---

## Linux/宝塔面板部署

### 方法1：使用宝塔面板（推荐）

#### 步骤1：登录宝塔面板

1. 访问您的宝塔面板地址（通常为 `http://服务器IP:8888`）
2. 输入用户名和密码登录

#### 步骤2：创建网站

1. 点击"网站" → "添加站点"
2. 填写域名（例如 `zhaoyaojing.com`）
3. 选择PHP版本（建议7.4或以上）
4. 点击"提交"

#### 步骤3：上传项目文件

1. 点击"文件"进入文件管理器
2. 导航到网站根目录（通常为 `/www/wwwroot/zhaoyaojing.com/`）
3. 上传照妖镜项目文件
4. 解压文件（如果是压缩包）

#### 步骤4：设置目录权限

1. 右键点击 `img` 文件夹
2. 选择"权限"
3. 设置权限为 `755` 或 `777`
4. 点击"确定"

#### 步骤5：配置SSL证书

1. 点击"网站" → 选择您的网站
2. 点击"SSL"标签
3. 选择"Let's Encrypt"或上传自有证书
4. 点击"申请"或"上传"

#### 步骤6：配置伪静态（可选）

如果需要美化URL，可以配置伪静态规则。

#### 步骤7：访问网站

在浏览器中访问：
```
https://zhaoyaojing.com/sc.php
```

### 方法2：使用命令行部署

#### 步骤1：连接服务器

```bash
ssh root@您的服务器IP
```

#### 步骤2：安装PHP和Web服务器

**Ubuntu/Debian：**
```bash
# 更新系统
sudo apt update
sudo apt upgrade -y

# 安装PHP和Apache
sudo apt install php apache2 libapache2-mod-php -y

# 启动Apache
sudo systemctl start apache2
sudo systemctl enable apache2
```

**CentOS/RHEL：**
```bash
# 安装PHP和Apache
sudo yum install php httpd -y

# 启动Apache
sudo systemctl start httpd
sudo systemctl enable httpd
```

#### 步骤3：上传项目文件

```bash
# 使用SCP上传
scp -r 照妖镜/ root@您的服务器IP:/var/www/html/

# 或使用git克隆
cd /var/www/html
git clone https://github.com/您的用户名/zhaoyaojing.git
```

#### 步骤4：设置目录权限

```bash
# 进入项目目录
cd /var/www/html/zhaoyaojing

# 创建img目录
mkdir -p img

# 设置权限
chmod 777 img
chmod 755 *.php
```

#### 步骤5：配置Apache虚拟主机

创建配置文件：
```bash
sudo nano /etc/apache2/sites-available/zhaoyaojing.conf
```

添加以下内容：
```apache
<VirtualHost *:80>
    ServerName zhaoyaojing.com
    ServerAlias www.zhaoyaojing.com
    DocumentRoot /var/www/html/zhaoyaojing
    
    <Directory /var/www/html/zhaoyaojing>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    # 重定向到HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

<VirtualHost *:443>
    ServerName zhaoyaojing.com
    ServerAlias www.zhaoyaojing.com
    DocumentRoot /var/www/html/zhaoyaojing
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    
    <Directory /var/www/html/zhaoyaojing>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

启用配置：
```bash
sudo a2ensite zhaoyaojing.conf
sudo a2enmod ssl
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### 步骤6：配置SSL证书

**使用Let's Encrypt（免费）：**
```bash
# 安装Certbot
sudo apt install certbot python3-certbot-apache -y

# 申请证书
sudo certbot certonly --apache -d zhaoyaojing.com -d www.zhaoyaojing.com

# 自动续期
sudo systemctl enable certbot.timer
```

#### 步骤7：验证部署

```bash
# 检查Apache状态
sudo systemctl status apache2

# 检查PHP版本
php -v

# 测试连接
curl -I https://zhaoyaojing.com/sc.php
```

---

## Windows本地部署

### 方法1：使用XAMPP

#### 步骤1：下载并安装XAMPP

1. 访问 [Apache Friends](https://www.apachefriends.org/) 下载XAMPP
2. 选择包含PHP 7.4或以上版本的版本
3. 按照安装向导完成安装

#### 步骤2：启动服务

1. 打开XAMPP控制面板
2. 点击Apache的"Start"按钮
3. 点击MySQL的"Start"按钮（如果需要）

#### 步骤3：上传项目文件

1. 将照妖镜项目文件复制到 `C:\xampp\htdocs\zhaoyaojing\`
2. 创建 `img` 文件夹（如果不存在）

#### 步骤4：设置文件夹权限

1. 右键点击 `img` 文件夹
2. 选择"属性" → "安全"
3. 点击"编辑"
4. 选择"Users"，勾选"完全控制"
5. 点击"应用" → "确定"

#### 步骤5：访问应用

在浏览器中访问：
```
http://localhost/zhaoyaojing/sc.php
```

**注意：** 本地测试时可以使用HTTP，但部署到生产环境必须使用HTTPS。

### 方法2：使用PHPStudy

#### 步骤1：下载并安装PHPStudy

1. 访问 [PHPStudy官网](https://www.phpstudy.net/) 下载
2. 按照安装向导完成安装

#### 步骤2：创建虚拟主机

1. 打开PHPStudy
2. 点击"网站" → "添加网站"
3. 填写网站信息：
   - 网站名称：zhaoyaojing
   - 网站域名：localhost
   - 网站路径：选择项目文件夹
4. 点击"保存"

#### 步骤3：启动服务

1. 点击"启动"按钮启动Apache和PHP
2. 等待服务启动完成

#### 步骤4：访问应用

在浏览器中访问：
```
http://localhost/sc.php
```

---

## 虚拟主机部署

### 步骤1：上传文件

使用FTP或文件管理器将项目文件上传到虚拟主机的公共目录（通常为 `public_html` 或 `www`）

### 步骤2：设置目录权限

通过虚拟主机的文件管理器：
1. 右键点击 `img` 文件夹
2. 选择"权限"或"CHMOD"
3. 设置为 `755` 或 `777`

### 步骤3：检查PHP版本

1. 登录虚拟主机控制面板
2. 查看当前PHP版本（建议7.4+）
3. 如需升级，在控制面板中修改PHP版本

### 步骤4：配置SSL证书

1. 在虚拟主机控制面板中找到"SSL证书"
2. 申请免费的Let's Encrypt证书或上传自有证书
3. 等待证书部署完成

### 步骤5：修改域名配置

编辑 `sc.php` 文件，修改第73行的域名：
```php
// 修改为您的域名
kd.href = 'https://您的域名/?id='+myid.value+'&url='+url.value;
```

### 步骤6：访问应用

在浏览器中访问：
```
https://您的域名/sc.php
```

---

## 常见问题解决

### 问题1：无法调用摄像头

**症状：** 点击拍照后没有反应，或显示"没权限看个毛线"

**原因：**
- 未使用HTTPS协议
- 浏览器未授予摄像头权限
- 浏览器不支持WebRTC

**解决方案：**
```bash
# 1. 确保使用HTTPS
# 2. 检查浏览器设置，允许网站访问摄像头
# 3. 尝试其他浏览器
# 4. 清除浏览器缓存和Cookie
```

### 问题2：照片无法保存

**症状：** 拍照后没有保存，或显示错误

**原因：** `img` 目录权限不足

**解决方案：**
```bash
# Linux/Mac
chmod 777 img

# Windows
# 右键 → 属性 → 安全 → 编辑 → Users → 完全控制
```

### 问题3：403 Forbidden错误

**症状：** 访问网站显示403错误

**原因：** 目录权限不足或Apache配置问题

**解决方案：**
```bash
# 检查目录权限
ls -la

# 修改权限
chmod 755 .
chmod 644 *.php

# 重启Apache
sudo systemctl restart apache2
```

### 问题4：500 Internal Server Error

**症状：** 访问网站显示500错误

**原因：** PHP语法错误或配置问题

**解决方案：**
```bash
# 查看Apache错误日志
tail -f /var/log/apache2/error.log

# 或查看PHP错误日志
tail -f /var/log/php_errors.log

# 检查PHP配置
php -l *.php
```

### 问题5：iOS无法拍照

**症状：** iOS设备无法调用摄像头

**原因：** iOS要求使用Safari浏览器

**解决方案：**
- 使用Safari浏览器打开链接
- 或使用调用Safari内核的第三方APP

### 问题6：照片显示不出来

**症状：** 查看照片页面显示"该ID下没有任何照片"

**原因：**
- 输入的ID不正确
- 照片已被清空
- 照片路径错误

**解决方案：**
1. 确认输入的ID与拍照时的ID一致
2. 检查 `img` 文件夹中是否有照片文件
3. 检查文件权限是否正确

---

## 性能优化

### 1. 启用Gzip压缩

**Apache配置：**
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

**Nginx配置：**
```nginx
gzip on;
gzip_types text/plain text/css text/javascript application/javascript;
gzip_min_length 1000;
```

### 2. 启用浏览器缓存

**Apache配置：**
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/png "access plus 30 days"
    ExpiresByType image/jpeg "access plus 30 days"
    ExpiresByType text/css "access plus 7 days"
    ExpiresByType text/javascript "access plus 7 days"
</IfModule>
```

### 3. 定期清理照片

创建定时任务删除7天前的照片：

**Linux Cron任务：**
```bash
# 编辑crontab
crontab -e

# 添加以下行（每天凌晨2点执行）
0 2 * * * find /var/www/html/zhaoyaojing/img -type f -mtime +7 -delete
```

### 4. 使用CDN加速

将静态资源（CSS、JS、图片）上传到CDN，修改引用路径：

```php
// 原始
<link href="css/style.css" rel="stylesheet">

// 使用CDN
<link href="https://cdn.example.com/zhaoyaojing/css/style.css" rel="stylesheet">
```

### 5. 优化图片

压缩上传的照片大小：

```php
// 在qbl.php中添加图片压缩
$image = imagecreatefromstring(base64_decode($base64_data));
imagepng($image, $new_file, 9); // 压缩等级9
imagedestroy($image);
```

---

## 监控和维护

### 日志监控

```bash
# 查看Apache访问日志
tail -f /var/log/apache2/access.log

# 查看Apache错误日志
tail -f /var/log/apache2/error.log

# 查看PHP错误日志
tail -f /var/log/php_errors.log
```

### 磁盘空间监控

```bash
# 查看磁盘使用情况
df -h

# 查看img文件夹大小
du -sh img/

# 查看最大的文件
find img -type f -exec ls -lh {} \; | sort -k5 -hr | head -10
```

### 定期备份

```bash
# 备份整个项目
tar -czf zhaoyaojing_backup_$(date +%Y%m%d).tar.gz zhaoyaojing/

# 仅备份照片
tar -czf zhaoyaojing_photos_$(date +%Y%m%d).tar.gz zhaoyaojing/img/
```

---

## 总结

| 部署方式 | 难度 | 推荐指数 | 适用场景 |
| :--- | :--- | :--- | :--- |
| 宝塔面板 | ⭐ | ⭐⭐⭐⭐⭐ | 新手、快速部署 |
| 命令行 | ⭐⭐⭐ | ⭐⭐⭐⭐ | 有Linux基础 |
| XAMPP本地 | ⭐ | ⭐⭐⭐ | 本地测试 |
| 虚拟主机 | ⭐⭐ | ⭐⭐⭐ | 小型网站 |

---

**祝您部署顺利！如有问题，请参考常见问题解决部分。**
