drop table if exists collection_ids;
create table collection_ids
(
    id         INTEGER,
    name       varchar,
    created_at timestamp default current_timestamp
);

drop table if exists keyword_ids;
create table keyword_ids
(
    id         INTEGER,
    name       varchar,
    created_at timestamp default current_timestamp
);

drop table if exists movie_ids;
create table movie_ids
(
    id             INTEGER,
    adult          BOOLEAN,
    original_title varchar,
    video          boolean,
    popularity     numeric,
    created_at     timestamp default current_timestamp
);

drop table if exists person_ids;
create table person_ids
(
    id         INTEGER,
    adult      BOOLEAN,
    name       varchar,
    popularity numeric,
    created_at timestamp default current_timestamp
);

drop table if exists production_company_ids;
create table production_company_ids
(
    id         INTEGER,
    name       varchar,
    created_at timestamp default current_timestamp
);

drop table if exists tv_network_ids;
create table tv_network_ids
(
    id         INTEGER,
    name       varchar,
    created_at timestamp default current_timestamp
);

drop table if exists tv_series_ids;
create table tv_series_ids
(
    id            INTEGER,
    original_name varchar,
    popularity    numeric,
    created_at    timestamp default current_timestamp
);