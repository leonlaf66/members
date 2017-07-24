<?php
return [
    'urlRules'=>[
        '/'=>'umember/default/index',
        '/myaccount/' => 'umember/account/index',
        '/profile/' => 'umember/profile/index',
        '/rets/newsletter/' => 'umember/rets-newsletter/index',
        '/rets/newsletter/update' => 'umember/rets-newsletter/update',
        '/rets/newsletter/edit' => 'umember/rets-newsletter/edit',
        '/rets/newsletter/delete' => 'umember/rets-newsletter/delete',
        '/rets/schedule/' => 'umember/schedule/index',
        '/rets/schedule/delete' => 'umember/schedule/delete',
        '/rets/wishlist/' => 'umember/wishlist/index',
        '/rets/wishlist/delete' => 'umember/wishlist/remove',
    ]
];