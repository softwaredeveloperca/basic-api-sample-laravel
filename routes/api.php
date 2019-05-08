<?php

use Illuminate\Http\Request;
use App\Http\Helpers\InfusionsoftHelper;
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

    if($request->has('contact_email'))
    {
	$contact=$InfusionHelper->getContact($request->contact_email);
	if(empty($contact))
	{
		return response()->json(null, 404);
	}    
	return response()->json($contact, 204);	
    }
    return response()->json(null, 400);
});
