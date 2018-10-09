<?php

namespace core\helpers;


use core\entities\coins\Coins;
use core\entities\coins\Forums;
use core\entities\coins\handbook\Handbook;
use core\entities\coins\handbook\HandbookAssignments;
use core\entities\parse\Facebook;
use core\entities\parse\ForumMessages;
use core\entities\parse\Posts;
use core\entities\parse\Reddit;
use core\entities\parse\Twitter;
use core\entities\Sites;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class PostsHelper
 * @package core\helpers
 */
class PostsHelper
{
    public static function getCoinList(): array
    {
        return ArrayHelper::map(Coins::find()->active()->all(), 'id', 'name');
    }

    public static function getPosts(int $coin): array
    {
        return Posts::find()
            ->alias('posts')
            ->select('posts.id, posts.created, COUNT(DISTINCT posts.id) AS count, sites.name AS site, handbook.coin_id')
            ->leftJoin(HandbookAssignments::tableName() . ' ph', 'ph.post_id = posts.id')
            ->leftJoin(Handbook::tableName() . ' handbook', 'handbook.id = ph.handbook_id')
            ->leftJoin(Sites::tableName() . ' sites', 'sites.id = posts.site_id')
            ->where(['=', 'handbook.coin_id', $coin])
            ->andFilterWhere(['>', 'posts.created', strtotime("-1 days")])
            ->andFilterWhere(['=', 'posts.type', 'post'])
            ->asArray()
            ->groupBy('handbook.coin_id')
            ->orderBy(['posts.created' => SORT_ASC])
            ->one() ?: ['count' => 0];
    }

    public static function getFacebookPosts(int $coin): array
    {
        $query = new Query();
        return $query->select('coin_id, created, SUM(shares_count) AS shares, SUM(likes_count) AS likes, SUM(comments_count) AS comments, COUNT(id) AS count')
            ->from(Facebook::tableName())
            ->where(['>', 'created', strtotime("-1 days")])
            ->andFilterWhere(['=', 'coin_id', $coin])
            ->andFilterWhere(['=', 'type', 'facebook'])
            ->groupBy('coin_id')
            ->orderBy(['created' => SORT_ASC])
            ->one() ?: ['shares'=> 0, 'likes' => 0, 'comments' => 0, 'count' => 0];
    }

    public static function getTwitterPosts(int $coin): array
    {
        $query = new Query();
        return $query->select('SUM(shares_count) AS shares, SUM(likes_count) AS likes, SUM(comments_count) AS comments, COUNT(id) AS count, coin_id')
            ->from(Twitter::tableName())
            ->where(['>', 'created', strtotime("-1 days")])
            ->andFilterWhere(['=', 'coin_id', $coin])
            ->andFilterWhere(['=', 'type', 'twitter'])
            ->groupBy('coin_id')
            ->orderBy(['created' => SORT_ASC])
            ->one() ?: ['shares'=> 0, 'likes' => 0, 'comments' => 0, 'count' => 0];
    }

    public static function getRedditPosts(int $coin): array
    {
        $query = new Query();
        return $query->select('SUM(likes_count) AS likes, SUM(comments_count) AS comments, COUNT(id) AS count, coin_id')
            ->from(Reddit::tableName())
            ->where(['>', 'created', strtotime("-1 days")])
            ->andFilterWhere(['=', 'coin_id', $coin])
            ->andFilterWhere(['=', 'type', 'reddit'])
            ->groupBy('coin_id')
            ->orderBy(['created' => SORT_ASC])
            ->one() ?: ['likes' => 0, 'comments' => 0];
    }

    public static function getTwitterExchange(int $coin): array
    {
        $query = new Query();
        return $query->select('COUNT(DISTINCT `twitter`.`id`) AS count, handbook.coin_id AS coin')
            ->from(Twitter::tableName() . ' twitter')
            ->leftJoin(HandbookAssignments::tableName() . ' th', 'th.post_id = twitter.id')
            ->leftJoin(Handbook::tableName() . " handbook", 'handbook.id = th.handbook_id')
            ->where(['=', 'twitter.coin_id', 0])
            ->andFilterWhere(['=', 'handbook.coin_id', $coin])
            ->andFilterWhere(['>', 'twitter.created', strtotime("-1 days")])
            ->groupBy('coin')
            ->orderBy(['twitter.created' => SORT_ASC])
            ->one() ?: ['shares'=> 0, 'likes' => 0, 'comments' => 0, 'count' => 0];
    }

