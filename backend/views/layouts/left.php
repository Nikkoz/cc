<?php
use yii\helpers\Url;
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => \Yii::t('app', 'Users'), 'icon' => 'users', 'url' => Url::toRoute(['/users'])],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => \Yii::t('app','Coins'),'icon' => 'bitcoin', 'url' => Url::toRoute(['/coins'])],
                    [
                        'label' => \Yii::t('app','Parse'),
                        'icon'=>'rss-square',
                        'url' => '#',
                        'items' => [
                            ['label' => \Yii::t('app', 'Posts'),'icon' => 'newspaper-o', 'url' => Url::toRoute(['/posts']), 'active' => $this->context->id == 'parse/posts'],
                            ['label' => \Yii::t('app', 'Twitter'),'icon' => 'twitter', 'url' => Url::toRoute(['/twitter']), 'active' => $this->context->id == 'parse/twitter'],
                            ['label' => \Yii::t('app', 'Facebook'),'icon' => 'facebook', 'url' => Url::toRoute(['/facebook']), 'active' => $this->context->id == 'parse/facebook'],
                            ['label' => \Yii::t('app', 'Reddit'),'icon' => 'reddit', 'url' => Url::toRoute(['/reddit']), 'active' => $this->context->id == 'parse/reddit'],
                            ['label' => \Yii::t('app', 'Forums messages'), 'icon' => 'commenting', 'url' => Url::toRoute(['/forums']), 'active' => $this->context->id == 'parse/forums'],
                        ],
                    ], [
                        'label' => \Yii::t('app','Settings'),
                        'icon' => 'gears',
                        'url' => '#',
                        'items' => [
                            ['label' => \Yii::t('app','Sites'), 'icon' => 'internet-explorer', 'url' => Url::toRoute(['/sites']), 'active' => $this->context->id == 'settings/sites'],
                            ['label' => \Yii::t('app','Social services'),'icon' => 'vk', 'url' => Url::toRoute(['/networks']), 'active' => $this->context->id == 'networks'],
                            ['label' => \Yii::t('app','Exchanges'),'icon' => 'exchange', 'url' => ['/exchanges/index']],
                            ['label' => \Yii::t('app','Formula'), 'icon' => 'bar-chart', 'url' => ['/formula/index']],
                            [
                                'label' => \Yii::t('app','Algorithm'),
                                'icon' => 'gg',
                                'url' => '#',
                                'items' => [
                                    ['label' => \Yii::t('app','Encryption'),'icon' => 'circle-thin', 'url' => Url::toRoute(['/encryption']), 'active' => $this->context->id == 'algorithm/encryption'],
                                    ['label' => \Yii::t('app','Consensus'),'icon' => 'circle-thin', 'url' => Url::toRoute(['/consensus']), 'active' => $this->context->id == 'algorithm/consensus'],
                                ]
                            ],
                            ['label' => \Yii::t('app','Coupons'), 'icon' => 'copy', 'url' => ['/coupons/index']]
                        ],
                    ], [
                        'label' => \Yii::t('app', 'Landing'),
                        'icon' => 'file-photo-o',
                        'url' => '#',
                        'items' => [
                            ['label' => \Yii::t('app', 'Settings'), 'icon' => 'gear', 'url' => Url::toRoute(['landing/settings']), 'active' => $this->context->id == 'landing/settings'],
                            ['label' => \Yii::t('app', 'Blocks'), 'icon' => 'clone', 'url' => Url::toRoute(['landing/blocks']), 'active' => $this->context->id == 'landing/blocks'],
                        ]
                    ],
                    ['label' => \Yii::t('app', 'Blog'), 'icon' => 'newspaper-o', 'url' => Url::toRoute(['/blog']), 'active' => $this->context->id == 'blog'],
                    ['label' => \Yii::t('app', 'Seo'), 'icon' => 'dot-circle-o', 'url' => Url::toRoute(['/seo']), 'active' => $this->context->id == 'seo'],
                    [
                        'label' => \Yii::t('app', 'Manage'),
                        'icon' => 'check-square',
                        'url' => '#',
                        'items' => [
                            ['label' => \Yii::t('app', 'Grade'), 'icon' => 'check-circle', 'url' => Url::toRoute(['/grade']), 'active' => $this->context->id == 'manage/grade'],
                            ['label' => \Yii::t('app', 'Duplicate'), 'icon' => 'clone', 'url' => Url::toRoute(['/duplicate']), 'active' => $this->context->id == 'manage/duplicate'],
                            [
                                'label' => \Yii::t('app', 'Sentiment'),
                                'icon' => 'microphone',
                                'url' =>'#',
                                'items' => [
                                    ['label' => \Yii::t('app', 'Posts'),'icon' => 'newspaper-o', 'url' => Url::toRoute(['sentiments/posts']), 'active' => $this->context->module->requestedRoute == 'manage/sentiments/posts'],
                                    ['label' => \Yii::t('app', 'Twitter'),'icon' => 'twitter', 'url' => Url::toRoute(['sentiments/twitter']), 'active' => $this->context->module->requestedRoute == 'manage/sentiments/twitter'],
                                    ['label' => \Yii::t('app', 'Facebook'),'icon' => 'facebook', 'url' => Url::toRoute(['sentiments/facebook']), 'active' => $this->context->module->requestedRoute == 'manage/sentiments/facebook'],
                                ],
                            ], [
                                'label' => \Yii::t('app', 'Log'),
                                'icon' => 'history',
                                'url' => '#',
                                'items' => [
                                    ['label' => \Yii::t('app', 'Mass media'), 'icon' => '', 'url' => ['/site/log','file' => 'sites'],],
                                    [
                                        'label' => \Yii::t('app', 'Twitter'),
                                        'icon' => '',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => \Yii::t('app', 'Developers'), 'icon' => '', 'url' => ['/site/log','file' => 'socials-twitter'],],
                                            ['label' => \Yii::t('app', 'Exchanges'), 'icon' => '', 'url' => ['/site/log','file' => 'exchanges-twitter'],],
                                        ],
                                    ],
                                    [
                                        'label' => \Yii::t('app', 'Facebook'),
                                        'icon' => '',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => \Yii::t('app', 'Developers'), 'icon' => '', 'url' => ['/site/log','file' => 'socials-facebook'],],
                                            ['label' => \Yii::t('app', 'Exchanges'), 'icon' => '', 'url' => ['/site/log','file' => 'exchanges-facebook'],],
                                        ],
                                    ],
                                    [
                                        'label' => \Yii::t('app', 'Reddit'),
                                        'icon' => '',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => \Yii::t('app', 'Developers'), 'icon' => '', 'url' => ['/site/log','file' => 'socials-reddit'],],
                                            ['label' => \Yii::t('app', 'Exchanges'), 'icon' => '', 'url' => ['/site/log','file' => 'exchanges-reddit'],],
                                        ],
                                    ],
                                ]
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
