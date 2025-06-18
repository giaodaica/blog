<?php

namespace App\Http\Controllers\Spatie;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $user;
    protected $page_breadcrumbs;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            return $next($request);
        });
        $this->middleware('role:admin');
    }
    public function index(Request $request)
    {
        $data = Role::orderBy('order', 'asc')->get();
        $datatable = $this->getHTMLCategory($data);
        return view('dashboard.pages.role.index')
            ->with('datatable', $datatable);
    }


    /**
     * Show the form for creating a new newscategory
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $dataCategory = Role::orderBy('order', 'asc')->get();
        $permissions = Permission::orderBy('order', 'asc')->get();
        $array = array();
        foreach ($permissions as $permission) {
            if ($permission->parent_id == 0 || $permission->parent_id . "" == "") {
                $permission->parent_id = "#";
            }
            $array[] = [
                "id" => $permission->id . "",
                "parent" => $permission->parent_id . "",
                "text" => htmlentities($permission->title) . "",
                "state" => [
                    'opened' => true
                ],
            ];
        }
        $permissionsJson = json_encode($array);

        return view('dashboard.pages.role.create_edit', compact('dataCategory', 'permissionsJson'));
    }

    /**
     * Store a newly created newscategory in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:roles',
            'name' => 'required|unique:roles',
        ], [
            'title.required' => __('Vui lòng nhật tiêu đề'),
            'title.unique' => __('Vui lòng nhâp từ khóa name'),
            'name.unique' => __('Keyword đã tồn tại'),
            'name.required' => __('Vui lòng nhập keyword'),
        ]);
        $input = $request->all();
        $data = Role::create($input);
        $data->permissions()->sync(isset($request->permission_ids) ? explode(",", $request->permission_ids) : []);
        if ($request->filled('permission_ids')) {
            $permission = Permission::whereIn('id', explode(",", $request->get('permission_ids')))->get();
            $message = '';
            $message = "Thời gian: <b>" . Carbon::now()->format('d-m-Y H:i:s') . "</b>";
            $message .= "\n";
            $message .= "<b>" . auth()->user()->username . "</b> thay đổi thông tin quyền của nhóm vai trò <b>" . $data->title . "</b> :";
            $message .= "\n";
            $message .= "\n";
            foreach ($permission as $key => $item) {
                $message .= '- ' . $item->title;
                $message .= "\n";
            }
        }
        return redirect()->route('dashboard.roles.index')
            ->with('success', __('Thêm mới thành công !'));
    }

    /**
     * Display the specified newscategory.
     *
     * @param  int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        //$data = Role::findOrFail($id);
        //ActivityLog::add($request, 'Show role #'.$data->id);
        //return view('admin.role.show', compact('item'));
    }

    /**
     * Show the form for editing the specified newscategory.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $data = Role::findOrFail($id);

        $dataCategory = Role::where('id', '!=', $id)->orderBy('order', 'asc')->get();
        $permissions = Permission::orderBy('order', 'asc')->get();
        $permissionsSelected = $data->permissions()->pluck('id')->toArray();
        $array = array();
        foreach ($permissions as $permission) {
            if ($permission->parent_id == 0 || $permission->parent_id . "" == "") {
                $permission->parent_id = "#";
            }
            $array[] = [
                "id" => $permission->id . "",
                "parent" => $permission->parent_id . "",
                "text" => htmlentities($permission->title) . "",
                "state" => [
                    'opened' => true
                ],
            ];
        }
        $permissionsJson = json_encode($array);
        return view('dashboard.pages.role.create_edit', compact('data', 'dataCategory', 'permissionsJson', 'permissionsSelected'));
    }

    /**
     * Update the specified newscategory in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = Role::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|unique:roles,title,' . $id,
            'name' => 'required|unique:roles,name,' . $id,
        ], [
            'title.required' => __('Vui lòng nhật tiêu đề'),
            'title.unique' => __('Vui lòng nhâp từ khóa name'),
            'name.unique' => __('Keyword đã tồn tại'),
            'name.required' => __('Vui lòng nhập keyword'),
        ]);

        $input = $request->all();
        $data->update($input);
        $data->permissions()->sync(isset($request->permission_ids) ? explode(",", $request->permission_ids) : []);
        if ($request->filled('permission_ids')) {
            $permission = Permission::whereIn('id', explode(",", $request->get('permission_ids')))->get();
            $message = '';
            $message = "Thời gian: <b>" . Carbon::now()->format('d-m-Y H:i:s') . "</b>";
            $message .= "\n";
            $message .= "<b>" . auth()->user()->username . "</b> thay đổi thông tin quyền của nhóm vai trò <b>" . $data->title . "</b> :";
            $message .= "\n";
            $message .= "\n";
            foreach ($permission as $key => $item) {
                $message .= '- ' . $item->title;
                $message .= "\n";
            }
        }
        return redirect()->route('dashboard.roles.index')->with('success', __('Cập nhật vai trò thành công ' . '[' . $data->title . ']'));
    }

    /**
     * Remove the specified newscategory from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $input = explode(',', $request->id);
        Role::destroy($input);
        return redirect()->route('dashboard.roles.index')->with('success', __('Xóa thành công !'));
    }


    // AJAX Reordering function
    public function order(Request $request)
    {
        $source = e($request->get('source'));
        $destination = $request->get('destination');
        $item = Role::find($source);
        $item->parent_id = isset($destination) ? $destination : 0;
        $item->save();
        $ordering = json_decode($request->get('order'));
        $rootOrdering = json_decode($request->get('rootOrder'));
        if ($ordering) {
            foreach ($ordering as $order => $item_id) {
                if ($itemToOrder = Role::find($item_id)) {
                    $itemToOrder->order = $order;
                    $itemToOrder->save();
                }
            }
        } else {
            foreach ($rootOrdering as $order => $item_id) {
                if ($itemToOrder = Role::find($item_id)) {
                    $itemToOrder->order = $order;
                    $itemToOrder->save();
                }
            }
        }
        return 'ok ';
    }
    // Getter for the HTML menu builder
    function getHTMLCategory($menu)
    {
        return $this->buildMenu($menu);
    }
    function buildMenu($menu, $parent_id = 0)
    {
        $result = null;
        foreach ($menu as $item)
            if ($item->parent_id == $parent_id) {
                $result .= "<li class='dd-item nested-list-item' data-order='{$item->order}' data-id='{$item->id}'>
          <div class='dd-handle nested-list-handle'>
            <span class='la la-arrows-alt'></span>
          </div>
          <div class='nested-list-content' >";
                if ($parent_id != 0) {
                    $result .= "<div class=\"m-checkbox\">
                                <label class=\"checkbox checkbox-outline\">
                                <input  type=\"checkbox\" rel=\"{$item->id}\" class=\"children_of_{$item->parent_id}\"  >
                                <span></span> " . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') . "
                                </label>
                            </div>";
                } else {
                    $result .= "<div class=\"m-checkbox\">
                                <label class=\"checkbox checkbox-outline\">
                                <input  type=\"checkbox\" rel=\"{$item->id}\" class=\"children_of_{$item->parent_id}\"  >
                                <span></span> " . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') . "
                                </label>
                            </div>";
                }
                $description = "Đang cập nhật...";
                if ($item->description) {
                    $description = $item->description;
                }
                $result .= "<div class='btnControll'>";
                $result .= " <button tabindex=\"0\" class='btn btn-sm btn-info btn-show' data-toggle=\"popover\" data-trigger=\"click\" title=\"Mô tả nhóm quyền: $item->title\" data-content=\"$description\">Mô tả</button>
            <a href='#' class='btn btn-sm btn-primary edit_toggle' data-url='" . route("dashboard.roles.edit", $item->id) . "' rel='{$item->id}' >Sửa</a>
                <a href=\"#\" class=\"btn btn-sm btn-danger  delete_toggle \" rel=\"{$item->id}\">
                                    Xóa
                </a>
            </div>
          </div>" . $this->buildMenu($menu, $item->id) . "</li>";
            }
        return $result ? "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
    }
}
