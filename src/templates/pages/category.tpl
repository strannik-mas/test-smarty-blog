{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="category-page">
        <div class="category-page__head">
            <p class="category-page__breadcrumbs">
                <a href="/">Home</a> / {$category.name|upper}
            </p>

            <h1 class="category-page__title">{$category.name|upper}</h1>

            {if $category.description}
                <p class="category-page__description">{$category.description}</p>
            {/if}
        </div>

        <div class="category-page__toolbar">
            <form method="get" class="sort-form">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="newest" {if $currentSort == 'newest'}selected{/if}>Newest</option>
                    <option value="oldest" {if $currentSort == 'oldest'}selected{/if}>Oldest</option>
                    <option value="popular" {if $currentSort == 'popular'}selected{/if}>Popular</option>
                </select>
            </form>
        </div>

        <div class="posts-list">
            {foreach $articles as $article}
                <article class="post-row">
                    <a href="/article/{$article.slug}" class="post-row__link">
                        <img
                                src="{$article.image}"
                                alt="{$article.title}"
                                class="post-row__image"
                        >
                    </a>
                    <div class="post-row__content">
                        <div class="post-row__meta">
                            {$article.publishedAt|date_format:"%b %e, %Y"}<br>
                            {$article.views} views
                        </div>


                        <h2 class="post-row__title">
                            <a href="/article/{$article.slug}">
                                {$article.title}
                            </a>
                        </h2>

                        <p class="post-row__description">
                            {$article.description|truncate:180:"..."}
                        </p>

                        <a href="/article/{$article.slug}" class="post-row__read-more">
                            Read more
                        </a>
                    </div>
                </article>
            {/foreach}
        </div>

        {if $totalPages > 1}
            <nav class="pagination">
                <a href="?page={$currentPage-1}&sort={$currentSort}" class="pagination__item">
                    Prev
                </a>

                {section name="page" start=1 loop=$totalPages+1}
                    <a
                            href="?page={$smarty.section.page.index}&sort={$currentSort}"
                            class="pagination__item {if $currentPage == $smarty.section.page.index}active{/if}"
                    >
                        {$smarty.section.page.index}
                    </a>
                {/section}

                {if $currentPage < $totalPages}
                    <a href="?page={$currentPage+1}&sort={$currentSort}" class="pagination__item">
                        Next
                    </a>
                {/if}
            </nav>
        {/if}
    </section>
{/block}