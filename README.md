# laravel5-i18n

# 说明

- 本扩展包继承于laravel5.8原来多语言翻译函数__($key, $replace = [], $locale = null)的能力

- 如果不想使用原本的语言文件加载器类，则可以自定义语言包加载器loader，只要在config('jyi18n.translation_loader')中指定自定义的loader即可

# 使用

- 安装
    ```bash
    composer -vvv require jy/laravel5-i18n:dev-master
    ```

- 发布资源
    ```bash
    php artisan vendor:publish --provider=Jy\\Laravel5I18n\\Laravel5I18nProvider
    ```

- 调用
```php
// 效果跟调用 __('语言键') 一样
app('jy.i18nhelper')->trans('语言键');
```

- 自定义语言包加载器loader

    - 修改config/jyi18n.php中的translation_loader为自定义的类

- 自定义的类样例
    ```php
    <?php

    namespace App\Libs;

    use Jy\Laravel5I18n\LangLoader as Laravel5I18nLangLoader;

    class LangLoader extends Laravel5I18nLangLoader
    {
        public function load($locale, $group, $namespace = null){
            
            //缓存数据
            $cache = ['key'=>'value'];
            $lConf = $cache;

            if($lConf){
                return $lConf;
            }

            return parent::load($locale, $group, $namespace);
        }

        public function existsModule(string $moduleName):bool{
            // 判断系统中的$moduleName模块是否存在
            return $ret;
        }
    }

    ```
