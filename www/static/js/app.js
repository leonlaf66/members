/*! 版权所有，Wesnail */
window.location.changeParam=function(a,b){var c=new RegExp("(\\?|\\&)("+a+"=).*?(&|$)"),d=this.href,e=this.href;e=d.search(c)>=0?d.replace(c,"$1$2"+b+"$3"):e+(e.indexOf("?")>0?"&":"?")+a+"="+b,this.href=e},String.prototype.getWidth=function(a){var b=calculateSize(this,{font:"Arial",fontSize:a+"px"});return b.width};

jQuery.curCSS = function(element, prop, val) {
    return jQuery(element).css(prop, val);
};

Date.prototype.format = function(fmt)   
{ //author: meizz   
  var o = {   
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };   
  if(/(y+)/.test(fmt))   
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
  for(var k in o)   
    if(new RegExp("("+ k +")").test(fmt))   
  fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
  return fmt;   
};