CREATE table if not exists articles (
    id integer primary key auto_increment,
    title varchar(255) not null,
    slug varchar(255) not null unique,
    image varchar(255),
    description text,
    content text,
    views integer default 0,
    published_at datetime,
    created_at datetime default current_timestamp,
    updated_at datetime
);