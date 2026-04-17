{extends file="layouts/main.tpl"}
{block name="content"}
    {foreach $categories as $categoryData}
        <section class="category-section">
            <div class="category-section__top">
                <h2 class="category-section__title">{$categoryData.category.name|upper}</h2>
                <a href="/category/{$categoryData.category.slug}" class="category-section__link">See all</a>
            </div>
            <div class="posts-grid">
                {foreach $categoryData.articles as $article}
                    <article class="post-card">
                        <a href="/article/{$article.slug}" class="post-card__link">
                            <img
                                src="{$article.image}"
                                alt="{$article.title}"
                                class="post-card__image"
                            >
                        </a>
                        <div class="post-card__content">
                            <h3 class="post-card__title">
                                <a href="/article/{$article.slug}">
                                    {$article.title}
                                </a>
                            </h3>

                            <div class="post-card__date">
                                {$article.publishedAt|date_format:"%b %e, %Y"}
                            </div>

                            <p class="post-card__description">
                                {$article.description|truncate:150:"..."}
                            </p>

                            <a href="/article/{$article.slug}" class="post-card__read-more">
                                Read more
                            </a>
                        </div>
                    </article>
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}