<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 16:16
 */

namespace app\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Auth\AuthRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * 分页返回角色集合
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function paginate()
    {
        $roles =  AuthRole::paginate();

        return success($roles);
    }

    /**
     * 返回全部的角色集合
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $roles =  AuthRole::all();

        return success($roles);
    }

    /**
     * 创建一个新角色,并返回是否创建成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|max:15|unique:auth_roles',
            'description' => 'max:50',
        ]);

        $role = new AuthRole();
        $role->name = $request->get('name');
        $role->description = $request->get('description');
        $role->apis = '';
        $role->saveOrFail();

        return success( '角色添加成功', $role );
    }

    /**
     * 根据角色 id 删除指定的角色,并返回是否删除成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $this->validate($request, ['id'  => 'required']);

        $role_id = $request->get('id');

        $role = AuthRole::findOrFail($role_id);

        DB::transaction(function() use($role){
            // 删除角色与其用户之间的关联关系
            $role->users()->detach();

            // 删除角色
            $role->delete();
        });

        // TODO add logs to database

        return success( '角色已删除', $role );
    }

    /**
     * 根据角色 id ，查询并返回该角色的基础信息 (包含 角色名称,角色描述,角色的创建时间 )
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function basic(Request $request)
    {
        $this->validate($request, ['id'  => 'required']);

        $role = AuthRole::findOrFail($request->get('id') , ['name', 'description', 'created_at']);

        return success( '请求成功', $role );
    }

    /**
     * 返回指定角色的用户集合
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function users(Request $request)
    {
        $this->validate($request, ['id'  => 'required']);

        $role_id = $request->get('id');

        $role_users = AuthRole::findOrFail($role_id)->users()->get();

        return success( '请求成功', $role_users );
    }

    /**
     * 将指定用户从指定角色中排除
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function detachUser(Request $request)
    {
        $this->validate($request, [
            'role_id'  => 'required', 'user_id' => 'required'
        ]);

        $role_id = $request->get('role_id');
        $user_id = $request->get('user_id');

        AuthRole::findOrFail($role_id)->users()->detach($user_id);

        return success( '已将用户移出当前组' ,[
            'detached'  => true,
        ]);
    }

    /**
     * 返回指定角色的菜单树(结构为嵌套的菜单树)
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function menus(Request $request)
    {
        $role_id = $request->get('id');

        $role   = AuthRole::findOrFail($role_id);
        $menus  = json_decode( $role->menus );

        return success($menus);
    }

    /**
     * 修改指定角色的菜单树,并返回是否修改成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function modifyMenus(Request $request)
    {
        $menus      = $request->get('menus');
        $role_id    = $request->get('id');

        $role = AuthRole::findOrFail($role_id);
        $role->menus = json_encode($menus,JSON_UNESCAPED_UNICODE);
        $role->saveOrFail();

        return success('角色的左侧菜单已更新',[
           'saved'  => true,
        ]);
    }

    /**
     * 返回指定角色的 api 集合
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function apis(Request $request)
    {
        $role_id = $request->get('id');

        $role = AuthRole::findOrFail($role_id);
        $apis = json_decode($role->apis);

        return success($apis);
    }

    /**
     * 修改指定角色的 api 集合,并返回是否修改成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function modifyApis(Request $request)
    {
        $apis    = $request->get('apis');
        $role_id = $request->get('id');

        $role = AuthRole::findOrFail($role_id);
        $role->apis = json_encode($apis,JSON_UNESCAPED_UNICODE);
        $role->saveOrFail();

        return success('角色的接口权限已更新', [
            'saved' => true,
        ]);
    }


    /**
     * 修改指定角色的路由权限集合,并返回是否修改成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function modifyRoutes(Request $request)
    {
        $routes     = $request->get('routes');
        $role_id    = $request->get('id');

        $role = AuthRole::findOrFail($role_id);
        $role->routes = json_encode($routes,JSON_UNESCAPED_UNICODE);
        $role->saveOrFail();

        return success('角色的路由权限已更新',[
            'saved'  => true,
        ]);
    }

}