<?php
if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

use WHMCS\View\Menu\Item as MenuItem;

add_hook('ClientAreaFooterOutput', 1, function () {
    return '<div class="text-center text-xs text-indigo-200/80 mt-6">AI Powered by Virtual Sky</div>';
});

add_hook('ClientAreaPage', 1, function (array $params) {
    $primaryNav = MenuItem::primaryNavbar();
    if ($primaryNav) {
        $primaryNav->addChild('virtualsky-ai', [
            'label' => 'AI Tools',
            'uri' => 'https://virtualsky.io/ai-tools',
            'order' => 90,
        ]);
    }
});

add_hook('ClientAreaHeadOutput', 1, function () {
    return '<script>document.documentElement.dataset.theme="dark";</script>';
});
