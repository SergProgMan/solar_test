<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Comment;

class CommentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_can_create_comment(){
        $data = [
            'content' => $this->faker->paragraph,
        ];

        $this->post(route('comment.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function test_can_create_reply(){
        $comment = factory(Comment::class)->create([]);

        $data = [
            'content' => $this->faker->paragraph,
            'parent_id' => $comment->id
        ];
        $this->post(route('comment.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function test_can_update_comment(){
        $comment = factory(Comment::class)->create();

        $data = [
            'content' => $this->faker->paragraph
        ];

        $this->put(route('comment.update', $comment->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_can_delete_comment(){
        $comment = factory(Comment::class)->create();

        $this->delete(route('comment.destroy', $comment->id))
            ->assertStatus(204);
    }

    public function test_can_list_comments(){
        $comments = factory(Comment::class, 2)->create()->map(function($comment){
            return $comment -> only(['id', 'content']);
        });

        $this->get(route('comment.index'))
            ->assertStatus(200);
    }
}
