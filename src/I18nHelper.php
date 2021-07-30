<?php

namespace Jy\Laravel5I18n;

use Illuminate\Support\NamespacedItemResolver;

class I18nHelper
{
    public function trans($key,$replace = [], $locale = null){
        $defaultModule = 'common';
        $segments = (new NamespacedItemResolver)->parseKey($key);
        $module = $segments[1];
        //如果解析出的模块就使用默认模块
        if(!app('jy.translation.loader')->existsModule($module)){
            $key = $defaultModule.'.'.$key;
        }elseif($key==$module){
            $key = ($segments[0]??'*').'::'.($segments[1]??'*').'.'.$key;
        }
        $ret = app('jy.translator')->getFromJson($key, $replace, $locale);
        if($ret){
            $segments = (new NamespacedItemResolver)->parseKey($ret);
        }
        return $segments[2]??$segments[1];
    }
}
