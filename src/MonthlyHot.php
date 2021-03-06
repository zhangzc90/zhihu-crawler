<?php

namespace pithyone\zhihu\crawler;


class MonthlyHot extends Base
{
    /**
     * @param callable $callback
     *
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists($callback = null)
    {
        $contents = $this->http->response('GET', ['/explore#monthly-hot']);

        return $this->query
            ->page($contents)
            ->rules([
                'title'       => ['a[class="question_link"]', 'text'],
                'link'        => ['a[class="question_link"]', 'href'],
                'vote'        => ['a[class^="zm-item-vote-count"]', 'text'],
                'author'      => ['a[class="author-link"]', 'text'],
                'author_link' => ['a[class="author-link"]', 'href'],
                'bio'         => ['span[class="bio"]', 'title'],
                'summary'     => ['div[class*="summary"]', 'text', '-a'],
                'create_time' => ['div[class^="zm-item-answer"]', 'data-created'],
                'comment'     => [
                    'a[name="addcomment"]', 'text', '', function ($text) {
                        return intval($text);
                    }
                ]
            ])
            ->range('div[data-type="monthly"] div[class^="explore-feed"]')
            ->callback($callback)
            ->getData();
    }
}