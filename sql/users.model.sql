CREATE TABLE IF NOT EXISTS public.users (
    id uuid DEFAULT gen_random_uuid () NOT NULL PRIMARY KEY,
    first_name varchar(255) NOT NULL,
    middle_name varchar(255),
    last_name varchar(255) NOT NULL,
    email varchar(255) UNIQUE,
    password varchar(255) NOT NULL,
    username varchar(255) UNIQUE NOT NULL,
    "role" varchar(255) NOT NULL DEFAULT 'user',
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP
);