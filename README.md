YII2企业系统
===========================

企业系统使用Yii2框架开发，使用composer管理php依赖包

安装步骤
------------
1. 安装 [composer](http://getcomposer.org/download/).
2. 在根目录执行以下命令来加载php依赖包文件
   * composer install
   * 生产环境加上 --no-dev 参数安装依赖包
3. 配置Apache/nginx根路径
   * /path/to/server/frontend/web/
   * /path/to/server/backend/web/
   * /path/to/server/api/web/
4. 配置文件夹权限
   * /path/to/server/backend/runtime     0755 apache apache
   * /path/to/server/backend/web/assets     0755 apache apache
   * /path/to/server/frontend/runtime     0755 apache apache
   * /path/to/server/frontend/web/assets     0755 apache apache
   * /path/to/server/api/runtime     0755 apache apache
   * /path/to/server/console/runtime     0755 apache apache
   * /path/to/server/data/uploads     0755 apache apache
5. 数据库配置
   * /path/to/server/common/config/db.php
6. memcached配置
   * /path/to/server/frontend/config/main.php
   * /path/to/server/backend/config/main.php
   * /path/to/server/api/config/main.php
   * /path/to/server/console/config/main.php
7. redis配置
   * /path/to/server/common/config/main.php
8. 其他参数配置
   * /path/to/server/common/config/params.php
9. 关闭调试模式及修改环境为生产环境
   * /path/to/server/frontend/web/index.php
   * /path/to/server/backend/web/index.php
   * /path/to/server/api/web/index.php
   * defined('YII_DEBUG') or define('YII_DEBUG', false);
   * defined('YII_ENV') or define('YII_ENV', 'product');
10. 定时任务配置
   * crontab -e
   * MAILTO=''
   * */5 * * * * /path/to/server/console/yii trackingcode/subscribe

项目结构
------------
1. api为接口目录
2. backend为后台管理目录
3. console为脚本目录
4. frontend为前端用户目录
5. common为公用配置/类库目录
6. data为资源上传目录

脚本配置
------------
