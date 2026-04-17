CREATE table if not exists categories (
    id integer primary key auto_increment,
    name varchar(255) not null,
    slug varchar(255) not null unique,
    description text,
    created_at datetime default current_timestamp,
    updated_at datetime
);