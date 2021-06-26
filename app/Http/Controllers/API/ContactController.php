<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ContactAdded;
use App\Models\Contact;
use Helper;

class ContactController extends Controller
{
  /**
   * Retrun a contact detail
  */
  public function get(Request $request, $id)
  {
    $contact = Contact::whereAppId($request->user('api')->app_id)
      ->whereId($id)
      ->with('customFields')
      ->first();

    if(!empty($contact)) {
      $data = [
        'id' => $contact->id,
        'email' => $contact->email,
        'list_id' => $contact->list_id,
        'list_name' => $contact->list->name,
        'format' => $contact->format,
        'active' => $contact->active,
        'confirmed' => $contact->confirmed,
        'unsubscribed' => $contact->unsubscribed,
        'source' => $contact->source,
        'created_at' => \Helper::datetimeDisplay($contact->created_at),
      ];

      $custom_field_data = [];
      foreach($contact->customFields as $custom_field) {
        $custom_field_data[$custom_field->name] = $custom_field->pivot->data;
      }
      array_push($data, ['custom_fields' => $custom_field_data]);
      $status = __('app.success');
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Retrun contacts
  */
  public function getContacts(Request $request)
  {
    $result = Contact::whereAppId($request->user('api')->app_id)
      ->with('list')
      ->with('customFields');

    if(!empty($request->list_id))
      $result->whereListId($request->list_id);

    if(!empty($request->start_from))
      $result->offset($request->start_from);

    $data = $result->limit(500)->get();
    return Helper::apiReturn(__('app.success'), $data);
  }

  /**
   * Add a contact
  */
  public function add(Request $request)
  {

    $input = $this->contactData($request);
    $status = __('app.error');

    if(!Helper::allowedLimit($input['app_id'], 'no_of_recipients', 'contacts')) {
      $data = [
        'message' =>  __('app.msg_limit_over') . __('app.contacts')
      ];
      return Helper::apiReturn($status, $data);
    }

    $input['list_id'] = !empty($request->list_id) ? $request->list_id : null;

    if(empty($input['email'])) {
      $data = [
        'message' => 'email' . __('app.is_required'),
      ];
    } elseif(empty($input['list_id'])) {
      $data = [
        'message' => 'list_id' . __('app.is_required'),
      ];
    } else{
      if(!\App\Models\Lists::whereId($input['list_id'])->whereAppId($input['app_id'])->exists()) {
        $data = [
          'message' => 'list_id' . __('app.not_exist'),
        ];
      } else {
        $contact = Contact::whereEmail($input['email'])->whereListId($input['list_id'])->select('id')->with('customFields')->first();
        if(!empty($contact->id)) {
          $data = [
            'id' => $contact->id,
            'message' => __('app.email') . __('app.already_exist'),
          ];
        } else {
          $contact = Contact::create($input);

          if(!empty($input['custom_fields'])) {
            app('App\Http\Controllers\ContactController')->contactCustomData($contact->id, $input['custom_fields']);
          }
          
          activity('create')->withProperties(['app_id' => $input['app_id']])->log(__('app.contact') . " ({$input['email']}) ". __('app.log_create')); // log

          // custom data for contact
          app('App\Http\Controllers\ContactController')->contactCustomData($contact->id, $input);

          // send email to subscriber and notifiy to list admin
          if($input['confirm'] == 'Yes') {
            $subscriber_email = $contact->list->double_optin == 'Yes' ? 'confirm-email-app' : 'welcome-email';
            $contact->notify(new ContactAdded($subscriber_email, 'api', 'notify-email-contact-added'));
            \Artisan::call('queue:work', ['--once' => true]); // execute queue
          }

          $status = __('app.success');
          $data = [
            'id' => $contact->id,
            'email' => $input['email']
          ];
        }
      }
    }

    return Helper::apiReturn($status, $data);
  }

  /**
   * Update a contact 
  */
  public function update(Request $request, $id)
  {
    $input = $this->contactData($request);
    $status = __('app.error');
    if($request->email && empty($input['email'])) {
      $data = [
        'message' => 'email' . __('app.is_required'),
      ];
    } else{
      if(!\App\Models\Lists::whereId($input['list_id'])->whereAppId($input['app_id'])->exists()) {
        $data = [
          'message' => 'list_id' . __('app.not_exist'),
        ];
      } else {
        try {
          $contact = Contact::findOrFail($id);
          // List can't be changes, safe side if api receive a list_id
          $input['list_id'] = $contact->list_id;
          $input['email'] = empty($input['email']) ? $contact->email : $input['email'];
          $contact->fill($input)->save();

          if(!empty($input['custom_fields'])) {
            foreach($input['custom_fields'] as $custom_field_id => $custom_field_value) {
              echo $custom_field_id;
              \DB::table('custom_field_contact')->insert([
                'contact_id' => $contact->id,
                'custom_field_id' => $custom_field_id,
                'data' => $custom_field_value
              ]);
            }
          }
          activity('update')->withProperties(['app_id' => $input['app_id']])->log(__('app.contact') . " ({$input['email']}) ". __('app.log_update')); // log
          $status = __('app.success');
          $data = [
            'id' => $id,
            'message' => __('app.contact') .' '. __('app.log_update'),
          ];
        } catch (\Exception $e) {
          $data = [
            'message' => null,
          ];
        }
      }
    }
    return Helper::apiReturn($status, $data);
  }

  /**
   * Return inputed data
  */
  public function contactData($request)
  {
    $input = $request->all();
    $input['email'] = !empty($input['email']) ? trim($input['email']) : null;
    $input['format'] = !empty($input['format']) ? $input['format'] : 'HTML';
    $input['active'] = !empty($input['active']) ? $input['active'] : 'Yes';
    $input['confirm'] = !empty($input['confirm']) ? $input['confirm'] : 'Yes';
    $input['unsubscribed'] = !empty($input['unsubscribed']) ? $input['unsubscribed'] : 'No';
    $input['source'] = 'api';
    $input['user_id'] = $request->user('api')->id;
    $input['app_id'] = $request->user('api')->app_id;
    return $input;
  }

  /**
   * Delete a contact
  */
  public function delete(Request $request, $id)
  {
    $email = Contact::whereId($id)->whereAppId($request->user('api')->app_id)->value('email');
    if(!empty($email)) {
      $destroy = Contact::destroy($id);
      activity('delete')->withProperties(['app_id' => $request->user('api')->app_id])->log(__('app.contact') . " ({$email}) ". __('app.log_delete'));

      $status = __('app.success');
      $data = [
        'id' => $id,
        'name' => $email
      ];
    } else {
      $status = __('app.error');
      $data = ['message' => __('app.no_record_found')];
    }
    return Helper::apiReturn($status, $data);
  }
}
