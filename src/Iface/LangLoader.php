<?php

namespace Jy\Laravel5I18n\Iface;

use Illuminate\Contracts\Translation\Loader;

interface LangLoader extends Loader
{
    /**
     * 指定的模块是否存在
     */
    public function existsModule(string $moduleName):bool;
}
