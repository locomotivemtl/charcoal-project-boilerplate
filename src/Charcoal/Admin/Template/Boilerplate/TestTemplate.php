<?php

namespace Charcoal\Admin\Template\Boilerplate;

// From `charcoal-core`
use \Charcoal\Translation\TranslationString as TranslationString;

// From `charcoal-admin`
use \Charcoal\Admin\Widget\DashboardWidget as DashboardWidget;
use \Charcoal\Admin\Ui\MenuItem as MenuItem;

use \Charcoal\Admin\Template\BoilerplateTemplate as BoilerplateTemplate;

class TestTemplate extends BoilerplateTemplate
{
    public function sidebar()
    {
        $dashboard1 = new DashboardWidget();
        $dashboard2 = new DashboardWidget();
        $dashboard1->set_data([
            'ident'=>'objects',
            'label'=>'Objects',
            'widgets'=>[]
        ]);
        $dashboard2->set_data([
            'ident'=>'sitemap',
            'label'=>'Sitemap',
            'widgets'=>[]
        ]);
        $menu = [
            new MenuItem([
                'label'=>'Foobar'
            ]),
            new MenuItem([
                'label'=>'Barbaz'
            ])
        ];
        return [
            'title'=>new TranslationString('Boilerplate Sidebar'),
            'dashboards'=>new \ArrayIterator([
                'objects'=>$dashboard1,
                'sitemap'=>$dashboard2
            ]),
            'action_menu'=>$menu,
            'default_dashboard'=>'sitemap'
        ];
    }

    public function dashboard()
    {

    }

    public function actions_bar()
    {

    }
}

