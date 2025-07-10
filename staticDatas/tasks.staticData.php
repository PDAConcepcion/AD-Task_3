<?php
// the table of tasks are composed of following columns: id, title, description, status, priority, project_id, assigned_user_id, due_date, created_at, updated_at
return [
    [
        'title' => 'Create wireframes',
        'description' => 'Design wireframes for all main pages',
        'status' => 'completed',
        'priority' => 'high',
        'due_date' => '2024-02-15'
    ],
    [
        'title' => 'Implement authentication',
        'description' => 'Build user login and registration system',
        'status' => 'in_progress',
        'priority' => 'high',
        'due_date' => '2024-03-01'
    ],
    [
        'title' => 'Database design',
        'description' => 'Design database schema and relationships',
        'status' => 'pending',
        'priority' => 'medium',
        'due_date' => '2024-03-15'
    ]
];