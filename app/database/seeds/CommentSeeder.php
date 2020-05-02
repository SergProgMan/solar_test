<?php

use Illuminate\Database\Seeder;
use App\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Comment::class, 5)->create(['parent_id' => null])->each(function ($comment) {
            $this->makeChildComments($comment);
        });
    }

    /**
     * Make comment child
     * @param Comment $comment
     * @param int $level
     */
    private function makeChildComments(Comment $comment, int $level = 1){
        $comments_count = rand(0,3);
        if($comments_count){
            $childComments = factory(Comment::class,$comments_count)->create([
                'parent_id' => $comment->id,
            ]);

            if($level < 5){
                foreach ($childComments as $childComment){
                    $this->makeChildComments($childComment, $level+1);
                }
            }

        }
    }
}
