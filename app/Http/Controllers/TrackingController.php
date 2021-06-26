<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;

class TrackingController extends Controller
{

  /**
   * Update the staus to opened; for a sent campaign
  */
  public function openSchedule($id)
  {
    $id = (int) base64_decode($id);
    $last_entry_diff_sec = $this->lastEntryDiffSec('opens', $id);
    // Avoid to duplicat entries within  secs
    if($last_entry_diff_sec > 10) {
      // Only Sent should be update to Open
      \App\Models\ScheduleCampaignStatLog::whereId($id)->whereStatus('Sent')->update(['status' => 'Opened']);

      $ip = Helper::getClientIP();
      // Get geographical detail
      $data = Helper::getGeoInfo($ip);
      $data['schedule_campaign_stat_log_id'] = $id;
      $data['ip'] = $ip;
      $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      $data['created_at'] = \Carbon\Carbon::now();
      try {
        // Save open data
        \App\Models\ScheduleCampaignStatLogOpen::create($data);
      } catch(\Exception $e) {
        //echo $e->getMessage();
      }
    }
  }
  /**
   * Update the staus to clicked; for a sent email
  */
  public function clickSchedule($id, $url)
  {
    $encoded_id = $id;
    $id = (int) base64_decode($id);
    $url = Helper::base64url_decode($url);

    // For some reason it clicks to
    if($url != 'aHR0cHM' && $url != 'aHR0cDo') {
      $last_entry_diff_sec = $this->lastEntryDiffSec('clicks', $id);
      // Avoid to duplicat entries within 10 secs
      if($last_entry_diff_sec > 10) {
        \App\Models\ScheduleCampaignStatLog::whereId($id)->update(['status' => 'Clicked']);
        $ip = Helper::getClientIP();
        // Get geographical detail
        $data = Helper::getGeoInfo($ip);
        $data['schedule_campaign_stat_log_id'] = $id;
        $data['ip'] = $ip;
        $data['link'] = $url;
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['created_at'] = \Carbon\Carbon::now();

        // In case of any error, the redirect must execute
        try {
          \App\Models\ScheduleCampaignStatLogClick::create($data);

          // if not record in the open for some reason
          if(!\App\Models\ScheduleCampaignStatLogOpen::whereScheduleCampaignStatLogId($id)->exists()) {
            try{
              $this->openSchedule($encoded_id);
            } catch(\Exception $e) {
              //echo $e->getMessage();
            }
          }
        } catch(\Exception $e) {
          //echo $e->getMessage();
        }
      }
      return redirect($url);
    }
  }

  /**
   * Update the staus to opened; for a sent drip
  */
  public function openScheduleDrip($id)
  {
    $id = (int) base64_decode($id);
    $last_entry_diff_sec = $this->lastEntryDiffSec('opens', $id);
    // Avoid to duplicat entries within 10 secs
    if($last_entry_diff_sec > 10) {
      // Only Sent should be update to Open
      \App\Models\ScheduleDripStatLog::whereId($id)->whereStatus('Sent')->update(['status' => 'Opened']);

      $ip = Helper::getClientIP();
      // Get geographical detail
      $data = Helper::getGeoInfo($ip);
      $data['schedule_drip_stat_log_id'] = $id;
      $data['ip'] = $ip;
      $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      $data['created_at'] = \Carbon\Carbon::now();

      try {
        // Save open data
        \App\Models\ScheduleDripStatLogOpen::create($data);
      }  catch(\Exception $e) {
        //echo $e->getMessage();
      }
    }
  }

