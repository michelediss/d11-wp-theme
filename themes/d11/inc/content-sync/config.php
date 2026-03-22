<?php

declare(strict_types=1);

return [
    'enabled' => true,
    'content_path' => __DIR__ . '/../../content',
    'source_of_truth' => 'filesystem',
    'runtime_override' => false,
    'runtime_override_environments' => [],
    'post_types' => ['page'],
    'conflict_policy' => 'fail',
    'cache_json_reads' => true,
];
