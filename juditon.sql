create database juditon_farm;

create or replace table admin
(
    id       int          null,
    username varchar(255) null,
    password varchar(255) null
);

create or replace table animal_categories
(
    id         int auto_increment
        primary key,
    animal     varchar(255) null,
    created_at timestamp    null,
    updated_at timestamp    null
);

create or replace table breeds
(
    id         int auto_increment
        primary key,
    name       varchar(255) null,
    animal     int          not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint breeds_farm_animals_id_fk
        foreign key (animal) references animal_categories (id)
);

create or replace table all_animals
(
    id                int auto_increment
        primary key,
    animal_id         int          not null,
    img               varchar(255) not null,
    tag               varchar(255) not null,
    date_acquired     date         not null,
    breed             int          not null,
    weight            double(8, 2) not null,
    date_last_weighed date         not null,
    gender            varchar(255) not null,
    description       text         null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint all_animals_pk
        unique (tag),
    constraint all_animals_pk2
        unique (tag),
    constraint pigs_breeds_id_fk
        foreign key (breed) references breeds (id),
    constraint pigs_farm_animals_id_fk
        foreign key (animal_id) references animal_categories (id)
)
    collate = utf8mb4_unicode_ci;

create or replace table animal_treatment
(
    id                    int auto_increment
        primary key,
    type                  varchar(255) not null,
    product               varchar(255) not null,
    application_method    varchar(255) not null,
    days_until_withdrawal int          not null,
    technician            varchar(255) not null,
    dosage                int          not null,
    treatment_date        date         not null,
    body_part             varchar(255) not null,
    booster_date          date         not null,
    total_cost            double(8, 2) not null,
    description           text         null,
    created_at            timestamp    null,
    updated_at            timestamp    null,
    animal_id             int          not null,
    constraint animal_treatment_all_animals_id_fk
        foreign key (animal_id) references all_animals (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create or replace table animal_weights
(
    id            int auto_increment
        primary key,
    animal_id     int                                   not null,
    weight        double    default 0                   not null,
    date_measured timestamp default current_timestamp() not null,
    farm          int       default 0                   not null,
    created_at    timestamp                             null,
    updated_at    timestamp                             null,
    weight_gained double    default 0                   not null,
    constraint animal_weight_all_animals_id_fk
        foreign key (animal_id) references all_animals (id)
            on update cascade on delete cascade
);

create or replace table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                          not null,
    connection text                                  not null,
    queue      text                                  not null,
    payload    longtext                              not null,
    exception  longtext                              not null,
    failed_at  timestamp default current_timestamp() not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create or replace table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create or replace table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create or replace table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create or replace index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create or replace table users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    email_verified_at timestamp    null,
    phone             varchar(255) null,
    location          varchar(255) null,
    about             text         null,
    password          varchar(255) not null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

