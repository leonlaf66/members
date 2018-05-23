<?php
return [
    'urlRules'=>[
        '/'=>'umember/default/index',
        '/account/'=>'umember/account/index',
        '/profile/' => 'umember/profile/index',
        '/rets/newsletter/' => 'umember/rets-newsletter/index',
        '/rets/newsletter/update' => 'umember/rets-newsletter/update',
        '/rets/newsletter/edit' => 'umember/rets-newsletter/edit',
        '/rets/newsletter/delete' => 'umember/rets-newsletter/delete',
        '/rets/schedule/' => 'umember/schedule/index',
        '/rets/schedule/delete' => 'umember/schedule/delete',
        '/rets/wishlist/' => 'umember/wishlist/index',
        '/rets/wishlist/delete' => 'umember/wishlist/remove',
        '/modify-password/' => 'umember/account/modify-password',
        '/bind-phone/' => 'umember/account/bind-phone',
        '/bind-wechat/' => 'umember/account/bind-wechat',
        '/unbind-wechat/' => 'umember/account/unbind-wechat',
        '/bind-email-address' => 'umember/account/bind-email-address',
        '/logout/' => 'umember/account/logout'
    ]
];