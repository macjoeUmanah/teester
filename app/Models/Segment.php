<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
  protected $fillable = ['name', 'type', 'attributes', 'action', 'total', 'processed', 'is_running', 'list_id_action', 'app_id', 'user_id'];

  /**
   * Retrun query assoicate with APP-ID
  */
  public function scopeApp($query)
  {
    return $query->where('app_id', \Auth::user()->app_id);
  }

  /*
   * Return query after accroding to the conditions as set for 'by list segment'
  */
  public static function querySegmentList($attributes)
  { 
    $table_prefix = \DB::getTablePrefix();
    $attributes = json_decode($attributes);
    $query = \App\Models\Contact::whereIn('contacts.list_id', $attributes->list_ids)
      ->select('contacts.*');

    // contact filter
    if(!empty($attributes->contact_filter)) {
      foreach ($attributes->contact_filter as $contact_filter) {
        // if value exist for contact filter
        if(!empty($contact_filter->value)) {
          $table_contacts = "{$table_prefix}contacts";
          // if more than one values with comman (,)
          $contact_filter_segment = explode(',', $contact_filter->value);
          $contact_filter_query = '(FALSE ';
          foreach($contact_filter_segment as $filter_value) {
            $filter_value = trim($filter_value);
            if($contact_filter->name == 'email') {
              if($contact_filter->action == 'is') {
                $contact_filter_query .= " OR {$table_contacts}.email = '{$filter_value}'";
              } elseif($contact_filter->action == 'is_not') {
                $contact_filter_query .= " OR {$table_contacts}.email <> '{$filter_value}'";
              } elseif($contact_filter->action == 'contain') {
                $contact_filter_query .= " OR {$table_contacts}.email LIKE '%{$filter_value}%'";
              } elseif($contact_filter->action == 'not_contain') {
                $contact_filter_query .= " OR {$table_contacts}.email NOT LIKE '%{$filter_value}%'";
              }
            } elseif($contact_filter->name == 'status') {
              if($contact_filter->action == 'is') {
                $contact_filter_query .= " OR {$table_contacts}.active = 'Yes'";
              } elseif($contact_filter->action == 'is_not') {
                $contact_filter_query .= " OR {$table_contacts}.active = 'No'";
              }
            } elseif($contact_filter->name == 'format') {
              if($contact_filter->action == 'is') {
                $contact_filter_query .= " OR {{$table_contacts}.active = 'Yes'";
              } elseif($contact_filter->action == 'is_not') {
                $contact_filter_query .= " OR {$table_contacts}.active = 'No'";
              }
            } elseif($contact_filter->name == 'source') {
              if($contact_filter->action == 'is') {
                $contact_filter_query .= " OR {$table_contacts}.active = 'Yes'";
              } elseif($contact_filter->action == 'is_not') {
                $contact_filter_query .= " OR {$table_contacts}.active = 'No'";
              }
            }
          }
          $contact_filter_query .= ')';
          $query->whereRaw($contact_filter_query);
        } // end if $contact_filter->value
      }
    } // end if contact filter

    if(!empty($attributes->custom_fields_filter) || !empty($attributes->dates_filter)) {
      $query->leftJoin('custom_field_contact', 'contacts.id', '=', 'custom_field_contact.contact_id');
    }

    // custom fields filter
    if(!empty($attributes->custom_fields_filter)) {
      foreach ($attributes->custom_fields_filter as $custom_fields_filter) {
        // if value exist for custom field filter
        if(!empty($custom_fields_filter->value)) {
          $filter_value = trim($custom_fields_filter->value);
          $custom_fields_filter_segment = explode(',', $custom_fields_filter->value);
          $custom_fields_filter_query = '(FALSE ';
          foreach($custom_fields_filter_segment as $filter_value) {
            $filter_value = trim($filter_value);
            if($custom_fields_filter->action == 'is') {
              $custom_fields_filter_query .= " OR ({$table_prefix}custom_field_contact.custom_field_id = {$custom_fields_filter->name} AND {$table_prefix}custom_field_contact.data = '{$filter_value}' )";
            } elseif($custom_fields_filter->action == 'is_not') {
              $custom_fields_filter_query .= " OR ({$table_prefix}custom_field_contact.custom_field_id = {$custom_fields_filter->name} AND {$table_prefix}custom_field_contact.data <> '{$filter_value}' )";
            } elseif($custom_fields_filter->action == 'contain') {
              $custom_fields_filter_query .= " OR ({$table_prefix}custom_field_contact.custom_field_id = {$custom_fields_filter->name} AND {$table_prefix}custom_field_contact.data LIKE '%{$filter_value}%' )";
            } elseif($custom_fields_filter->action == 'not_contain') {
              $custom_fields_filter_query .= " OR ({$table_prefix}custom_field_contact.custom_field_id = {$custom_fields_filter->name} AND {$table_prefix}custom_field_contact.data NOT LIKE '%{$filter_value}%' )";
            }
          }
          $custom_fields_filter_query .= ')';
          $query->whereRaw($custom_fields_filter_query);
        }
      }
    } // end if custom fields filter

    // date fields filter
    if(!empty($attributes->dates_filter)) {
      foreach ($attributes->dates_filter as $dates_filter) {
        // if value exist for custom field filter
        if(!empty($dates_filter->value)) {
          $filter_value = trim($dates_filter->value);

          if($dates_filter->name == 'subscription_date') {
            if($dates_filter->action == 'is') {
              $dates_filter_query = " (STR_TO_DATE({$table_prefix}contacts.created_at, '%Y-%m-%d') = STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'is_not') {
              $dates_filter_query = " (STR_TO_DATE({$table_prefix}contacts.created_at, '%Y-%m-%d') <> STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'after') {
              $dates_filter_query = " (STR_TO_DATE({$table_prefix}contacts.created_at, '%Y-%m-%d') > STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'before') {
              $dates_filter_query = " (STR_TO_DATE({$table_prefix}contacts.created_at, '%Y-%m-%d') < STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            }
          } else {
            if($dates_filter->action == 'is') {
              $dates_filter_query = " ( {$table_prefix}custom_field_contact.custom_field_id = {$dates_filter->name} AND STR_TO_DATE({$table_prefix}custom_field_contact.data, '%d-%m-%Y') = STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'is_not') {
              $dates_filter_query = " ( {$table_prefix}custom_field_contact.custom_field_id = {$dates_filter->name} AND STR_TO_DATE({$table_prefix}custom_field_contact.data, '%d-%m-%Y') <> STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'after') {
              $dates_filter_query = " ( {$table_prefix}custom_field_contact.custom_field_id = {$dates_filter->name} AND STR_TO_DATE({$table_prefix}custom_field_contact.data, '%d-%m-%Y') > STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            } elseif($dates_filter->action == 'before') {
              $dates_filter_query = " ( {$table_prefix}custom_field_contact.custom_field_id = {$dates_filter->name} AND STR_TO_DATE({$table_prefix}custom_field_contact.data, '%d-%m-%Y') < STR_TO_DATE('{$filter_value}', '%d-%m-%Y') )";
            }
          }
          $query->whereRaw($dates_filter_query);
        }
      }
    } // end if date fields filter
    return $query;
  }

  /*
   * Return query after accroding to the conditions as set for 'by campaign segment'
  */
  public static function querySegmentCampaign($attributes, $user_id)
  {
    $attributes = json_decode($attributes);
    $offset =  \Helper::timeZonesOffset(\App\Models\User::getUserValue($user_id, 'time_zone'));
    $table_prefix = \DB::getTablePrefix();

    $query = \App\Models\ScheduleCampaignStat::whereIn('schedule_campaign_stats.id', $attributes->schedule_campaign_stat_ids)
      ->join('schedule_campaign_stat_logs', 'schedule_campaign_stats.id', '=', 'schedule_campaign_stat_logs.schedule_campaign_stat_id');


      if(!empty($attributes->action_segment) && ($attributes->action_segment == 'is_opened' || $attributes->action_segment == 'is_not_opened')) {
        $query->leftJoin('schedule_campaign_stat_log_opens', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_opens.schedule_campaign_stat_log_id');

        $attributes->action_segment == 'is_opened' 
          ? $query->whereIn('schedule_campaign_stat_logs.status', ['Opened', 'Clicked', 'Unsubscribed'])
          : $query->whereIn('schedule_campaign_stat_logs.status', ['Sent', 'Bounced', 'Spam', 'Failed']);

        if($attributes->action_segment == 'is_opened') {
          // not all the countries, then we need to get the country that not set for open total 242 country
          if(!empty($attributes->countries) && count($attributes->countries) != 242) {
            $query->whereIn('schedule_campaign_stat_log_opens.country_code', $attributes->countries);
          }
        }

        if($attributes->action_segment == 'is_opened') {
          $query->select('schedule_campaign_stat_logs.id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_log_opens.country', 'schedule_campaign_stat_logs.list',
            \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_logs.created_at, '+00:00', '{$offset}') as sent_datetime"),
            \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_log_opens.created_at, '+00:00', '{$offset}') as open_datetime"));
        } else {
          // Distinct should work properly
          $query->select('schedule_campaign_stat_logs.id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list',
            \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_logs.created_at, '+00:00', '{$offset}') as sent_datetime")
          );
        }
      } elseif(!empty($attributes->action_segment) && $attributes->action_segment == 'is_clicked') {
        $query->leftJoin('schedule_campaign_stat_log_clicks', 'schedule_campaign_stat_logs.id', '=', 'schedule_campaign_stat_log_clicks.schedule_campaign_stat_log_id');

        $query->whereIn('schedule_campaign_stat_logs.status', ['Clicked', 'Unsubscribed']);

        if(!empty($attributes->links)) {
          $query->whereIn('schedule_campaign_stat_log_clicks.link', $attributes->links);
        }

        $query->select('schedule_campaign_stat_logs.id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_log_clicks.country', 'schedule_campaign_stat_log_clicks.link', 'schedule_campaign_stat_logs.list',
          \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_logs.created_at, '+00:00', '{$offset}') as sent_datetime"),
          \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_log_clicks.created_at, '+00:00', '{$offset}') as open_datetime"));
      } elseif(!empty($attributes->action_segment) && $attributes->action_segment == 'both') {
        $query->select('schedule_campaign_stat_logs.id', 'schedule_campaign_stat_logs.email', 'schedule_campaign_stat_logs.list',
          \DB::raw("CONVERT_TZ({$table_prefix}schedule_campaign_stat_logs.created_at, '+00:00', '{$offset}') as sent_datetime")
        );
      }
      return $query;
  }
}