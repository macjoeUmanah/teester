<select name="schedule_campaign_stat_ids[]" id="boradcasts" class="form-control multi" multiple="multiple">
  @foreach(\App\Models\ScheduleCampaignStat::getScheduledCampaigns() as $schedule_stat)
    <option value="{{ $schedule_stat->id }}" {{ !empty($schedule_campaign_stat_ids) && in_array($schedule_stat->id, $schedule_campaign_stat_ids) ? 'selected="selected"' : '' }}>{{ Helper::decodeString($schedule_stat->schedule_campaign_name)  }}</option>
  @endforeach
</select>