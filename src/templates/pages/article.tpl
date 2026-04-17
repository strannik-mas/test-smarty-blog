{extends file="layouts/main.tpl"}

{block name="content"}
    <article class="article-page">
        <div class="article-page__head">
            <p class="article-page__breadcrumbs">
                <a href="/">Home</a> / {$article.title|upper}
            </p>

            <h1 class="article-page__title">{$article.title|upper}</h1>

            <div class="article-page__meta">
                {$article.publishedAt|date_format:"%b %e, %Y"}<br>
                {$article.views} views
            </div>
        </div>

        <div class="article-page__image-wrapper">
            <img
                    src="{$article.image}"
                    alt="{$article.title}"
                    class="article-page__image"
            >
        </div>

        <div class="article-page__content">
            {$article.content nofilter}{*безопасно т.к. нет ввода пользовательских данных*}
        </div>
    </article>
{/block}