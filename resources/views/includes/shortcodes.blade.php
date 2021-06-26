<div style="padding-top: 5px;">
  {!! \Helper::dropdownCustom(__('app.system_variables'), \Helper::systemVariables(), 'systemVariables') !!}
</div>
<div style="padding-top: 5px;">
  {!! \Helper::dropdownCustom(__('app.custom_fields'), \App\Models\CustomField::pluck('name', 'tag'), 'customFields') 
!!}
</div>
<div style="padding-top: 5px;">
  {!! \Helper::dropdownCustom(__('app.automation_spintags'), \App\Models\Spintag::pluck('name', 'tag'), 'spinTags') 
!!}
</div>