    public static function getFacebookExchange(int $coin): array
    {
        $query = new Query();
        return $query->select('COUNT(DISTINCT facebook.id) AS count, handbook.coin_id AS coin')
            ->from(Facebook::tableName() . ' facebook')
            ->leftJoin(HandbookAssignments::tableName() . ' th', 'th.post_id = facebook.id')
            ->leftJoin(Handbook::tableName() . " handbook", 'handbook.id = th.handbook_id')
            ->where(['=', 'facebook.coin_id', 0])
            ->andFilterWhere(['=', 'handbook.coin_id', $coin])
            ->andFilterWhere(['>', 'facebook.created', strtotime("-1 days")])
            ->groupBy('coin')
            ->orderBy(['facebook.created' => SORT_ASC])
            ->one() ?: ['shares'=> 0, 'likes' => 0, 'comments' => 0, 'count' => 0];
    }

    public static function getRedditExchange(int $coin): array
    {
        $query = new Query();
        return $query->select('COUNT(DISTINCT reddit.id) AS count, handbook.coin_id AS coin')
            ->from(Reddit::tableName() . ' reddit')
            ->leftJoin(HandbookAssignments::tableName() . ' th', 'th.post_id = reddit.id')
            ->leftJoin(Handbook::tableName() . " handbook", 'handbook.id = th.handbook_id')
            ->where(['=', 'reddit.coin_id', 0])
            ->andFilterWhere(['=', 'handbook.coin_id', $coin])
            ->andFilterWhere(['>', 'reddit.created', strtotime("-1 days")])
            ->groupBy('coin')
            ->orderBy(['reddit.created' => SORT_ASC])
            ->one() ?: ['likes' => 0, 'comments' => 0, 'count' => 0];
    }

    public static function getForums(int $coin): array
    {
        $forums = Forums::find()->select(['id','coin_id','admin'])->where(['=', 'coin_id', $coin])->all();

        if(!empty($forums)) {
            $community = $developers = [];

            foreach($forums as $forum) {
                $community[] = "forum_id='{$forum->id}' AND user_name<>'{$forum->admin}'";
                $developers[] = "forum_id='{$forum->id}' AND user_name='{$forum->admin}'";
            }

            $community = implode(" OR ", $community);
            $developers = implode(" OR ", $developers);

            $query = new Query();
            $communityCounts = $query->select('forum_id, COUNT(forum_id) as count')
                ->from(ForumMessages::tableName())
                ->where($community)
                ->all();

            $developersCounts = $query->select('forum_id, COUNT(forum_id) as count')
                ->from(ForumMessages::tableName())
                ->where($developers)
                ->all();

            $coinCommunity = [];
            foreach($communityCounts as $count) {
                $coinCommunity[] = $count['count'];
            }

            $coinDevelopers = [];
            foreach($developersCounts as $count) {
                $coinDevelopers[] = $count['count'];
            }

            return ['community' => $coinCommunity, 'developers' => $coinDevelopers];
        }

        return [];
    }

    public static function returnCoins(array $handbooks): string
    {
        $coins = [];
        foreach($handbooks as $handbook) {
            $coins[$handbook->coin->id] = $handbook->coin->name;
        }

        return implode(', ', $coins);
    }

    public static function returnTwitterLink(string $page_name, string $post_id): string
    {
        $page_name = str_replace('https://twitter.com/','', $page_name);
        return "https://twitter.com/{$page_name}/status/{$post_id}";
    }

    public static function returnFacebookLink(string $page_name, string $post_id): string
    {
        $page_name = str_replace('https://www.facebook.com/','', $page_name);
        $post_id = explode('_', $post_id);
        return str_replace('//', '/', "https://www.facebook.com/{$page_name}/posts/{$post_id[1]}");
    }
}