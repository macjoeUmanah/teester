<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trigger;
use App\Models\ScheduleDripStat;
use Helper;
use Auth;

class TriggerStatController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('stats_triggers'); // check user permission
    $page = 'stats_triggers'; // choose sidebar menu option
    $title = __('app.stats').' - '.__('app.triggers');
    return view('stats.triggers.index')->with(compact('page', 'title'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getTriggers(Request $request) {
    $result = Trigger::withTrashed()
      ->whereAppId(Auth::user()->app_id)
      ->with('autoFollowupStat')
      ->with('scheduleDrip');

    $columns = ['name', 'based_on', 'action', 'schedule_by', 'created_at', 'id'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $stats = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($stats as $stat) {
      if($stat->action == 'start_drip') {
        if(empty($schedule_drip_stat->id)) continue;

        $schedule_drip_stat = ScheduleDripStat::whereScheduleDripId($stat->scheduleDrip->id)->first();
        $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.drip', [$schedule_drip_stat->id, 'summary', 'stats.drips.summary_popup']).'\')">'.$stat->name.'</a>';
        $detail = '<a href="'.route('detail.stat.drip', ['id' => $schedule_drip_stat->id]).'"><i class="fa fa-bar-chart"></i></a>';
        $schedule_by = $schedule_drip_stat->schedule_by;
      } else {
        if(empty($stat->autoFollowupStat->id)) continue;

        $name = '<a href="javascript:;" onclick="viewModal(\'modal\', \''.route('detail.stat.auto_followup', [$stat->autoFollowupStat->id, 'summary', 'stats.auto_followups.summary_popup']).'\')">'.$stat->name.'</a>';
        $detail = '<a href="'.route('detail.stat.auto_followup', ['id' => $stat->autoFollowupStat->id]).'"><i class="fa fa-bar-chart"></i></a>';
        $schedule_by = $stat->autoFollowupStat->schedule_by;
      }
      $data['data'][] = [
        "DT_RowId" => "row_{$stat->id}",
        $name,
        ucfirst($stat->based_on),
        ucwords(str_replace('_', ' ', $stat->action)),
        $schedule_by,
        Helper::datetimeDisplay($stat->created_at),
        $detail
      ];
    }
    echo json_encode($data);
  }
}
