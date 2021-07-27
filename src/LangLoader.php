<?php

namespace Ankje\Laravel5I18n;

use Illuminate\Translation\FileLoader;

class LangLoader extends FileLoader
{
    public function load($locale, $group, $namespace = null){
        return parent::load($locale, $group, $namespace);
    }
}
