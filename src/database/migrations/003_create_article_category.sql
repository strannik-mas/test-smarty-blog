CREATE table if not exists article_category (
    article_id integer not null,
    category_id integer not null,
    primary key (article_id, category_id),
    foreign key (article_id) references articles(id) on delete cascade,
    foreign key (category_id) references categories(id) on delete cascade
);