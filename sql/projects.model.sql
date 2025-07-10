CREATE TABLE IF NOT EXISTS public.projects (
    id uuid DEFAULT gen_random_uuid () NOT NULL PRIMARY KEY,
    name varchar(225) NOT NULL,
    description text,
    start_date date,
    end_date date,
    status varchar(50) DEFAULT 'active' NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL
);