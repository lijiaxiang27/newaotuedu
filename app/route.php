<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------

if (file_exists(CMF_ROOT . "data/conf/route.php")) {
    $runtimeRoutes = include CMF_ROOT . "data/conf/route.php";
} else {
    $runtimeRoutes = [];
}

$fontRoute = [
    '/' => 'index/index',
    'services' => 'index/service',
    'cooperate' => 'index/cooperation',
    'apply' => 'index/coo',
    'course' => 'index/course',
    'news/[:page]' => 'index/news',
    'article/[:id]' => 'index/news_detail',
    'job' => 'index/recruit',
    'faq' => 'index/support',
    'legal' => 'index/legal_declaration',
    'distribute' => 'index/dis_country',
    'distribution' => 'index/dis_countrys',
    'about' => 'index/aotu_brief',
    'paraphrase' => 'index/interpretation',
    'develop' => 'index/dev_history',
    'team' => 'index/our_team',
    'recruit' => 'index/recruit',
    'contract' => 'index/call_us',
    'servicesdetail' => 'index/nm',
    'search/[:id]' => 'index/search_result',
    'videos' => 'index/videos',
    'sitemap' => 'index/sitemap',
    'jobdetail/:id' => 'index/recruitdetail'
];

return array_merge($fontRoute, $runtimeRoutes);