    /**
   * Update the staus to clicked; for a sent email
  */
  public function clickScheduleDrip($id, $url)
  {
    $encoded_id = $id;
    $id = (int) base64_decode($id);
    $url = Helper::base64url_decode($url);
    // For some reason it clicks to
    if($url != 'aHR0cHM' && $url != 'aHR0cDo') {
      $last_entry_diff_sec = $this->lastEntryDiffSec('clicks', $id);
      // Avoid to duplicat entries within 10 secs
      if($last_entry_diff_sec > 10) {
        \App\Models\ScheduleDripStatLog::whereId($id)->update(['status' => 'Clicked']);
        $ip = Helper::getClientIP();
        // Get geographical detail
        $data = Helper::getGeoInfo($ip);
        $data['schedule_drip_stat_log_id'] = $id;
        $data['ip'] = $ip;
        $data['link'] = $url;
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['created_at'] = \Carbon\Carbon::now();

        // In case of any error, the redirect must execute
        try {
          \App\Models\ScheduleDripStatLogClick::create($data);

          // if not record in the open for some reason
          if(!\App\Models\ScheduleDripStatLogOpen::whereScheduleDripStatLogId($id)->exists()) {
            try{
              $this->openScheduleDrip($encoded_id);
            } catch(\Exception $e) {
              //echo $e->getMessage();
            }
          }
        } catch(\Exception $e) {}
      }
      return redirect($url);
    }
  }

  /**
   * Update the staus to opened; for a auto follwoup
  */
  public function openAutoFollwoup($id)
  {
    $id = (int) base64_decode($id);
    $last_entry_diff_sec = $this->lastEntryDiffSec('opens', $id);
    // Avoid to duplicat entries within 10 secs
    if($last_entry_diff_sec > 10) {
      // Only Sent should be update to Open
      \App\Models\AutoFollowupStatLog::whereId($id)->whereStatus('Sent')->update(['status' => 'Opened']);

      $ip = Helper::getClientIP();
      // Get geographical detail
      $data = Helper::getGeoInfo($ip);
      $data['auto_followup_stat_log_id'] = $id;
      $data['ip'] = $ip;
      $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      $data['created_at'] = \Carbon\Carbon::now();

      try {
        // Save open data
        \App\Models\AutoFollowupStatLogOpen::create($data);
      }  catch(\Exception $e) {
        //echo $e->getMessage();
      }
    }
  }

  /**
   * Update the staus to clicked; for a auto followup
  */
  public function clickAutoFollowup($id, $url)
  {
    $encoded_id = $id;
    $id = (int) base64_decode($id);
    $url = Helper::base64url_decode($url);
    // For some reason it clicks to
    if($url != 'aHR0cHM' && $url != 'aHR0cDo') {
      $last_entry_diff_sec = $this->lastEntryDiffSec('clicks', $id);
      // Avoid to duplicat entries within 10 secs
      if($last_entry_diff_sec > 10) {
        \App\Models\AutoFollowupStatLog::whereId($id)->update(['status' => 'Clicked']);
        $ip = Helper::getClientIP();
        // Get geographical detail
        $data = Helper::getGeoInfo($ip);
        $data['auto_followup_stat_log_id'] = $id;
        $data['ip'] = $ip;
        $data['link'] = $url;
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['created_at'] = \Carbon\Carbon::now();

        // In case of any error, the redirect must execute
        try {
          \App\Models\AutoFollowupStatLogClick::create($data);

          // if not record in the open for some reason
          if(!\App\Models\AutoFollowupStatLogOpen::whereAutoFollowupStatLogId($id)->exists()) {
            try{
              $this->openAutoFollwoup($encoded_id);
            } catch(\Exception $e) {
              //echo $e->getMessage();
            }
          }
        } catch(\Exception $e) {}
      }
      return redirect($url);
    }
  }

  /**
   * Get last entry time difference
  */
  public function lastEntryDiffSec($table, $id)
  {
    if($table == 'opens') {
      $created_at = \App\Models\ScheduleCampaignStatLogOpen::
        where('schedule_campaign_stat_log_id',$id)
        ->limit(1)
        ->orderBy('id', 'DESC')
        ->value('created_at');
    } elseif($table == 'clicks') {
      $created_at = \App\Models\ScheduleCampaignStatLogClick::
        where('schedule_campaign_stat_log_id',$id)
        ->limit(1)
        ->orderBy('id', 'DESC')
        ->value('created_at');
    }

    if($created_at) {
      return \Carbon\Carbon::parse($created_at)->diffInSeconds(\Carbon\Carbon::now());
    }
    return 50;
  }
}
