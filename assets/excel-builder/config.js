/**
 * Created by pmint on 8/9/14.
 */

ExtFunctions = {
    getPointerEvent: function(e){
        try{
            return e.targetTouches[0];
        } catch(error){
            return e;
        }
    },
    selfRemove: function(element){
        return element.parentElement.removeChild(element);
    },
    removeAllChildren: function(element){
        while(element.children.length > 0){
            this.selfRemove(element.children[0]);
        }
    },
    css: function(element, cssname, value, isCss3){
        var _self = this;
        var browserPrefix = ['','-webkit-','-moz-','-o-','-ms-'];
        var tmp;
        for(var i=0; i<browserPrefix.length; i++){
            if(isCss3) tmp = browserPrefix[i]+cssname;
            else tmp = cssname;
            element.style.setProperty(tmp,value);
        }
    },
    getTransition: function(element){
        var transition = eval(window.getComputedStyle(element).transitionDuration.split("s")[0])*1000;
        var browserPrefix = ['webkit', 'moz', 'ms', 'o', ''];
        var animationT = 0;
        for(var i=0; i< browserPrefix.length; i++){
            if(typeof(window.getComputedStyle(element)[browserPrefix[i]+'AnimationDuration']) != "undefined"){
                animationT = window.getComputedStyle(element).webkitAnimationDuration.split("s")[0]*1000;
            }
        }
        return {
            'transition': transition,
            'animation': animationT
        };
    },
    animateOnce: function(element, classname){
        element.classList.remove(""+classname+"");
        element.classList.add(""+classname+"");
        var t = setTimeout(function(){
            element.classList.remove(""+classname+"");
            clearTimeout(t);
        }, this.getTransition(element)['animation']);
    },
    popup: {
        e: function(){

        },
        i: function(){

        }
    },
    locdau: function(str){
        if(!str) return false;
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"_");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str= str.replace(/_+_/g,"_"); //thay thế 2- thành 1-
        str = str.replace(/^\_+|\_+$/g, "");
        //cắt bỏ ký tự - ở đầu và cuối chuỗi
        return str;
    },
    stripTags: function(str){
        return str.replace(/(<([^>]+)>)/ig,"");
    },
    round: function(number, d){
        return Math.round(number*Math.pow(10, d))/Math.pow(10, d);
    },
    getNumbers: function(s){
        if(!s) return false;
        var ret = s.match(/\d+/g);
        for(var i=0; i<ret.length; i++ ){
            ret[i] = Number(ret[i]);
        }
        return ret;
    }
};

var EBbase = _HOST+"/assets/excel-builder";
$("head").append('<script type="text/javascript" src="' + EBbase + '/require.min.js"></script>');
require.config({
    baseUrl: EBbase,
    paths: {
        JSZip: 'jszip'
    },
    shim: {
        'JSZip': {
            exports: 'JSZip'
        }
    }
});

function EBExport(config){
    if(typeof(config.data) == "function") config.data = config.data();
    if(typeof(config.columns) == "function") config.columns = config.columns();
    require(['excel-builder', 'Template/BasicReport'], function (builder, BasicReport) {
        var basicReport = new BasicReport();
        var columns = config.columns;
        var worksheetData = [];
        worksheetData[0] = [];
        for(var i in columns){
            columns[i]['id'] = (parseInt(i)+1);
            if(typeof (columns[i]['type']) == "undefined") columns[i]['type'] = "string";
            if(typeof (columns[i]['style']) != "undefined") columns[i]['style'] = basicReport.predefinedFormatters[columns[i]['style']].id;

            worksheetData[0].push({
                value: columns[i]['name'],
                metadata: { type: columns[i]['type'], style: basicReport.predefinedFormatters.header.id}
            });
        }
        worksheetData = worksheetData.concat(config.data);
        console.log(columns, worksheetData);
        basicReport.setHeader([
            {bold: true, text: "Generic Report"},
            "",
            ""
        ]);
        basicReport.setData(worksheetData);
        basicReport.setColumns(columns);
        basicReport.setFooter([
            '', '', 'Page &P of &N'
        ]);
        var excel =  "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64," + builder.createFile(basicReport.prepare());
        if(typeof(config.onComplete) != "undefined"){
            config.onComplete(excel);
        } else {
            window.location.href = excel;
        }
    });
}
