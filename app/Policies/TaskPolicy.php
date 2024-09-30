<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return $user->is_admin || $task->user_id === $user->id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->is_admin || $task->user_id === $user->id;
    }
}
