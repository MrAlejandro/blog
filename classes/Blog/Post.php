<?php

namespace App\Blog;

use Michelf\MarkdownExtra;

class Post
{
    const EXTENSION_HTML = 'html';
    const EXTENSION_MARKDOWN = 'md';

    private $db;
    private $articlesDir;

    public function __construct($db, $settings)
    {
        $this->db = $db;
        $this->articlesDir = $settings['articles_path'];
    }

    public function getBlogPost($name)
    {
        $article = '';
        $articlePath = $this->articlesDir . "/{$name}";
        $realArticlePath = $this->getRealArticlePath($articlePath);

        if (file_exists($realArticlePath)) {
            $contents = file_get_contents($realArticlePath);
            $article = MarkdownExtra::defaultTransform($contents);
        }

        return $article;
    }

    private function getRealArticlePath($articlePath)
    {
        $realPath = $articlePath;
        $parts = explode('.', $articlePath);
        $extension = array_pop($parts);

        if ($extension === self::EXTENSION_HTML) {
            $parts[] = self::EXTENSION_MARKDOWN;
            $realPath = implode('.', $parts);
        }

        return $realPath;
    }
}