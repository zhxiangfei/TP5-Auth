ThinkPHP5 实现权限管理
===============
#### 一、系统说明 ####
本系统采用thinkphp5实现权限管理，每个角色组的用户根据不同账号，显示/隐藏对应的功能权限。

用户除了默认有该角色组的权限外，还可以在原有的基础上自定义分配权限。

其中：左侧菜单根据是否是菜单项（填写系统权限时系统菜单选项）来决定是否显示在左侧菜单，如果层级是模块，并且是系统菜单，则会显示在左侧一级菜单，如果层级是操作，并且是系统菜单，那该菜单也会显示在左侧菜单，只不过是在二级菜单，可以使用此方法来设置左侧二级菜单。

操作按钮是使用公共方法(common.php)里封装好的，传入相应的参数，就会输出操作按钮组，然后随着数据一块输出到前端页面；单个按钮功能，比如更新状态、添加、批量删除则是使用单独封装好的方法（authCheck），直接在前端判断使用即可。

如果是超级管理员则不验证权限，默认全部显示，如果不是超级管理员，则根据系统分配的权限显示不同的功能权限。

#### 二、数据库 ####
hospit_auth表 权限表 用来存储所有的权限

<table>
<tr>
<td>id</td>
<td>id</td>
</tr>
<tr>
<td>title</td>
<td>菜单标题</td>
</tr>
<tr>
<td>url</td>
<td>链接地址(模块/控制器/方法)</td>
</tr>
<tr>
<td>is_menu</td>
<td>是否是菜单项 1不是 2是</td>
</tr>
<tr>
<td>menu_icon</td>
<td>顶级节点图标(fontawesome图标)</td>
</tr>
<tr>
<td>pid</td>
<td>上级菜单id</td>
</tr>
<tr>
<td>level</td>
<td>层级 1项目 2模块 3操作</td>
</tr>
<tr>
<td>sort</td>
<td>排序</td>
</tr>
<tr>
<td>status</td>
<td>状态 0启用，1禁用</td>
</tr>
<tr>
<td>create_time</td>
<td>创建时间</td>
</tr>
</table>

hospit_role表 系统角色表 用来存储所有的角色 hospitauth_id字段对应hospit_auth表中的id

<table>
<tr>
<td>id</td>
<td>id</td>
</tr>
<tr>
<td>role_name</td>
<td>菜单标题</td>
</tr>
<tr>
<td>pid</td>
<td>上级菜单id</td>
</tr>
<tr>
<td>hospitauth_id</td>
<td>权限id</td>
</tr>
<tr>
<td>level</td>
<td>等级</td>
</tr>
<tr>
<td>sort</td>
<td>排序</td>
</tr>
<tr>
<td>status</td>
<td>状态 0正常 1禁用</td>
</tr>
<tr>
<td>remark</td>
<td>备注</td>
</tr>
<tr>
<td>create_time</td>
<td>创建时间</td>
</tr>
</table>

hospit_role表 系统角色表 用来存储所有的角色 hospitauth_id字段对应hospit_auth表中的id,hospitrole_id字段对应hospit_role表中的id

<table>
<tr>
<td>id</td>
<td>id</td>
</tr>
<tr>
<td>username</td>
<td>用户名</td>
</tr>
<tr>
<td>password</td>
<td>密码</td>
</tr>
<tr>
<td>name</td>
<td>姓名</td>
</tr>
<tr>
<td>hospitrole_id</td>
<td>角色id</td>
</tr>
<tr>
<td>hospitauth_id</td>
<td>权限id</td>
</tr>
<tr>
<td>status</td>
<td>状态 0已通过 1待审核</td>
</tr>
<tr>
<td>is_admin</td>
<td>是否是超级管理员 1是 0不是</td>
</tr>
<tr>
<td>create_time</td>
<td>创建时间</td>
</tr>
</table>