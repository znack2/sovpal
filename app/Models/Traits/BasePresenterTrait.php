<?php namespace App\Models\Traits;

trait BasePresenterTrait
{
	public function getPrevious()
    {
        logger()->info(__METHOD__);
        // User::where('id', '>', $currentUser->id)->min('id');
        return $this->id == 1 ? $this->where('id', '<', $this->id)->orderBy('id','asc')->first() : -1;
    }



	public function getNext()
    {
        logger()->info(__METHOD__);
        // User::where('id', '<', $currentUser->id)->max('id');
//        check worj or not?
        return $this->id == $this->count() ? $this->where('id', '>', $this->id)->orderBy('id','asc')->first() : +1;
    }



    public function getImages($type = null)
    {
        logger()->info(__METHOD__);
        return isset($type) ? $this->images()->where('type',$type)->all() : $this->images()->all();
    }



    public function getTags($type = null)
    {
        logger()->info(__METHOD__);
        return isset($type) ? $this->tags()->where('type',$type)->all() : $this->tags()->all();
    }




    public function getCount($type)
    {
//        - getCount from user->item_count
        logger()->info(__METHOD__);
        return isset($type) ? $this->items()->where('type',$type)->count() : $this->items()->count();
    }




    public function getImage($type,$alt = false)
    {
        logger()->info(__METHOD__);
        $images = $type == 'group' ? $this->item->images() : $this->images();
        $image = $images->where('type',$type)->first();
        $result =  $image ? $image->url.'.'.$image->file : $this->type.'.png';
        return isset($alt)  ? 'image'.$type.'for'.$this->first_name : $result;
    }



    public function getTag($type = null,$example = null)
    {
        logger()->info(__METHOD__);
        $tags = isset($type) ? $this->tags()->where('type',$type) : $this->tags();
        $tag = isset($example) ? $tags->where('name',$example)->first() : $tags->first();

        isset($tag) && $tag->name == $example ? true : false;
        return $tags->first() ? $tag['name'] : 'default';
    }
}
