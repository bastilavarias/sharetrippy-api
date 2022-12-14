<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $type = $request->type ?? null;
        $step = intval($request->step) ?? null;
        $post = null;
        if (($type === 'timeline' || $type === 'blog') && $step === 1) {
            $post = $this->createBasicPost($request->all());
        } else {
            $post = Post::find($request->post_id);
        }
        if ($type === 'timeline') {
            $this->createTimelinePost($post, $request->all(), $step);
        }
    }

    private function createBasicPost($payload)
    {
        $payload = [
            'user_id' => Auth::id(),
            'title' => $payload['title'],
            'introduction' => $payload['introduction'],
            'is_draft' => $payload['is_draft'],
            'type' => $payload['type'],
        ];
        return Post::create($payload);
    }

    private function createTimelinePost(Post $post, $payload, $step)
    {
        if ($step === 1) {
            foreach ($payload['tags'] as &$item) {
                $post->tags()->create(['key' => 'tag', 'title' => $item]);
            }
        } elseif ($step === 2) {
            foreach ($payload['timelines'] as &$timelineInput) {
                $timeline = $post->timelines()->create([
                    'post_id' => $post->id,
                    'title' => $timelineInput['title'],
                    'introduction' => $timelineInput['introduction'],
                    'expenses' => $timelineInput['expenses'],
                    'is_draft' => $payload['is_draft'],
                ]);
                foreach ($timelineInput['activities'] as &$item) {
                    $timeline->activities()->create([
                        'key' => 'activity',
                        'title' => $item['title'],
                        'description' => $item['notes'],
                    ]);
                }
                foreach ($timelineInput['transportations'] as &$item) {
                    $timeline->transportations()->create([
                        'key' => 'transportation',
                        'title' => $item,
                    ]);
                }
                foreach ($timelineInput['destinations'] as &$item) {
                    $timeline
                        ->destinations()
                        ->create(['key' => 'destination', 'title' => $item]);
                }
                foreach ($timelineInput['lodgings'] as &$item) {
                    $timeline->lodgings()->create(['key' => 'lodging', 'title' => $item]);
                }
            }
        }
    }
}
