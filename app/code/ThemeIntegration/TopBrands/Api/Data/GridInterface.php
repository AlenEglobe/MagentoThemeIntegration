<?php

namespace ThemeIntegration\TopBrands\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ARTICLE_ID = 'id';
    const BRAND = 'Brands';
    const IMAGE = 'Image';
    /**
     * Get ArticleId.
     *
     * @return int
     */
    public function getArticleId();

    /**
     * Set ArticleId.
     */
    public function setArticleId($articleId);

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getTitle();

    /**
     * Set Title.
     */
    public function setTitle($title);

    /**
     * Get Image.
     */
    public function getImage();

    /**
     * Set Image.
     */

    public function setImage($image);
}
