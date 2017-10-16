<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('api/user/login',            ['uses' => 'LoginController@login',            'meta' => ['description' => '用户登入']])->name('api.user.login');
Route::post('api/user/logout',           ['uses' => 'LoginController@logout',           'meta' => ['description' => '用户登出']])->name('api.user.logout');

Route::post('api/session/sync',          ['uses' => 'SyncController@sync',              'meta' => ['description' => '信息更新']])->name('api.session.sync');

Route::post('api/auth/roles/paginate',   ['uses' => 'Auth\RolesController@paginate',    'meta' => ['description' => '分页获取角色']])->name('api.auth.roles.paginate');
Route::post('api/auth/roles/all',        ['uses' => 'Auth\RolesController@all',         'meta' => ['description' => '获取全部角色']])->name('api.auth.roles.all');
Route::post('api/auth/roles/example',        ['uses' => 'Auth\RolesController@example',         'meta' => ['description' => '角色几口册饿']])->name('api.auth.roles.example');


Route::post('api/auth/role/menus',       ['uses' => 'Auth\RolesController@menus',       'meta' => ['description' => '获取指定角色的菜单集合']])->name('api.auth.role.menus');
Route::post('api/auth/role/create',      ['uses' => 'Auth\RolesController@create',      'meta' => ['description' => '添加一个新角色']])->name('api.auth.role.create');
Route::post('api/auth/role/delete',      ['uses' => 'Auth\RolesController@delete',      'meta' => ['description' => '删除指定的角色']])->name('api.auth.role.delete');
Route::post('api/auth/role/basic',       ['uses' => 'Auth\RolesController@basic',       'meta' => ['description' => '获取指定角色的基本信息']])->name('api.auth.role.basic');
Route::post('api/auth/role/users',       ['uses' => 'Auth\RolesController@users',       'meta' => ['description' => '获取指定角色的用户集合']])->name('api.auth.role.users');
Route::post('api/auth/role/detachUser',  ['uses' => 'Auth\RolesController@detachUser',  'meta' => ['description' => '将指定用户排除出用户组']])->name('api.auth.role.detachUser');
Route::post('api/auth/role/modifyMenus', ['uses' => 'Auth\RolesController@modifyMenus', 'meta' => ['description' => '更新指定角色的菜单集合']])->name('api.auth.role.modifyMenus');
Route::post('api/auth/role/apis',        ['uses' => 'Auth\RolesController@apis',        'meta' => ['description' => '获取指定角色的接口集合']])->name('api.auth.role.apis');
Route::post('api/auth/role/modifyApis',  ['uses' => 'Auth\RolesController@modifyApis',  'meta' => ['description' => '更新指定角色的接口集合']])->name('api.auth.role.modifyApis');
Route::post('api/auth/role/modifyRoutes',['uses' => 'Auth\RolesController@modifyRoutes','meta' => ['description' => '更新指定角色的路由集合']])->name('api.auth.role.modifyRoutes');

Route::post('api/auth/users/paginate',   ['uses' => 'Auth\UsersController@paginate',    'meta' => ['description' => '分页获取用户']])->name('api.auth.users.paginate');
Route::post('api/auth/user/detachRole',  ['uses' => 'Auth\UsersController@detachRole',  'meta' => ['description' => '用户退出角色']])->name('api.auth.user.detachRole');
Route::post('api/auth/user/delete',      ['uses' => 'Auth\UsersController@delete',      'meta' => ['description' => '删除指定用户']])->name('api.auth.user.delete');
Route::post('api/auth/user/create',      ['uses' => 'Auth\UsersController@create',      'meta' => ['description' => '创建新用户']])->name('api.auth.user.create');
Route::post('api/auth/user/modify',      ['uses' => 'Auth\UsersController@modify',      'meta' => ['description' => '更新用户资料']])->name('api.auth.user.modify');

Route::post('api/auth/menus/save',       ['uses' => 'Auth\MenusController@save',        'meta' => ['description' => '更新系统菜单']])->name('api.auth.menus.save');
Route::post('api/auth/menus/all',        ['uses' => 'Auth\MenusController@all',         'meta' => ['description' => '获取系统菜单']])->name('api.auth.menus.all');
