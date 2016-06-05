<?php namespace App\Models\Traits;

use App\Models\_partials\Tag;
// use App\Models\_partials\Tagged;

trait TagTrait
{
	public function addTag($model,$request)
	  {
          $tags = [];

          $tags[] = $request->has('style') ? Tag::find($request->input('style')) : '';
          $tags[] = $request->has('room') ? Tag::find($request->input('room')) : '';
          $tags[] = $request->has('category') ? Tag::find($request->input('category')) : '';

          if($request->has('skills'))
          {
              foreach ($request->get('skills') as $key=>$value) {
                  $tags[] = Tag::where('name',$value)->first();
              }
          }
          foreach($tags as $tag)
          {
              $tag->increment(class_basename($model).'_count');
              $tag->save();
              $model->tags()->attach($tag);
          }
          return $model;
	  }




	public function removeTag($tag)
	  {
          $tag = $this->model->tags()->where('name', trim($tag))->first();
          $tag->delete() ? $this->decrementModel($this->model,'tag',$tag) : false;
	  }
}

