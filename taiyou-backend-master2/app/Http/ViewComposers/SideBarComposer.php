<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Config;

class SideBarComposer {

    public function compose(View $view){
        $modules = Config::get('cmsConfig.modules');
        $view->with('modules', $modules);
    }
}