<?php namespace App\Models\Presenters;

trait TagPresenterTrait
{
 	public function scopeByType($type)
 		{
 			return $query->where('type',$type)->get();
 		} 
 	
 	public function getImage()
 		{
 			logger()->info(__METHOD__);
 			$image = $this->images()->where('type','tag')->first();

 		    $result =  $image ? $image->url.'.'.$image->file : $this->type.'.png';

 		    return $result;
 		}

	public function getCount($type)
		{
			logger()->info(__METHOD__);
			switch ($type) {
				case 'items': return $this->item_count;
					break;				
				case 'tools': return $this->tool_count;
					break;				
				case 'materials': return $this->material_count;
					break;		
				case 'owners': return $this->owner_count;
					break;		
				case 'profi': return $this->profi_count;
					break;		
				case 'shops': return $this->shop_count;
					break;
				default:
					break;
			}
		}
}