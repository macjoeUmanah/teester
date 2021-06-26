<?php

return [
  'enabled' => true,
  'delete_records_older_than_days' => 30,
  'default_log_name' => 'mailcarry',
  'default_auth_driver' => null,
  'subject_returns_soft_deleted_models' => false,
  'activity_model' => \Spatie\Activitylog\Models\Activity::class,
  'table_name' => 'activity_logs',
];
