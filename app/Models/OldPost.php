<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class OldPost
{
    private static $path = 'posts.json';

    public static function all()
    {
        if (!Storage::exists(self::$path)) {
            return collect([]);
        }
        
        $json = Storage::get(self::$path);
        return collect(json_decode($json, true));
    }

    public static function find($id)
    {
        return self::all()->firstWhere('id', (int) $id);
    }

    public static function create($data)
    {
        $posts = self::all();
        
        $newPost = [
            'id' => $posts->count() > 0 ? $posts->max('id') + 1 : 1,
            'title' => $data['title'],
            'body' => $data['body'],
        ];

        $posts->push($newPost);

        Storage::put(self::$path, json_encode($posts->values(), JSON_PRETTY_PRINT));

        return $newPost;
    }

    public static function update($data)
    {
        $posts = self::all();
        
        $post = $posts->firstWhere('id', (int) $data['id']);
        $post['title'] = $data['title'];
        $post['body'] = $data['body'];
        $posts = $posts->map(function ($p) use ($post) {
            if ($p['id'] == $post['id']) {
                return $post;
            }
            return $p;
        });
        Storage::put(self::$path, json_encode($posts->values(), JSON_PRETTY_PRINT));

        return $post;
    }

    public static function delete($id)
    {
        $posts = self::all();
        
        $posts = $posts->filter(function ($p) use ($id) {
            return $p['id'] != $id;
        });
        Storage::put(self::$path, json_encode($posts->values(), JSON_PRETTY_PRINT));

        return true;
    }
}
