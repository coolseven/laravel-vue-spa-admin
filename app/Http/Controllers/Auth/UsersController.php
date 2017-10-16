<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 16:16
 */

namespace app\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Auth\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * 分页返回用户列表
     * 返回的用户列表中,每个用户已携带其所属的角色信息
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function paginate()
    {
        $users = AuthUser::with('roles')->paginate();

        return success( $users );
    }

    /**
     * 将指定用户退出某个角色,并返回是否退出成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function detachRole( Request $request )
    {
        $this->validate( $request, [
            'user_id' => 'required', 'role_id' => 'required',
        ] );

        $role_id_to_quit = $request->get( 'role_id' );
        $user_id         = $request->get( 'user_id' );

        $user     = AuthUser::findOrFail($user_id);
        $detached = $user->roles()->detach($role_id_to_quit);

        return success( '已退出该角色', [
            'detached' => $detached,
        ] );
    }

    /**
     * 删除指定的用户,并返回是否删除成功
     * 用户删除时,该用户与角色的关联记录也会一起删除
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function delete( Request $request )
    {
        $this->validate( $request, [ 'id' => 'required'] );

        $user_id = $request->get('id');

        $user    = AuthUser::findOrFail($user_id);

        DB::transaction(function() use($user){
            // 删除该用户与角色的关联记录
            $user->roles()->detach();

            // 删除用户记录
            $user->delete();
        });

        return success( '已删除该用户', [
            'deleted' => true,
        ] );
    }

    /**
     * 创建一个新用户,并返回是否创建成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function create( Request $request )
    {
        $this->validate( $request,
            [ 'username' => 'required', 'password' => 'required' , 'role_ids' => 'required']
        );

        DB::transaction(function() use($request){
            $user = new AuthUser();
            $user->username = $request->get('username');
            $user->password = password_hash($request->get('password') , PASSWORD_BCRYPT);
            $user->save();

            $user_role_ids = $request->get('role_ids');
            $user->roles()->attach($user_role_ids);
        });

        return success( '用户添加成功', [
            'created'   => true,
        ]);
    }

    /**
     * 修改用户信息,包括用户名和用户所属的用户组,并返回是否修改成功
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function modify( Request $request )
    {
        $this->validate( $request,
            [ 'id' => 'required', 'username' => 'required',  'role_ids' => 'required']
        );

        $id   = $request->get('id');
        $user = AuthUser::findOrFail($id);

        DB::transaction(function() use($user,$request){
            $user->username = $request->get('username');
            $user->save();

            $user_role_ids = $request->get('role_ids');
            $user->roles()->sync($user_role_ids);
        });

        return success( '用户编辑成功',[
            'saved' => true,
        ]);
    }
}