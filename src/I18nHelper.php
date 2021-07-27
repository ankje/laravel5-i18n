<?php

namespace Jy\Laravel5I18n;

use Illuminate\Support\NamespacedItemResolver;

class I18nHelper
{
    public function trans($key,$replace = [], $locale = null){
        $locale = header('lang',$locale);
        $defaultModule = 'common';
        $segments = (new NamespacedItemResolver)->parseKey($key);
        $module = $segments[1];
        //如果解析出的模块就使用默认模块
        if(!app('jy.translation.loader')->existsModule($module)){
            $key = $defaultModule.'.'.$key;
        }        
        $ret = app('jy.translator')->getFromJson($key, $replace, $locale);
        $segments = (new NamespacedItemResolver)->parseKey($ret);
        return $segments[2]??$segments[1];
    }
}
