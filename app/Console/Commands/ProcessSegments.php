<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Segment;
use App\Models\Contact;
use App\Models\Lists;
use League\Csv\Writer;

class ProcessSegments extends Command
{
  protected $signature = 'mc:process-segments';
  protected $description = 'Process the segments';

  public function __construct()
  {
    parent::__construct();
  }
  public function handle()
  {
    // Get campaings that have the status is not running
    $segments = Segment::whereIsRunning(0)->get();
    foreach($segments as $segment) {
      // Next cron will not entertain this segment until finished
      Segment::whereId($segment->id)->update(['is_running' => 1]);
      if($segment->type == 'List') {
        $query = Segment::querySegmentList($segment->attributes);
        $query->orderBy('id', 'DESC')->distinct();
        $total = $query->count('id'); // Get total contacts
      } elseif($segment->type == 'Campaign') {
        $query = Segment::querySegmentCampaign($segment->attributes, $segment->user_id);
        $query->orderBy('schedule_campaign_stat_logs.id', 'DESC')->distinct();
        $total = $query->count('schedule_campaign_stat_logs.id'); // Get total emails
      }

      // Update total for segment
      Segment::whereId($segment->id)->update(['total' => $total]);

      if($segment->type == 'List') {
        if(!empty($segment->action)) {
          $writer = null;
          if($segment->action == 'Export') {
            $path_export_segment = str_replace('[user-id]', $segment->user_id, config('mc.path_export_segment'));
            \Helper::dirCreateOrExist($path_export_segment); // Create dir if not exist
            $file = $path_export_segment.str_slug($segment->name).'-'.\Helper::uniqueID().'.csv';
            $writer = Writer::createFromPath($file, 'w+'); // Create a .csv file to write data
            $file_header = [
              __('app.id'),
              __('app.contact_email'),
              __('app.list_id'),
              __('app.format'),
              __('app.active'),
              __('app.confirmed'),
              __('app.unsubscribed'),
              __('app.created'),
            ];

            $lists = Lists::whereIn('id', json_decode($segment->attributes)->list_ids)->with('customFields')->get();

            $list_custom_fields_real = [];
            foreach($lists as $list) {
              foreach($list->customFields as $custom_field) {
                // need to merge into contact files to make array with same lenght
                // if not in array it will when more than one lists 
                if(!in_array($custom_field->name, $list_custom_fields_real)) {
                  array_push($list_custom_fields_real, $custom_field->name);
                }
              }
            }

            $file_header = array_merge($file_header, $list_custom_fields_real);

            $writer->insertOne($file_header); // Write file header
          }

          // Get segmented data with 1000 limit
          $query->chunk(1000, function($contacts) use ($segment, $writer, $list_custom_fields_real) {
            foreach($contacts as $contact) {
              if($segment->action == 'Move' || $segment->action == 'Keep Moving') {
                try {
                  Contact::whereId($contact->id)->update(['list_id' => $segment->list_id_action]);
                  Segment::whereId($segment->id)->increment('processed'); // Update counter
                } catch(\Exception $e) {
                  Contact::destroy($contact->id); // If already exist in new then need to delete from old
                  //echo $e->getMessage();
                }
              } elseif($segment->action == 'Copy' || $segment->action == 'Keep Copying') {
                try {
                  $contact->list_id = $segment->list_id_action; // Update list id for contact
                  $clone = $contact->replicate();
                  $clone->save(); // Clone contact detail

                  // Need to add custom data for contact
                  $contact_custom_fields = $contact->customFields()->get()->toArray();
                  $custom_field_data = [];
                  foreach($contact_custom_fields as $field) {
                    $field['pivot']['contact_id'] = $clone->id;
                    $clone->customFields()->attach($field['pivot']['custom_field_id'], $field['pivot']);
                  }
                  Segment::whereId($segment->id)->increment('processed'); // Update counter
                } catch(\Exception $e) {
                  //echo $e->getMessage();
                  // already exist
                }
              } elseif($segment->action == 'Export') {
                $contact_data = [
                  $contact->id,
                  $contact->email,
                  $contact->list_id,
                  $contact->format,
                  $contact->active,
                  $contact->confirmed,
                  $contact->unsubscribed,
                  $contact->created_at,
                ];
                $contact_custom_fields = $contact->customFields()->get()->toArray();

                // flip keys with values so data will be mapped correctly
                $list_custom_fields = array_flip($list_custom_fields_real);

                // assign null to all otherwise key will be print
                foreach ($list_custom_fields as $key => $value) {
                  $list_custom_fields[$key] = null;
                }

                foreach($contact_custom_fields as $custom_field) {
                  $list_custom_fields[$custom_field['name']] = $custom_field['pivot']['data'];
                }

                // merge both original and custom fields array
                $contact_data = array_merge($contact_data, $list_custom_fields);

                $writer->insertOne($contact_data); // Write contact info
                Segment::whereId($segment->id)->increment('processed'); // Update counter
              }
            } // End foreach contacts
          }); // End chunk

        }
      } elseif($segment->type == 'Campaign') {
        if(!empty($segment->action)) {
          $writer = null;
          if($segment->action == 'Export') {
            $path_export_segment = str_replace('[user-id]', $segment->user_id, config('mc.path_export_segment'));
            \Helper::dirCreateOrExist($path_export_segment); // Create dir if not exist
            $file = $path_export_segment.str_slug($segment->name).'-'.\Helper::uniqueID().'.csv';
            $writer = Writer::createFromPath($file, 'w+'); // Create a .csv file to write data
            $action = json_decode($segment->attributes)->action_segment;
            if($action == 'is_opened') {
              $file_header = [
                __('app.list'),
                __('app.contact_email'),
                __('app.sent'),
                __('app.opens'),
              ];
            } elseif($action == 'is_clicked') {
              $file_header = [
                __('app.list'),
                __('app.contact_email'),
                __('app.sent'),
                __('app.clicks'),
                __('app.link'),
              ];
            } else {
              $file_header = [
                __('app.list'),
                __('app.contact_email'),
                __('app.sent'),
              ];
            }
            
            $lists = \App\Models\ScheduleCampaignStatLog::whereIn('schedule_campaign_stat_id', json_decode($segment->attributes)->schedule_campaign_stat_ids)->select('list')->distinct()->get();

            $list_custom_fields_real = [];
            foreach($lists as $list_name) {
              try {
                $list =  Lists::where('name', $list_name->list)->with('customFields')->first();
                foreach($list->customFields as $custom_field) {
                  // need to merge into contact files to make array with same lenght
                  // if not in array it will when more than one lists 
                  if(!in_array($custom_field->name, $list_custom_fields_real)) {
                    array_push($list_custom_fields_real, $custom_field->name);
                  }
                }
              } catch(\Exception $e) {}
            }

            $file_header = array_merge($file_header, $list_custom_fields_real);

            $writer->insertOne($file_header); // Write file header

            $query->chunk(1000, function($sents) use ($segment, $writer, $list_custom_fields_real) {
              $action = json_decode($segment->attributes)->action_segment;
              foreach($sents as $sent) {
                $sent_data = [
                  $sent->list,
                  $sent->email,
                  $sent->sent_datetime
                ];

                if($action == 'is_opened') {
                  array_push($sent_data, $sent->open_datetime);
                } elseif($action == 'is_clicked') {
                  array_push($sent_data, $sent->open_datetime, $sent->link);
                } else {
                  array_push($sent_data, '');
                }

                try {
                  $list_id = Lists::whereName(trim($sent->list))->value('id');
                  if(!empty($list_id)) {
                    $contact = Contact::whereEmail(trim($sent->email))->whereListId($list_id)->first();
                    $contact_custom_fields = $contact->customFields()->get()->toArray();

                    // flip keys with values so data will be mapped correctly
                    $list_custom_fields = array_flip($list_custom_fields_real);

                    // assign null to all otherwise key will be print
                    foreach ($list_custom_fields as $key => $value) {
                      $list_custom_fields[$key] = null;
                    }

                    foreach($contact_custom_fields as $custom_field) {
                      $list_custom_fields[$custom_field['name']] = $custom_field['pivot']['data'];
                    }
                    // merge both original and custom fields array
                    $sent_data = array_merge($sent_data, $list_custom_fields);
                  }
                } catch(\Exception $e) { }

                $writer->insertOne($sent_data); // Write contact info
                Segment::whereId($segment->id)->increment('processed'); // Update counter
              }
            });
          } elseif($segment->action == 'Copy' || $segment->action == 'Keep Copying') {
            $query->chunk(1000, function($sents) use ($segment) {
              foreach($sents as $sent) {
                try {
                  $data['list_id'] = $segment->list_id_action;
                  $data['email'] = $sent->email;
                  $data['user_id'] = $segment->user_id; // data can come from webform
                  $data['app_id'] = $segment->app_id; // data can come from webform
                  $data['format'] = 'HTML';
                  $data['active'] = 'Yes';
                  $data['unsubscribed'] = 'No';
                  $data['confirmed'] = 'Yes';
                  $data['verified'] = 'Yes';
                  $contact = Contact::create($data);
                  Segment::whereId($segment->id)->increment('processed'); // Update counter
                } catch(\Exception $e) {
                  //echo $e->getMessage();
                  // already exist
                }
              }
            });
          }
        }
      }

      if(!empty($segment->action) && ($segment->action != 'Keep Copying' && $segment->action != 'Keep Moving')) {
        $attributes = null;
        if($segment->action == 'Export') {
          // Save notification for user to inform and download
          $notification_name = __('app.segment'). " ({$segment->name}) "  . __('app.msg_export_successfully');
          $attributes = [
            'file' => $file
          ];
          $type = 'export';
        } elseif($segment->action == 'Copy') {
          $notification_name = __('app.segment'). " ({$segment->name}) "  . __('app.log_copy');
          $type = 'copy';
        } elseif($segment->action == 'Move') {
          $notification_name = __('app.segment'). " ({$segment->name}) "  . __('app.log_move');
          $type = 'move';
        }

        $notification_attributes = json_encode($attributes);
        $notification = [
          'name' => $notification_name,
          'type' => $type,
          'attributes' => $notification_attributes,
          'app_id' => $segment->app_id,
          'user_id' => $segment->user_id
        ];
        \App\Models\Notification::create($notification);
      }

      // Need to update the data, so the segment will be entertain with next operation if any
      if($segment->action != 'Keep Copying' && $segment->action != 'Keep Moving') {
        Segment::whereId($segment->id)->update(['action' => NULL, 'is_running' => 0, 'processed' => 0]);
      } else {
        Segment::whereId($segment->id)->update(['is_running' => 0]);
      }
    } // End foreach segments
  }
}
