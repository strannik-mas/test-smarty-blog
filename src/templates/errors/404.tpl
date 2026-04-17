{extends file="layouts/main.tpl"}

{block name="content"}
    <section class="error-page">
        <div class="error-page__inner">
            <div class="error-page__code">404</div>
            <h1 class="error-page__title">Page not found</h1>
            <p class="error-page__text">
                The page you are looking for does not exist, was moved, or is temporarily unavailable.
            </p>
            <div class="error-page__actions">
                <a href="/" class="btn-primary">Back to home</a>
            </div>
        </div>
    </section>
{/block}
