Yii 2 项目阶段性小结
=============
### 2016.6.14小结： 修复 [datatable](https://www.datatables.net/) 中导出 [PDF](http://pdfmake.org/#/gettingstarted) 中文不支持的问题
**解决步骤记录如下**

1.下载 中文字体 [vfs_fonts.js](http://7xoed1.com1.z0.glb.clouddn.com/2015/vfs_fonts.js)

2.修改 `DataTableAsset.php` 文件，将 `vfs_fonts.js` 文件加入 `js` 包中
```php
    public $js = [
        'datatables.min.js',
        'pdfmake-0.1.18/build/vfs_fonts.js'//加入中文ttf
    ];
```
3.js开头文件注册 该中文字体
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
4.`datatable` 的 `buttons` 中 `pdf` 的代码改为：
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
