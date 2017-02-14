<?php

namespace console\controllers;

use yii\console\Controller;

class OpcacheController extends Controller {

    /**
     * 该函数可以用于在不用运行某个 PHP 脚本的情况下，编译该 PHP 脚本并将其添加到字节码缓存中去。 该函数可用于在 Web 服务器重启之后初始化缓存，以供后续请求调用。
     * @param  string $file 被编译的 PHP 脚本的路径
     * @return int       状态码
     */
    public function actionCompileFile($file) {
        if (function_exists('opcache_compile_file')) {
            opcache_compile_file($file);
            echo "opcache compile file $file success\n";
        } else {
            echo "opcache function opcache_compile_file doesn't exists\n";
            return 0;
        }
        return 1;
    }

    /**
     * 该函数将返回缓存实例的状态信息。
     * @param  boolean $get_scripts 包含脚本的具体声明信息。
     * @return int       状态码
     */
    public function actionGetStatus($get_scripts = TRUE) {
        if (function_exists('opcache_get_status')) {
            echo "opcache status: \n";
            var_export(opcache_get_status($get_scripts));
            echo "\n";
        } else {
            echo "opcache function opcache_get_status doesn't exists\n";
            return 0;
        }
        return 1;
    }

    /**
     * 该函数的作用是使得指定脚本的字节码缓存失效。 如果 force 没有设置或者传入的是 FALSE，那么只有当脚本的修改时间 比对应字节码的时间更新，脚本的缓存才会失效。
     * @param  string  $script 缓存需要被作废对应的脚本路径
     * @param  boolean $force  如果该参数设置为TRUE，那么不管是否必要，该脚本的缓存都将被废除。
     * @return int       状态码
     */
    public function actionInvalidate($script, $force = FALSE) {
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($script, $force);
            echo "opcache invalidate $script success \n";
        } else {
            echo "opcache function opcache_invalidate doesn't exists\n";
            return 0;
        }
        return 1;
    }

    /**
     * This function checks if a PHP script has been cached in OPCache. This can be used to more easily detect the "warming" of the cache for a particular script.
     * @param  string $file The path to the PHP script to be checked.
     * @return int       状态码
     */
    public function actionIsScriptCached($file) {
        if (function_exists('opcache_is_script_cached')) {
            echo "opcache $file ";
            echo opcache_is_script_cached($file) ? 'cached' : 'not cached';
        } else {
            echo "opcache function opcache_is_script_cached doesn't exists\n";
            return 0;
        }
        return 1;

    }

    /**
     * 该函数将重置整个字节码缓存。 在调用 opcache_reset() 之后，所有的脚本将会重新载入并且在下次被点击的时候重新解析。
     * @return int 状态码
     */
    public function actionReset() {
        if (function_exists('opcache_reset')) {
            opcache_reset();
            echo "opcache reset success\n";
        } else {
            echo "opcache function opcache_reset doesn't exists\n";
            return 0;
        }
        return 1;
    }
}