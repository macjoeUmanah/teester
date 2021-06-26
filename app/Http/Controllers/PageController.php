<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Auth;
use Helper;

class PageController extends Controller
{
  /**
   * Retrun index view
  */
  public function index()
  {
    Helper::checkPermissions('pages'); // check user permission
    $page = 'layouts_pages'; // choose sidebar menu option
    return view('pages.index')->with(compact('page'));
  }

  /**
   * Retrun JSON datatable data
  */
  public function getPages(Request $request)
  {
    $result = Page::select('id', 'name', 'type', 'slug', 'email_subject')
      ->whereAppId(Auth::user()->app_id);

    $columns = ['id', 'name', 'type', 'email_subject'];

    $data = Helper::dataFilters($request, $result, $columns);

    $result = $data['result'];
    $pages = $result->get();

    $data =  Helper::datatableTotals($data['total']);

    foreach($pages as $page) {
      $actions = '<div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'.__('app.actions').' <span class="caret"></span></button><ul class="dropdown-menu" role="menu">';
      $actions .= '<li><a href="'.route('page.edit', ['id' => $page->id]).'"><i class="fa fa-edit"></i>'.__('app.edit').'</a></li>';
      // Only delete user created pages/emails
      if($page->type  == 'Email' && $page->id > 10)
      $actions .= '<li><a class="text-red" href="javascript:;" onclick="destroy(\''.$page->id.'\', \''.route('page.destroy', ['id' => $page->id]).'\')"><i class="fa fa-trash"></i>'.__('app.delete').'</a></li>';
      $actions .= '</ul></div>';
      $page_name = '<a href="'.route('page.html', [$page->slug]).'" target="_blank">'.$page->name.'</a></li>';
      $data['data'][] = [
        $page_name,
        $page->type,
        $page->email_subject ?? '---',
        $actions
      ];
    }
    echo json_encode($data);
  }

  /**
   * Retrun create view
  */
  public function create()
  {
    Helper::checkPermissions('pages'); // check user permission
    $page = 'layouts_pages'; // choose sidebar menu option
    return view('pages.create')->with(compact('page'));
  }

  /**
   * Save page data
  */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'email_subject' => 'required',
    ]);
    $data = $request->except('_token');
    $sanitizer = new \Phlib\XssSanitizer\Sanitizer();
    $data['content_html'] = $sanitizer->sanitize($data['content_html']);
    $data['type'] = 'Email';
    $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
    $data['app_id'] = Auth::user()->app_id;
    $list = Page::create($data);
    activity('create')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.page') . " ({$data['name']}) ". __('app.log_update')); // log
  }

  /**
   * Retrun edit view
  */
  public function edit($id)
  {
    Helper::checkPermissions('pages'); // check user permission
    $page = 'layouts_pages'; // choose sidebar menu option
    $page_email = Page::whereId($id)->app()->first();
    return view('pages.edit')->with(compact('page', 'page_email'));
  }

  /**
   * Update data
  */
  public function update(Request $request, $id)
  {
    $request->validate([
      'email_subject' => 'required',
    ]);
    $page = Page::findOrFail($id);
    $data = $request->except('_token');
    $sanitizer = new \Phlib\XssSanitizer\Sanitizer();
    $data['content_html'] = $sanitizer->sanitize($data['content_html']);
    $page->fill($data)->save();
    activity('update')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.page') . " ({$request->p}) ". __('app.log_update')); // log
  }

  /**
   * Delete one or more
  */
  public function destroy($id, Request $request)
  {
    $page = Page::whereId($id)->value('name');
    $destroy = Page::destroy($id);
    activity('delete')->withProperties(['app_id' => Auth::user()->app_id])->log(__('app.page') . " ({$page}) ". __('app.log_delete')); // log
    return $destroy;
  }

  /**
   * View page respectively 
  */
  public function showPage($slug, $contact_id=null)
  {
    // If call from receipent side
    if(!empty($contact_id)) {
      $contact = \App\Models\Contact::findOrFail(base64_decode($contact_id));
      $page = \App\Models\Page::whereSlug($slug)->whereAppId($contact->app_id)->first();

      $data = Helper::replaceSpintags($page->content_html); // replace spintags
      $data = Helper::replaceCustomFields($data, $contact->customFields); // replace custom field
      $data = Helper::replaceSystemVariables($contact, $data, $data_values=[]);
    } else {
      // else call from admin side to show page html
      $data = \App\Models\Page::whereSlug($slug)->whereAppId(Auth::user()->app_id)->value('content_html');
      $data = Helper::XSSReplaceTags(Helper::decodeString($data));
    }

    return view('includes.blank')->with('data', $data);
  }
}
