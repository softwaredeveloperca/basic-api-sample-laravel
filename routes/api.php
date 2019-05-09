<?php

use Illuminate\Http\Request;
use App\Http\Helpers\InfusionsoftHelper;
use App\Module;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('module_reminder_assigner', function(Request $request) {
	
    $InfusionHelper=new InfusionsoftHelper();

    if (!Cache::has('all_tags')){
	Cache::rememberForever('all_tags',  function() use ($InfusionHelper) {
	   return $InfusionHelper->getAllTags();
	});
    }

    $all_tags=collect(Cache::get('all_tags'))->sortBy('name');
    
    if($request->has('contact_email'))
    {
	$contact=$InfusionHelper->getContact($request->contact_email);
	if(empty($contact))
	{
		return response()->json(false, 404);
	}    

	$modules=explode(",", $contact['Groups']);
	$courses=explode(",", $contact['_Products']);

	collect(Cache::get('all_tags'))
			->sortBy('name')
			->each(function ($tag, $key) use ($courses, $modules, $contact) {
			foreach($courses as $course_key => $course)
			{
			    if(str_contains($tag['name'], strtoupper($course))
			       && !(in_array($tag['id'], $modules))
			    ){
				    dd($tag['name']);
				 $InfusionHelper->addTag($contact['id'], $tag['id']);

		                 return response()->json("Success", 204);
			    } 				     
			}	  
        });
    }

    return response()->json(null, 400);
});
