<?php

namespace Jy\Laravel5I18n;

use Jy\Laravel5I18n\Iface\LangLoader as IfaceLangLoader;
use Illuminate\Translation\FileLoader;

class LangLoader extends FileLoader implements IfaceLangLoader
{
    public function load($locale, $group, $namespace = null){
        return parent::load($locale, $group, $namespace);
    }

    public function existsModule(string $moduleName):bool{
        return true;
    }
}
