<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('allows administrator to enter update page for any task', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    actingAs($user)
        ->get(route('tasks.edit', $task))
        ->assertOk();
});

it('allows administrator to update any task', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    actingAs($user)
        ->put(route('tasks.update', $task), [
            'name' => 'updated task name',
        ])
        ->assertRedirect();

    expect($task->refresh()->name)->toBe('updated task name');
});

it('allows user to update his own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->put(route('tasks.update', $task), [
            'name' => 'updated task name',
        ]);

    expect($task->refresh()->name)->toBe('updated task name');
});

it('does no allow user to update other users task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    actingAs($user)
        ->put(route('tasks.update', $task), [
            'name' => 'updated task name',
        ])
        ->assertNotFound();
});

it('allows administrator to delete task', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect();

    expect(Task::count())->toBe(0);
});

it('allows user to delete his own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect();

    expect(Task::count())->toBe(0);
});

it('does not allow other users to delete tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

    actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertNotFound();
});

it('user is unable to see other people tasks', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $user2 = User::factory()->create();
    $otherTasks = Task::factory()->create(['user_id' => $user2->id]);

    actingAs($user)
        ->get(route('tasks.index'))
        ->assertSeeText($task->name)
        ->assertDontSeeText($otherTasks->name);
});
