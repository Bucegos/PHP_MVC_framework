<?php
namespace App\Controller;

use App\Repository\ArticleBookmarksRepo;
use App\Repository\ArticleLikesRepo;
use App\Repository\ArticlesRepo;
use Exception;
use JetBrains\PhpStorm\NoReturn;

/**
 * @property ArticlesRepo $ArticlesRepo
 * @property ArticleLikesRepo $ArticleLikesRepo
 * @property ArticleBookmarksRepo $ArticleBookmarksRepo
 */
class ArticlesController extends AbstractController
{
    /**
     * Read a specific article
     * @param string $slug The article's slug.
     * @return void
     * @throws Exception
     */
    #[NoReturn]
    public function read(string $slug): void
    {
        $this->loadRepo('articles');
        $this->loadRepo('articleLikes');
        $this->loadRepo('articleBookmarks');
        $this->ArticlesRepo->setSubQuery('likedByLoggedUserSubQuery', $this->ArticleLikesRepo->getLikedByLoggedUserSubQuery());
        $this->ArticlesRepo->setSubQuery('bookmarkedByLoggedUserSubQuery', $this->ArticleBookmarksRepo->getBookmarkedByLoggedUserSubQuery());
        $article = $this->ArticlesRepo->getApprovedArticlesByUser($slug);
        $suggestions = $this->ArticlesRepo->getRandomArticlesByAuthor($article['author_id'], $slug);
        $article['suggestions'] = $suggestions;
        $article['content'] = $this->markdown->parse($article['content']);
        $this->render('articles/read', [
            'article' => $article,
        ]);
    }

    /**
     * Writes a new article.
     * @return void
     */
    public function write(): void
    {

    }

    /**
     * Used to preview a markdown content.
     * @api
     * @return void
     */
    public function preview()
    {

    }
}
