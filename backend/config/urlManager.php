<?php
return [
'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '<_a:login|logout>' => 'site/<_a>',

        'coins' => 'coins/index',
        'coins/create' => 'coins/create',
        'coins/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'coins/<_a>',

        'users' => 'users/index',
        'users/create' => 'users/create',
        'users/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'users/<_a>',

        'posts' => 'parse/posts/index',
        'posts/create' => 'parse/posts/create',
        'posts/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'parse/posts/<_a>',

        'twitter' => 'parse/twitter/index',
        'twitter/create' => 'parse/twitter/create',
        'twitter/<_a:(update|delete|view)>/<id:\d+>' => 'parse/twitter/<_a>',

        'facebook' => 'parse/facebook/index',
        'facebook/create' => 'parse/facebook/create',
        'facebook/<_a:(update|delete|view)>/<id:\d+>' => 'parse/facebook/<_a>',

        'reddit' => 'parse/reddit/index',
        'reddit/create' => 'parse/reddit/create',
        'reddit/<_a:(update|delete|view)>/<id:\d+>' => 'parse/reddit/<_a>',

        'forums' => 'parse/forums/index',
        'forums/create' => 'parse/forums/create',
        'forums/<_a:(update|delete|view)>/<id:\d+>' => 'parse/forums/<_a>',

        'encryption' => 'algorithm/encryption',
        'encryption/create' => 'algorithm/encryption/create',
        'encryption/<_a:(update|delete|view)>/<id:\d+>' => 'algorithm/encryption/<_a>',

        'consensus' => 'algorithm/consensus',
        'consensus/create' => 'algorithm/consensus/create',
        'consensus/<_a:(update|delete|view)>/<id:\d+>' => 'algorithm/consensus/<_a>',

        'coupons' => 'coupons/index',
        'coupons/create' => 'coupons/create',
        'coupons/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'coupons/<_a>',

        'sites' => 'settings/sites',
        'sites/create' => 'settings/sites/create',
        'sites/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'settings/sites/<_a>',

        'exchanges' => 'exchanges/index',
        'exchanges/create' => 'exchanges/create',
        'exchanges/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'exchanges/<_a>',

        'networks' => 'networks/index',
        'networks/create' => 'networks/create',
        'networks/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'networks/<_a>',

        'formula' => 'formula/index',
        'formula/create' => 'formula/create',
        'formula/<_a:(update|delete|view)>/<id:\d+>' => 'formula/<_a>',

        'landing/settings' => 'landing/settings/index',

        'landing/blocks' => 'landing/blocks/index',
        'landing/blocks/<_a:(update)>/<id:\d+>' => 'landing/blocks/<_a>',

        'blog' => 'blog/index',
        'blog/create' => 'blog/create',
        'blog/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'blog/<_a>',

        'seo' => 'seo/index',
        'seo/create' => 'seo/create',
        'seo/<_a:(update|delete|view)>/<id:\d+>' => 'seo/<_a>',

        'grade' => 'manage/grade/index',
        'duplicate' => 'manage/duplicate/index',
        'sentiments/posts' => 'manage/sentiments/posts',
        'sentiments/twitter' => 'manage/sentiments/twitter',
        'sentiments/facebook' => 'manage/sentiments/facebook',
    ],
];