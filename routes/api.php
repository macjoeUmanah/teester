<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api', 'status_api']], function () {
  
  // User
  Route::get('/user', function (Request $request) {
      return $request->user();
  });

  // Group
  Route::get('/groups', 'API\GroupController@getGroups');
  Route::get('/groups/{id}', 'API\GroupController@get');
  Route::post('/groups', 'API\GroupController@add');
  Route::patch('/groups/{id}', 'API\GroupController@update');
  Route::delete('/groups/{id}', 'API\GroupController@delete');

  // List
  Route::get('/lists', 'API\ListController@getLists');
  Route::get('/lists/{id}', 'API\ListController@get');
  Route::post('/lists', 'API\ListController@add');
  Route::patch('/lists/{id}', 'API\ListController@update');
  Route::delete('/lists/{id}', 'API\ListController@delete');

  // CustomField
  Route::get('/custom-fields', 'API\CustomFieldController@getCustomFields');
  Route::get('/custom-fields/{id}', 'API\CustomFieldController@get');
  Route::post('/custom-fields', 'API\CustomFieldController@add');
  Route::patch('/custom-fields/{id}', 'API\CustomFieldController@update');
  Route::delete('/custom-fields/{id}', 'API\CustomFieldController@delete');

  // Contact
  Route::get('/contacts', 'API\ContactController@getContacts');
  Route::get('/contacts/{id}', 'API\ContactController@get');
  Route::post('/contacts', 'API\ContactController@add');
  Route::patch('/contacts/{id}', 'API\ContactController@update');
  Route::delete('/contacts/{id}', 'API\ContactController@delete');

  // Broadcast
  Route::get('/broadcasts', 'API\BroadcastController@getBroadcasts');
  Route::get('/broadcasts/{id}', 'API\BroadcastController@get');
  Route::post('/broadcasts', 'API\BroadcastController@add');
  Route::patch('/broadcasts/{id}', 'API\BroadcastController@update');
  Route::delete('/broadcasts/{id}', 'API\BroadcastController@delete');
});
