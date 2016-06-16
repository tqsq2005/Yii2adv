Yii 2 项目阶段性小结
=============
### 2016.6.14小结： 修复 [datatable](https://www.datatables.net/) 中导出 [PDF](http://pdfmake.org/#/gettingstarted) 中文不支持的问题
**解决步骤记录如下**

1. 下载 中文字体 [vfs_fonts.js](http://7xoed1.com1.z0.glb.clouddn.com/2015/vfs_fonts.js)

2. 修改 `DataTableAsset.php` 文件，将 `vfs_fonts.js` 文件加入 `js` 包中
```php
    public $js = [
        'datatables.min.js',
        'pdfmake-0.1.18/build/vfs_fonts.js'//加入中文ttf
    ];
```
3. js开头文件注册 该中文字体
```javascript
    window.pdfMake.fonts  = {
        msyh: {
            normal: 'msyh.ttf',
            bold: 'msyh.ttf',
            italics: 'msyh.ttf',
            bolditalics: 'msyh.ttf',
        }
    };
```
4. `datatable` 的 `buttons` 中 `pdf` 的代码改为：
```javascript
    {
        extend: 'pdf',
        text: '全部导出PDF',
        pageSize: 'A3',//default:LEGAL
        exportOptions: {
            columns: ':visible'//掩藏列不导出
        },
        customize: function ( doc ) {
            doc.defaultStyle = {
                font: 'msyh'
            };
        }
    },
```

*参考资料*

- [DataTables导出CSV、PDF中文乱码解决方法](http://www.yuyanping.com/datatables-export-csv-pdf-be-garbled/)  
- [Changing your DataTable/PDFMake Font in PDF for right to left alignment](http://www.rudeprogrammer.com/2016/01/changing-your-datatablepdfmake-font-in-pdf-print-button-for-right-to-left/)
- [markPDF官网](http://pdfmake.org/#/gettingstarted)
- [PDF - page size and orientation](https://datatables.net/extensions/buttons/examples/html5/pdfPage.html)
- [pdfHtml5](https://datatables.net/reference/button/pdfHtml5)


### 6.15小结：
#### 1、修改了datatable插件editor的样式，修改弹出层宽度及每行改为两列,修改代码
```php
    $css = <<<CSS
    div.modal-dialog {
        width: 800px;
    }
    
    div.DTE_Body div.DTE_Body_Content div.DTE_Field {
        float: left;
        width: 50%;
        padding: 5px 10px;
        clear: none;
        box-sizing: border-box;
    }
    
    div.DTE_Body div.DTE_Form_Content:after {
        content: ' ';
        display: block;
        clear: both;
    }
    CSS;
    $this->registerCss($css);
```
*参考资料*

- [Large window layout](https://editor.datatables.net/examples/styling/large.html)
- [Multi-column layout](https://editor.datatables.net/examples/styling/columns.html)

#### 2、ajax加载数据的时候通过在`beforeSend`中加入[layer.load()](http://layer.layui.com/api.html#layer.load)增加页面加载gif，在ajax中添加如下代码： 
```javascript
    beforeSend: function () {
        layer.load();
    },
    complete: function () {
        layer.closeAll('loading');
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
        layer.alert('数据加载出错:' + textStatus + ' ' + errorThrown, {icon: 5});
    }
```

#### 3、重新加载jstree: `$('#unit-tree').jstree('refresh')`
```javascript
    //点击更新单位列表
    $(document).on('click', '#unit-refresh', function() {
        var shiftNum = [0, 1, 2, 3, 4, 5, 6];
        layer.confirm('<span class="text-info">即将刷新单位列表，确定吗?</span>', {
            title: '系统信息',
            shift: shiftNum[Math.floor(Math.random()*shiftNum.length)],
            icon: 6,
            scrollbar: false
        }, function(index) {
            $('#unit-tree').jstree('refresh');
            layer.close(index);
        }, function(index) {
            layer.close(index);
        });
    });
```
*参考资料*

- [how-can-i-refresh-the-contents-of-a-jstree](http://stackoverflow.com/questions/3682045/how-can-i-refresh-the-contents-of-a-jstree)
- [jstree API](https://www.jstree.com/api/#/)

### 6.16小结
#### 1、部分表新增如下四个字段，配合`yii\behaviors\TimestampBehavior` 及 `yii\behaviors\BlameableBehavior`方便`log`记录
```SQL
    ALTER TABLE personal 
        ADD `created_by` int(11) NOT NULL,
    	ADD `updated_by` int(11) NOT NULL,
        ADD `created_at` int(11) NOT NULL,
        ADD `updated_at` int(11) NOT NULL;
```

#### 2、新增函数`getChildList`,给定`unitcode`获取所有下属单位(包含自身)信息，并结合函数`FIND_IN_SET()`进行调用
```SQL
    DELIMITER $$  
      
    DROP FUNCTION IF EXISTS `populac_adv`.``$$  
      
    CREATE DEFINER=`root`@`localhost` FUNCTION `getChildList`(s_unitcode varchar(30)) /*创建一个函数 getChildList(s_unitcode varchar(30)) 参数为int型*/
    RETURNS varchar(1000) CHARSET utf8  /*定义返回值类型  varchar(1000), CHARSET: utf-8*/
    BEGIN  
           DECLARE sTemp VARCHAR(1000);  
           DECLARE sTempChd VARCHAR(1000);  
          
           SET sTemp 		= '$';  
           SET sTempChd =s_unitcode;  
          
           WHILE sTempChd is not null DO  /*循环体*/
             SET sTemp = concat(sTemp,',',sTempChd);  /*拼接sTemp*/
             SELECT group_concat(unitcode) INTO sTempChd FROM unit where upunitcode<>unitcode and FIND_IN_SET(upunitcode,sTempChd) > 0;  /*根据父节点，查询出该父节点下的所有子节点的id，支持多级查询*/
           END WHILE;  
           RETURN sTemp;  
         END$$  
      
    DELIMITER ;
```
SQL调用语句：`select * from unit where FIND_IN_SET(unitcode, getChildList('0000230400'));`结果包含`000023040001`

#### 3、新增函数`getParentList`,给定`unitcode`获取所有主管单位(不包含自身)信息，并结合函数`FIND_IN_SET()`进行调用
```SQL
    DELIMITER $$  
      
    DROP FUNCTION IF EXISTS `populac_adv`.`getParentList`$$  
      
    CREATE DEFINER=`root`@`localhost` FUNCTION `getParentList`(s_unitcode varchar(50)) RETURNS varchar(1000) CHARSET utf8  
    BEGIN  
           DECLARE sTemp VARCHAR(1000);  
           DECLARE sTempPar VARCHAR(1000);  
          
           SET sTemp = '$';  
           SET sTempPar =s_unitcode;  
          
           WHILE sTempPar is not null DO
             IF (sTempPar <> s_unitcode) THEN /*不包含自身*/
                SET sTemp = concat(sTemp,',',sTempPar); 
             END IF;
           SELECT group_concat(upunitcode) INTO sTempPar FROM unit where upunitcode<>unitcode and FIND_IN_SET(unitcode,sTempPar) > 0;  
           END WHILE;  
           RETURN sTemp;  
         END$$  
      
    DELIMITER ; 
```
SQL调用语句：`select * from unit where FIND_IN_SET(unitcode, getParentList('000023040001'));` 结果不包含`000023040001`