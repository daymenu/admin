### 角色

### 列表

**请求URL：** 
- `/api/admin/role/`
  
**请求方式：**
- GET 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|page |否  |INT |页数   |
|limit |否  |INT |每页显示多少条    |
|search     |否  |string | 搜索内容 |

 **返回示例**

``` 
{
    "code": 200,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 6,
                "name": "管理员",
                "created_at": "2018-12-15 14:10:15",
                "updated_at": "2018-12-15 14:10:15",
                "deleted_at": null,
            }
        ],
        "first_page_url": "http://admin.daymenu.cn/api/admin/menu?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://admin.daymenu.cn/api/admin/menu?page=1",
        "next_page_url": null,
        "path": "http://admin.daymenu.cn/api/admin/menu",
        "per_page": "10",
        "prev_page_url": null,
        "to": 6,
        "total": 6
    },
    "message": ""
}
```

 **返回参数说明** 
- code 表示状态 为200时表示成功
- message 为提示信息
- data 为主体数据，下面表格解释data中的数据

|参数名|类型|说明|
|:-----  |:-----|-----|
|current_page |int   |当前页数  |
|last_page |int   |最后一页页数  |
|total |int   |一共有多少条  |
|id |int   |角色ID  |
|name |string   |角色名称  |
|created_at |string   |创建时间  |
|updated_at |int   |最后一次更新时间  |

### 显示某条资源

**请求URL：** 
- `/api/admin/role/:id`
>:id 为要查看的资源ID 

**请求方式：**
- GET 

**参数：** 
无

 **返回示例**

``` 
{
    "code": 200,
    "data": {
        "id": 2,
        "name": "管理员",
        "created_at": "2018-12-15 04:56:05",
        "updated_at": "2018-12-15 05:12:33",
        "deleted_at": null
    },
    "message": ""
}
```

 **返回参数说明** 
- code 表示状态 为200时表示成功
- message 为提示信息
- data 为主体数据，下面表格解释data中的数据

|参数名|类型|说明|
|:-----  |:-----|-----|
|id |int   |角色ID  |
|name |string   |角色名称  |
|created_at |string   |创建时间  |
|updated_at |int   |最后一次更新时间  |


### 添加

**请求URL：** 
- `/api/admin/role/`
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|name |是  |STRING |角色名称   |
|menus |否  |array |所选菜单ID|

 **返回示例**

 
### 修改

**请求URL：** 
- `/api/admin/role/:id`
  
**请求方式：**
- PUT 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|name |是  |STRING |角色名称   |
|menus |否  |array |所选菜单ID|

 **返回示例**
 - code等于200 添加成功

### 删除

**请求URL：** 
- `/api/admin/role/:id`
  
**请求方式：**
- DELETE 

**参数：** 
无

 **返回示例**
 - code等于200 添加成功

### 获取菜单树
见auth/menu.md
见vue api/menu.js