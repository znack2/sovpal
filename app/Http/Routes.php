<?php 

Auth::LoginUsingId(3);

Route::when('*', 'csrf', ['post', 'put', 'patch', 'delete']);

// ===== Language =====

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, \Config::get('app.locales'))) {  //&& $this->validate($request, ['locale' => 'required|in:ru,en'])
    	\Session::put('locale', $locale);  
    	//$request->locale        
    }
    return redirect()->back(); // return Response::json(['success' => true], 200);                            
});

Route::get('/',       function(){	
	return redirect()->route(!\Auth::guest()
			 ? 'groups' 
			 : 'pages',['page'=>'landing']);});

Route::get('page/{page}',       ['as' => 'pages',     		  'uses' => 'Controller@getView']);


Route::post('contact',       	['as' => 'ajax.contact',     	'uses' => 'ActionController@contact']);
Route::post('premium',       	['as' => 'ajax.premium',     	'uses' => 'ActionController@premium']);
Route::post('faq',       	    ['as' => 'ajax.faq',     	    'uses' => 'ActionController@faq']);
Route::post('empty_index',      ['as' => 'ajax.empty_index',    'uses' => 'ActionController@empty_index']);
Route::post('empty_profile',    ['as' => 'ajax.empty_profile',  'uses' => 'ActionController@empty_profile']);
Route::get('searchUsers',       ['as' => 'ajax.searchUsers', 	'uses' => 'ActionController@searchUsers']);
Route::get('helper',       		['as' => 'ajax.helper', 		'uses' => 'ActionController@helper']);
//helper
Route::get('selectCategory',  	['as' => 'dropdown_category', 	'uses' => 'ActionController@selectCategory_Element']);

