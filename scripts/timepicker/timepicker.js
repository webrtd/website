!function($){function Timepicker(){this.regional=[],this.regional[""]={currentText:"Now",closeText:"Done",amNames:["AM","A"],pmNames:["PM","P"],timeFormat:"HH:mm",timeSuffix:"",timeOnlyTitle:"Choose Time",timeText:"Time",hourText:"Hour",minuteText:"Minute",secondText:"Second",millisecText:"Millisecond",timezoneText:"Time Zone",isRTL:!1},this._defaults={showButtonPanel:!0,timeOnly:!1,showHour:!0,showMinute:!0,showSecond:!1,showMillisec:!1,showTimezone:!1,showTime:!0,stepHour:1,stepMinute:1,stepSecond:1,stepMillisec:1,hour:0,minute:0,second:0,millisec:0,timezone:null,useLocalTimezone:!1,defaultTimezone:"+0000",hourMin:0,minuteMin:0,secondMin:0,millisecMin:0,hourMax:23,minuteMax:59,secondMax:59,millisecMax:999,minDateTime:null,maxDateTime:null,onSelect:null,hourGrid:0,minuteGrid:0,secondGrid:0,millisecGrid:0,alwaysSetTime:!0,separator:" ",altFieldTimeOnly:!0,altTimeFormat:null,altSeparator:null,altTimeSuffix:null,pickerTimeFormat:null,pickerTimeSuffix:null,showTimepicker:!0,timezoneIso8601:!1,timezoneList:null,addSliderAccess:!1,sliderAccessArgs:null,controlType:"slider",defaultValue:null,parse:"strict"},$.extend(this._defaults,this.regional[""])}if($.ui.timepicker=$.ui.timepicker||{},!$.ui.timepicker.version){$.extend($.ui,{timepicker:{version:"1.1.0"}}),$.extend(Timepicker.prototype,{$input:null,$altInput:null,$timeObj:null,inst:null,hour_slider:null,minute_slider:null,second_slider:null,millisec_slider:null,timezone_select:null,hour:0,minute:0,second:0,millisec:0,timezone:null,defaultTimezone:"+0000",hourMinOriginal:null,minuteMinOriginal:null,secondMinOriginal:null,millisecMinOriginal:null,hourMaxOriginal:null,minuteMaxOriginal:null,secondMaxOriginal:null,millisecMaxOriginal:null,ampm:"",formattedDate:"",formattedTime:"",formattedDateTime:"",timezoneList:null,units:["hour","minute","second","millisec"],control:null,setDefaults:function(e){return extendRemove(this._defaults,e||{}),this},_newInst:function($input,o){var tp_inst=new Timepicker,inlineSettings={},fns={},overrides,i;for(var attrName in this._defaults)if(this._defaults.hasOwnProperty(attrName)){var attrValue=$input.attr("time:"+attrName);if(attrValue)try{inlineSettings[attrName]=eval(attrValue)}catch(err){inlineSettings[attrName]=attrValue}}overrides={beforeShow:function(e,t){return $.isFunction(tp_inst._defaults.evnts.beforeShow)?tp_inst._defaults.evnts.beforeShow.call($input[0],e,t,tp_inst):void 0},onChangeMonthYear:function(e,t,i){tp_inst._updateDateTime(i),$.isFunction(tp_inst._defaults.evnts.onChangeMonthYear)&&tp_inst._defaults.evnts.onChangeMonthYear.call($input[0],e,t,i,tp_inst)},onClose:function(e,t){tp_inst.timeDefined===!0&&""!==$input.val()&&tp_inst._updateDateTime(t),$.isFunction(tp_inst._defaults.evnts.onClose)&&tp_inst._defaults.evnts.onClose.call($input[0],e,t,tp_inst)}};for(i in overrides)overrides.hasOwnProperty(i)&&(fns[i]=o[i]||null);if(tp_inst._defaults=$.extend({},this._defaults,inlineSettings,o,overrides,{evnts:fns,timepicker:tp_inst}),tp_inst.amNames=$.map(tp_inst._defaults.amNames,function(e){return e.toUpperCase()}),tp_inst.pmNames=$.map(tp_inst._defaults.pmNames,function(e){return e.toUpperCase()}),"string"==typeof tp_inst._defaults.controlType?(void 0===$.fn[tp_inst._defaults.controlType]&&(tp_inst._defaults.controlType="select"),tp_inst.control=tp_inst._controls[tp_inst._defaults.controlType]):tp_inst.control=tp_inst._defaults.controlType,null===tp_inst._defaults.timezoneList){var timezoneList=["-1200","-1100","-1000","-0930","-0900","-0800","-0700","-0600","-0500","-0430","-0400","-0330","-0300","-0200","-0100","+0000","+0100","+0200","+0300","+0330","+0400","+0430","+0500","+0530","+0545","+0600","+0630","+0700","+0800","+0845","+0900","+0930","+1000","+1030","+1100","+1130","+1200","+1245","+1300","+1400"];tp_inst._defaults.timezoneIso8601&&(timezoneList=$.map(timezoneList,function(e){return"+0000"==e?"Z":e.substring(0,3)+":"+e.substring(3)})),tp_inst._defaults.timezoneList=timezoneList}return tp_inst.timezone=tp_inst._defaults.timezone,tp_inst.hour=tp_inst._defaults.hour,tp_inst.minute=tp_inst._defaults.minute,tp_inst.second=tp_inst._defaults.second,tp_inst.millisec=tp_inst._defaults.millisec,tp_inst.ampm="",tp_inst.$input=$input,o.altField&&(tp_inst.$altInput=$(o.altField).css({cursor:"pointer"}).focus(function(){$input.trigger("focus")})),(0===tp_inst._defaults.minDate||0===tp_inst._defaults.minDateTime)&&(tp_inst._defaults.minDate=new Date),(0===tp_inst._defaults.maxDate||0===tp_inst._defaults.maxDateTime)&&(tp_inst._defaults.maxDate=new Date),void 0!==tp_inst._defaults.minDate&&tp_inst._defaults.minDate instanceof Date&&(tp_inst._defaults.minDateTime=new Date(tp_inst._defaults.minDate.getTime())),void 0!==tp_inst._defaults.minDateTime&&tp_inst._defaults.minDateTime instanceof Date&&(tp_inst._defaults.minDate=new Date(tp_inst._defaults.minDateTime.getTime())),void 0!==tp_inst._defaults.maxDate&&tp_inst._defaults.maxDate instanceof Date&&(tp_inst._defaults.maxDateTime=new Date(tp_inst._defaults.maxDate.getTime())),void 0!==tp_inst._defaults.maxDateTime&&tp_inst._defaults.maxDateTime instanceof Date&&(tp_inst._defaults.maxDate=new Date(tp_inst._defaults.maxDateTime.getTime())),tp_inst.$input.bind("focus",function(){tp_inst._onFocus()}),tp_inst},_addTimePicker:function(e){var t=this.$altInput&&this._defaults.altFieldTimeOnly?this.$input.val()+" "+this.$altInput.val():this.$input.val();this.timeDefined=this._parseTime(t),this._limitMinMaxDateTime(e,!1),this._injectTimePicker()},_parseTime:function(e,t){if(this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),t||!this._defaults.timeOnly){var i=$.datepicker._get(this.inst,"dateFormat");try{var a=parseDateTimeInternal(i,this._defaults.timeFormat,e,$.datepicker._getFormatConfig(this.inst),this._defaults);if(!a.timeObj)return!1;$.extend(this,a.timeObj)}catch(s){return $.datepicker.log("Error parsing the date/time string: "+s+"\ndate/time string = "+e+"\ntimeFormat = "+this._defaults.timeFormat+"\ndateFormat = "+i),!1}return!0}var n=$.datepicker.parseTime(this._defaults.timeFormat,e,this._defaults);return n?($.extend(this,n),!0):!1},_injectTimePicker:function(){var e=this.inst.dpDiv,t=this.inst.settings,i=this,a="",s="",n={},r={},l=null;if(0===e.find("div.ui-timepicker-div").length&&t.showTimepicker){for(var o=' style="display:none;"',u='<div class="ui-timepicker-div'+(t.isRTL?" ui-timepicker-rtl":"")+'"><dl><dt class="ui_tpicker_time_label"'+(t.showTime?"":o)+">"+t.timeText+'</dt><dd class="ui_tpicker_time"'+(t.showTime?"":o)+"></dd>",d=0,m=this.units.length;m>d;d++){if(a=this.units[d],s=a.substr(0,1).toUpperCase()+a.substr(1),n[a]=parseInt(t[a+"Max"]-(t[a+"Max"]-t[a+"Min"])%t["step"+s],10),r[a]=0,u+='<dt class="ui_tpicker_'+a+'_label"'+(t["show"+s]?"":o)+">"+t[a+"Text"]+'</dt><dd class="ui_tpicker_'+a+'"><div class="ui_tpicker_'+a+'_slider"'+(t["show"+s]?"":o)+"></div>",t["show"+s]&&t[a+"Grid"]>0){if(u+='<div style="padding-left: 1px"><table class="ui-tpicker-grid-label"><tr>',"hour"==a)for(var c=t[a+"Min"];c<=n[a];c+=parseInt(t[a+"Grid"],10)){r[a]++;var h=$.datepicker.formatTime(useAmpm(t.pickerTimeFormat||t.timeFormat)?"hht":"HH",{hour:c},t);u+='<td data-for="'+a+'">'+h+"</td>"}else for(var p=t[a+"Min"];p<=n[a];p+=parseInt(t[a+"Grid"],10))r[a]++,u+='<td data-for="'+a+'">'+(10>p?"0":"")+p+"</td>";u+="</tr></table></div>"}u+="</dd>"}u+='<dt class="ui_tpicker_timezone_label"'+(t.showTimezone?"":o)+">"+t.timezoneText+"</dt>",u+='<dd class="ui_tpicker_timezone" '+(t.showTimezone?"":o)+"></dd>",u+="</dl></div>";var f=$(u);t.timeOnly===!0&&(f.prepend('<div class="ui-widget-header ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-title">'+t.timeOnlyTitle+"</div></div>"),e.find(".ui-datepicker-header, .ui-datepicker-calendar").hide());for(var d=0,m=i.units.length;m>d;d++)a=i.units[d],s=a.substr(0,1).toUpperCase()+a.substr(1),i[a+"_slider"]=i.control.create(i,f.find(".ui_tpicker_"+a+"_slider"),a,i[a],t[a+"Min"],n[a],t["step"+s]),t["show"+s]&&t[a+"Grid"]>0&&(l=100*r[a]*t[a+"Grid"]/(n[a]-t[a+"Min"]),f.find(".ui_tpicker_"+a+" table").css({width:l+"%",marginLeft:t.isRTL?"0":l/(-2*r[a])+"%",marginRight:t.isRTL?l/(-2*r[a])+"%":"0",borderCollapse:"collapse"}).find("td").click(function(e){var t=$(this),s=t.html(),n=parseInt(s.replace(/[^0-9]/g),10),r=s.replace(/[^apm]/gi),l=t.data("for");"hour"==l&&(-1!==r.indexOf("p")&&12>n?n+=12:-1!==r.indexOf("a")&&12===n&&(n=0)),i.control.value(i,i[l+"_slider"],a,n),i._onTimeChange(),i._onSelectHandler()}).css({cursor:"pointer",width:100/r[a]+"%",textAlign:"center",overflow:"hidden"}));if(this.timezone_select=f.find(".ui_tpicker_timezone").append("<select></select>").find("select"),$.fn.append.apply(this.timezone_select,$.map(t.timezoneList,function(e,t){return $("<option />").val("object"==typeof e?e.value:e).text("object"==typeof e?e.label:e)})),"undefined"!=typeof this.timezone&&null!==this.timezone&&""!==this.timezone){var _=new Date(this.inst.selectedYear,this.inst.selectedMonth,this.inst.selectedDay,12),g=$.timepicker.timeZoneOffsetString(_);g==this.timezone?selectLocalTimeZone(i):this.timezone_select.val(this.timezone)}else"undefined"!=typeof this.hour&&null!==this.hour&&""!==this.hour?this.timezone_select.val(t.defaultTimezone):selectLocalTimeZone(i);this.timezone_select.change(function(){i._defaults.useLocalTimezone=!1,i._onTimeChange()});var v=e.find(".ui-datepicker-buttonpane");if(v.length?v.before(f):e.append(f),this.$timeObj=f.find(".ui_tpicker_time"),null!==this.inst){var k=this.timeDefined;this._onTimeChange(),this.timeDefined=k}if(this._defaults.addSliderAccess){var T=this._defaults.sliderAccessArgs,D=this._defaults.isRTL;T.isRTL=D,setTimeout(function(){if(0===f.find(".ui-slider-access").length){f.find(".ui-slider:visible").sliderAccess(T);var e=f.find(".ui-slider-access:eq(0)").outerWidth(!0);e&&f.find("table:visible").each(function(){var t=$(this),i=t.outerWidth(),a=t.css(D?"marginRight":"marginLeft").toString().replace("%",""),s=i-e,n=a*s/i+"%",r={width:s,marginRight:0,marginLeft:0};r[D?"marginRight":"marginLeft"]=n,t.css(r)})}},10)}}},_limitMinMaxDateTime:function(e,t){var i=this._defaults,a=new Date(e.selectedYear,e.selectedMonth,e.selectedDay);if(this._defaults.showTimepicker){if(null!==$.datepicker._get(e,"minDateTime")&&void 0!==$.datepicker._get(e,"minDateTime")&&a){var s=$.datepicker._get(e,"minDateTime"),n=new Date(s.getFullYear(),s.getMonth(),s.getDate(),0,0,0,0);(null===this.hourMinOriginal||null===this.minuteMinOriginal||null===this.secondMinOriginal||null===this.millisecMinOriginal)&&(this.hourMinOriginal=i.hourMin,this.minuteMinOriginal=i.minuteMin,this.secondMinOriginal=i.secondMin,this.millisecMinOriginal=i.millisecMin),e.settings.timeOnly||n.getTime()==a.getTime()?(this._defaults.hourMin=s.getHours(),this.hour<=this._defaults.hourMin?(this.hour=this._defaults.hourMin,this._defaults.minuteMin=s.getMinutes(),this.minute<=this._defaults.minuteMin?(this.minute=this._defaults.minuteMin,this._defaults.secondMin=s.getSeconds(),this.second<=this._defaults.secondMin?(this.second=this._defaults.secondMin,this._defaults.millisecMin=s.getMilliseconds()):(this.millisec<this._defaults.millisecMin&&(this.millisec=this._defaults.millisecMin),this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)):(this._defaults.hourMin=this.hourMinOriginal,this._defaults.minuteMin=this.minuteMinOriginal,this._defaults.secondMin=this.secondMinOriginal,this._defaults.millisecMin=this.millisecMinOriginal)}if(null!==$.datepicker._get(e,"maxDateTime")&&void 0!==$.datepicker._get(e,"maxDateTime")&&a){var r=$.datepicker._get(e,"maxDateTime"),l=new Date(r.getFullYear(),r.getMonth(),r.getDate(),0,0,0,0);(null===this.hourMaxOriginal||null===this.minuteMaxOriginal||null===this.secondMaxOriginal)&&(this.hourMaxOriginal=i.hourMax,this.minuteMaxOriginal=i.minuteMax,this.secondMaxOriginal=i.secondMax,this.millisecMaxOriginal=i.millisecMax),e.settings.timeOnly||l.getTime()==a.getTime()?(this._defaults.hourMax=r.getHours(),this.hour>=this._defaults.hourMax?(this.hour=this._defaults.hourMax,this._defaults.minuteMax=r.getMinutes(),this.minute>=this._defaults.minuteMax?(this.minute=this._defaults.minuteMax,this._defaults.secondMax=r.getSeconds()):this.second>=this._defaults.secondMax?(this.second=this._defaults.secondMax,this._defaults.millisecMax=r.getMilliseconds()):(this.millisec>this._defaults.millisecMax&&(this.millisec=this._defaults.millisecMax),this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)):(this._defaults.hourMax=this.hourMaxOriginal,this._defaults.minuteMax=this.minuteMaxOriginal,this._defaults.secondMax=this.secondMaxOriginal,this._defaults.millisecMax=this.millisecMaxOriginal)}if(void 0!==t&&t===!0){var o=parseInt(this._defaults.hourMax-(this._defaults.hourMax-this._defaults.hourMin)%this._defaults.stepHour,10),u=parseInt(this._defaults.minuteMax-(this._defaults.minuteMax-this._defaults.minuteMin)%this._defaults.stepMinute,10),d=parseInt(this._defaults.secondMax-(this._defaults.secondMax-this._defaults.secondMin)%this._defaults.stepSecond,10),m=parseInt(this._defaults.millisecMax-(this._defaults.millisecMax-this._defaults.millisecMin)%this._defaults.stepMillisec,10);this.hour_slider&&(this.control.options(this,this.hour_slider,"hour",{min:this._defaults.hourMin,max:o}),this.control.value(this,this.hour_slider,"hour",this.hour)),this.minute_slider&&(this.control.options(this,this.minute_slider,"minute",{min:this._defaults.minuteMin,max:u}),this.control.value(this,this.minute_slider,"minute",this.minute)),this.second_slider&&(this.control.options(this,this.second_slider,"second",{min:this._defaults.secondMin,max:d}),this.control.value(this,this.second_slider,"second",this.second)),this.millisec_slider&&(this.control.options(this,this.millisec_slider,"millisec",{min:this._defaults.millisecMin,max:m}),this.control.value(this,this.millisec_slider,"millisec",this.millisec))}}},_onTimeChange:function(){var e=this.hour_slider?this.control.value(this,this.hour_slider,"hour"):!1,t=this.minute_slider?this.control.value(this,this.minute_slider,"minute"):!1,i=this.second_slider?this.control.value(this,this.second_slider,"second"):!1,a=this.millisec_slider?this.control.value(this,this.millisec_slider,"millisec"):!1,s=this.timezone_select?this.timezone_select.val():!1,n=this._defaults,r=n.pickerTimeFormat||n.timeFormat,l=n.pickerTimeSuffix||n.timeSuffix;"object"==typeof e&&(e=!1),"object"==typeof t&&(t=!1),"object"==typeof i&&(i=!1),"object"==typeof a&&(a=!1),"object"==typeof s&&(s=!1),e!==!1&&(e=parseInt(e,10)),t!==!1&&(t=parseInt(t,10)),i!==!1&&(i=parseInt(i,10)),a!==!1&&(a=parseInt(a,10));var o=n[12>e?"amNames":"pmNames"][0],u=e!=this.hour||t!=this.minute||i!=this.second||a!=this.millisec||this.ampm.length>0&&12>e!=(-1!==$.inArray(this.ampm.toUpperCase(),this.amNames))||null===this.timezone&&s!=this.defaultTimezone||null!==this.timezone&&s!=this.timezone;u&&(e!==!1&&(this.hour=e),t!==!1&&(this.minute=t),i!==!1&&(this.second=i),a!==!1&&(this.millisec=a),s!==!1&&(this.timezone=s),this.inst||(this.inst=$.datepicker._getInst(this.$input[0])),this._limitMinMaxDateTime(this.inst,!0)),useAmpm(n.timeFormat)&&(this.ampm=o),this.formattedTime=$.datepicker.formatTime(n.timeFormat,this,n),this.$timeObj&&(r===n.timeFormat?this.$timeObj.text(this.formattedTime+l):this.$timeObj.text($.datepicker.formatTime(r,this,n)+l)),this.timeDefined=!0,u&&this._updateDateTime()},_onSelectHandler:function(){var e=this._defaults.onSelect||this.inst.settings.onSelect,t=this.$input?this.$input[0]:null;e&&t&&e.apply(t,[this.formattedDateTime,this])},_updateDateTime:function(e){e=this.inst||e;var t=$.datepicker._daylightSavingAdjust(new Date(e.selectedYear,e.selectedMonth,e.selectedDay)),i=$.datepicker._get(e,"dateFormat"),a=$.datepicker._getFormatConfig(e),s=null!==t&&this.timeDefined;this.formattedDate=$.datepicker.formatDate(i,null===t?new Date:t,a);var n=this.formattedDate;if(this._defaults.timeOnly===!0?n=this.formattedTime:this._defaults.timeOnly!==!0&&(this._defaults.alwaysSetTime||s)&&(n+=this._defaults.separator+this.formattedTime+this._defaults.timeSuffix),this.formattedDateTime=n,this._defaults.showTimepicker)if(this.$altInput&&this._defaults.altFieldTimeOnly===!0)this.$altInput.val(this.formattedTime),this.$input.val(this.formattedDate);else if(this.$altInput){this.$input.val(n);var r="",l=this._defaults.altSeparator?this._defaults.altSeparator:this._defaults.separator,o=this._defaults.altTimeSuffix?this._defaults.altTimeSuffix:this._defaults.timeSuffix;r=this._defaults.altFormat?$.datepicker.formatDate(this._defaults.altFormat,null===t?new Date:t,a):this.formattedDate,r&&(r+=l),r+=this._defaults.altTimeFormat?$.datepicker.formatTime(this._defaults.altTimeFormat,this,this._defaults)+o:this.formattedTime+o,this.$altInput.val(r)}else this.$input.val(n);else this.$input.val(this.formattedDate);this.$input.trigger("change")},_onFocus:function(){if(!this.$input.val()&&this._defaults.defaultValue){this.$input.val(this._defaults.defaultValue);var e=$.datepicker._getInst(this.$input.get(0)),t=$.datepicker._get(e,"timepicker");if(t&&t._defaults.timeOnly&&e.input.val()!=e.lastVal)try{$.datepicker._updateDatepicker(e)}catch(i){$.datepicker.log(i)}}},_controls:{slider:{create:function(e,t,i,a,s,n,r){var l=e._defaults.isRTL;return t.prop("slide",null).slider({orientation:"horizontal",value:l?-1*a:a,min:l?-1*n:s,max:l?-1*s:n,step:r,slide:function(t,a){e.control.value(e,$(this),i,l?-1*a.value:a.value),e._onTimeChange()},stop:function(t,i){e._onSelectHandler()}})},options:function(e,t,i,a,s){if(e._defaults.isRTL){if("string"==typeof a)return"min"==a||"max"==a?void 0!==s?t.slider(a,-1*s):Math.abs(t.slider(a)):t.slider(a);var n=a.min,r=a.max;return a.min=a.max=null,void 0!==n&&(a.max=-1*n),void 0!==r&&(a.min=-1*r),t.slider(a)}return"string"==typeof a&&void 0!==s?t.slider(a,s):t.slider(a)},value:function(e,t,i,a){return e._defaults.isRTL?void 0!==a?t.slider("value",-1*a):Math.abs(t.slider("value")):void 0!==a?t.slider("value",a):t.slider("value")}},select:{create:function(e,t,i,a,s,n,r){for(var l='<select class="ui-timepicker-select" data-unit="'+i+'" data-min="'+s+'" data-max="'+n+'" data-step="'+r+'">',o=(-1!==e._defaults.timeFormat.indexOf("t")?"toLowerCase":"toUpperCase",s);n>=o;o+=r)l+='<option value="'+o+'"'+(o==a?" selected":"")+">",l+="hour"==i&&useAmpm(e._defaults.pickerTimeFormat||e._defaults.timeFormat)?$.datepicker.formatTime("hh TT",{hour:o},e._defaults):"millisec"==i||o>=10?o:"0"+o.toString(),l+="</option>";return l+="</select>",t.children("select").remove(),$(l).appendTo(t).change(function(t){e._onTimeChange(),e._onSelectHandler()}),t},options:function(e,t,i,a,s){var n={},r=t.children("select");if("string"==typeof a){if(void 0===s)return r.data(a);n[a]=s}else n=a;return e.control.create(e,t,r.data("unit"),r.val(),n.min||r.data("min"),n.max||r.data("max"),n.step||r.data("step"))},value:function(e,t,i,a){var s=t.children("select");return void 0!==a?s.val(a):s.val()}}}}),$.fn.extend({timepicker:function(e){e=e||{};var t=Array.prototype.slice.call(arguments);return"object"==typeof e&&(t[0]=$.extend(e,{timeOnly:!0})),$(this).each(function(){$.fn.datetimepicker.apply($(this),t)})},datetimepicker:function(e){e=e||{};var t=arguments;return"string"==typeof e?"getDate"==e?$.fn.datepicker.apply($(this[0]),t):this.each(function(){var e=$(this);e.datepicker.apply(e,t)}):this.each(function(){var t=$(this);t.datepicker($.timepicker._newInst(t,e)._defaults)})}}),$.datepicker.parseDateTime=function(e,t,i,a,s){var n=parseDateTimeInternal(e,t,i,a,s);if(n.timeObj){var r=n.timeObj;n.date.setHours(r.hour,r.minute,r.second,r.millisec)}return n.date},$.datepicker.parseTime=function(e,t,i){var a=extendRemove(extendRemove({},$.timepicker._defaults),i||{}),s=function(e,t,i){var a,s=function(e,t){var i=[];return e&&$.merge(i,e),t&&$.merge(i,t),i=$.map(i,function(e){return e.replace(/[.*+?|()\[\]{}\\]/g,"\\$&")}),"("+i.join("|")+")?"},n=function(e){var t=e.toLowerCase().match(/(h{1,2}|m{1,2}|s{1,2}|l{1}|t{1,2}|z|'.*?')/g),i={h:-1,m:-1,s:-1,l:-1,t:-1,z:-1};if(t)for(var a=0;a<t.length;a++)-1==i[t[a].toString().charAt(0)]&&(i[t[a].toString().charAt(0)]=a+1);return i},r="^"+e.toString().replace(/([hH]{1,2}|mm?|ss?|[tT]{1,2}|[lz]|'.*?')/g,function(e){switch(e.charAt(0).toLowerCase()){case"h":return"(\\d?\\d)";case"m":return"(\\d?\\d)";case"s":return"(\\d?\\d)";case"l":return"(\\d?\\d?\\d)";case"z":return"(z|[-+]\\d\\d:?\\d\\d|\\S+)?";case"t":return s(i.amNames,i.pmNames);default:return"("+e.replace(/\'/g,"").replace(/(\.|\$|\^|\\|\/|\(|\)|\[|\]|\?|\+|\*)/g,function(e){return"\\"+e})+")?"}}).replace(/\s/g,"\\s?")+i.timeSuffix+"$",l=n(e),o="";a=t.match(new RegExp(r,"i"));var u={hour:0,minute:0,second:0,millisec:0};if(a){if(-1!==l.t&&(void 0===a[l.t]||0===a[l.t].length?(o="",u.ampm=""):(o=-1!==$.inArray(a[l.t].toUpperCase(),i.amNames)?"AM":"PM",u.ampm=i["AM"==o?"amNames":"pmNames"][0])),-1!==l.h&&("AM"==o&&"12"==a[l.h]?u.hour=0:"PM"==o&&"12"!=a[l.h]?u.hour=parseInt(a[l.h],10)+12:u.hour=Number(a[l.h])),-1!==l.m&&(u.minute=Number(a[l.m])),-1!==l.s&&(u.second=Number(a[l.s])),-1!==l.l&&(u.millisec=Number(a[l.l])),-1!==l.z&&void 0!==a[l.z]){var d=a[l.z].toUpperCase();switch(d.length){case 1:d=i.timezoneIso8601?"Z":"+0000";break;case 5:i.timezoneIso8601&&(d="0000"==d.substring(1)?"Z":d.substring(0,3)+":"+d.substring(3));break;case 6:i.timezoneIso8601?"00:00"==d.substring(1)&&(d="Z"):d="Z"==d||"00:00"==d.substring(1)?"+0000":d.replace(/:/,"")}u.timezone=d}return u}return!1},n=function(e,t,i){try{var a=new Date("2012-01-01 "+t);return{hour:a.getHours(),minutes:a.getMinutes(),seconds:a.getSeconds(),millisec:a.getMilliseconds(),timezone:$.timepicker.timeZoneOffsetString(a)}}catch(n){try{return s(e,t,i)}catch(r){$.datepicker.log("Unable to parse \ntimeString: "+t+"\ntimeFormat: "+e)}}return!1};return"function"==typeof a.parse?a.parse(e,t,a):"loose"===a.parse?n(e,t,a):s(e,t,a)},$.datepicker.formatTime=function(e,t,i){i=i||{},i=$.extend({},$.timepicker._defaults,i),t=$.extend({hour:0,minute:0,second:0,millisec:0,timezone:"+0000"},t);var a=e,s=i.amNames[0],n=parseInt(t.hour,10);return n>11&&(s=i.pmNames[0]),a=a.replace(/(?:HH?|hh?|mm?|ss?|[tT]{1,2}|[lz]|('.*?'|".*?"))/g,function(e){switch(e){case"HH":return("0"+n).slice(-2);case"H":return n;case"hh":return convert24to12(n).slice(-2);case"h":return convert24to12(n);case"mm":return("0"+t.minute).slice(-2);case"m":return t.minute;case"ss":return("0"+t.second).slice(-2);case"s":return t.second;case"l":return("00"+t.millisec).slice(-3);case"z":return null===t.timezone?i.defaultTimezone:t.timezone;case"T":return s.charAt(0).toUpperCase();case"TT":return s.toUpperCase();case"t":return s.charAt(0).toLowerCase();case"tt":return s.toLowerCase();default:return e.replace(/\'/g,"")||"'"}}),a=$.trim(a)},$.datepicker._base_selectDate=$.datepicker._selectDate,$.datepicker._selectDate=function(e,t){var i=this._getInst($(e)[0]),a=this._get(i,"timepicker");a?(a._limitMinMaxDateTime(i,!0),i.inline=i.stay_open=!0,this._base_selectDate(e,t),i.inline=i.stay_open=!1,this._notifyChange(i),this._updateDatepicker(i)):this._base_selectDate(e,t)},$.datepicker._base_updateDatepicker=$.datepicker._updateDatepicker,$.datepicker._updateDatepicker=function(e){var t=e.input[0];if(!($.datepicker._curInst&&$.datepicker._curInst!=e&&$.datepicker._datepickerShowing&&$.datepicker._lastInput!=t||"boolean"==typeof e.stay_open&&e.stay_open!==!1)){this._base_updateDatepicker(e);var i=this._get(e,"timepicker");if(i&&(i._addTimePicker(e),i._defaults.useLocalTimezone)){var a=new Date(e.selectedYear,e.selectedMonth,e.selectedDay,12);selectLocalTimeZone(i,a),i._onTimeChange()}}},$.datepicker._base_doKeyPress=$.datepicker._doKeyPress,$.datepicker._doKeyPress=function(e){var t=$.datepicker._getInst(e.target),i=$.datepicker._get(t,"timepicker");if(i&&$.datepicker._get(t,"constrainInput")){var a=useAmpm(i._defaults.timeFormat),s=$.datepicker._possibleChars($.datepicker._get(t,"dateFormat")),n=i._defaults.timeFormat.toString().replace(/[hms]/g,"").replace(/TT/g,a?"APM":"").replace(/Tt/g,a?"AaPpMm":"").replace(/tT/g,a?"AaPpMm":"").replace(/T/g,a?"AP":"").replace(/tt/g,a?"apm":"").replace(/t/g,a?"ap":"")+" "+i._defaults.separator+i._defaults.timeSuffix+(i._defaults.showTimezone?i._defaults.timezoneList.join(""):"")+i._defaults.amNames.join("")+i._defaults.pmNames.join("")+s,r=String.fromCharCode(void 0===e.charCode?e.keyCode:e.charCode);return e.ctrlKey||" ">r||!s||n.indexOf(r)>-1}return $.datepicker._base_doKeyPress(e)},$.datepicker._base_updateAlternate=$.datepicker._updateAlternate,$.datepicker._updateAlternate=function(e){var t=this._get(e,"timepicker");if(t){var i=t._defaults.altField;if(i){var a=(t._defaults.altFormat||t._defaults.dateFormat,this._getDate(e)),s=$.datepicker._getFormatConfig(e),n="",r=t._defaults.altSeparator?t._defaults.altSeparator:t._defaults.separator,l=t._defaults.altTimeSuffix?t._defaults.altTimeSuffix:t._defaults.timeSuffix,o=null!==t._defaults.altTimeFormat?t._defaults.altTimeFormat:t._defaults.timeFormat;n+=$.datepicker.formatTime(o,t,t._defaults)+l,t._defaults.timeOnly||t._defaults.altFieldTimeOnly||(n=t._defaults.altFormat?$.datepicker.formatDate(t._defaults.altFormat,null===a?new Date:a,s)+r+n:t.formattedDate+r+n),$(i).val(n)}}else $.datepicker._base_updateAlternate(e)},$.datepicker._base_doKeyUp=$.datepicker._doKeyUp,$.datepicker._doKeyUp=function(e){var t=$.datepicker._getInst(e.target),i=$.datepicker._get(t,"timepicker");if(i&&i._defaults.timeOnly&&t.input.val()!=t.lastVal)try{$.datepicker._updateDatepicker(t)}catch(a){$.datepicker.log(a)}return $.datepicker._base_doKeyUp(e)},$.datepicker._base_gotoToday=$.datepicker._gotoToday,$.datepicker._gotoToday=function(e){var t=this._getInst($(e)[0]),i=t.dpDiv;this._base_gotoToday(e);var a=this._get(t,"timepicker");selectLocalTimeZone(a);var s=new Date;this._setTime(t,s),$(".ui-datepicker-today",i).click()},$.datepicker._disableTimepickerDatepicker=function(e){var t=this._getInst(e);if(t){var i=this._get(t,"timepicker");$(e).datepicker("getDate"),i&&(i._defaults.showTimepicker=!1,i._updateDateTime(t))}},$.datepicker._enableTimepickerDatepicker=function(e){var t=this._getInst(e);if(t){var i=this._get(t,"timepicker");$(e).datepicker("getDate"),i&&(i._defaults.showTimepicker=!0,i._addTimePicker(t),i._updateDateTime(t))}},$.datepicker._setTime=function(e,t){var i=this._get(e,"timepicker");if(i){var a=i._defaults;i.hour=t?t.getHours():a.hour,i.minute=t?t.getMinutes():a.minute,i.second=t?t.getSeconds():a.second,i.millisec=t?t.getMilliseconds():a.millisec,i._limitMinMaxDateTime(e,!0),i._onTimeChange(),i._updateDateTime(e)}},$.datepicker._setTimeDatepicker=function(e,t,i){var a=this._getInst(e);if(a){var s=this._get(a,"timepicker");if(s){this._setDateFromField(a);var n;t&&("string"==typeof t?(s._parseTime(t,i),n=new Date,n.setHours(s.hour,s.minute,s.second,s.millisec)):n=new Date(t.getTime()),"Invalid Date"==n.toString()&&(n=void 0),this._setTime(a,n))}}},$.datepicker._base_setDateDatepicker=$.datepicker._setDateDatepicker,$.datepicker._setDateDatepicker=function(e,t){var i=this._getInst(e);if(i){var a=t instanceof Date?new Date(t.getTime()):t;this._updateDatepicker(i),this._base_setDateDatepicker.apply(this,arguments),this._setTimeDatepicker(e,a,!0)}},$.datepicker._base_getDateDatepicker=$.datepicker._getDateDatepicker,$.datepicker._getDateDatepicker=function(e,t){var i=this._getInst(e);if(i){var a=this._get(i,"timepicker");if(a){void 0===i.lastVal&&this._setDateFromField(i,t);var s=this._getDate(i);return s&&a._parseTime($(e).val(),a.timeOnly)&&s.setHours(a.hour,a.minute,a.second,a.millisec),s}return this._base_getDateDatepicker(e,t)}},$.datepicker._base_parseDate=$.datepicker.parseDate,$.datepicker.parseDate=function(e,t,i){var a;try{a=this._base_parseDate(e,t,i)}catch(s){a=this._base_parseDate(e,t.substring(0,t.length-(s.length-s.indexOf(":")-2)),i),$.datepicker.log("Error parsing the date string: "+s+"\ndate string = "+t+"\ndate format = "+e)}return a},$.datepicker._base_formatDate=$.datepicker._formatDate,$.datepicker._formatDate=function(e,t,i,a){var s=this._get(e,"timepicker");return s?(s._updateDateTime(e),s.$input.val()):this._base_formatDate(e)},$.datepicker._base_optionDatepicker=$.datepicker._optionDatepicker,$.datepicker._optionDatepicker=function(e,t,i){var a,s=this._getInst(e);if(!s)return null;var n=this._get(s,"timepicker");if(n){var r,l=null,o=null,u=null,d=n._defaults.evnts,m={};if("string"==typeof t){if("minDate"===t||"minDateTime"===t)l=i;else if("maxDate"===t||"maxDateTime"===t)o=i;else if("onSelect"===t)u=i;else if(d.hasOwnProperty(t)){if("undefined"==typeof i)return d[t];m[t]=i,a={}}}else if("object"==typeof t){t.minDate?l=t.minDate:t.minDateTime?l=t.minDateTime:t.maxDate?o=t.maxDate:t.maxDateTime&&(o=t.maxDateTime);for(r in d)d.hasOwnProperty(r)&&t[r]&&(m[r]=t[r])}for(r in m)m.hasOwnProperty(r)&&(d[r]=m[r],a||(a=$.extend({},t)),delete a[r]);if(a&&isEmptyObject(a))return;l?(l=0===l?new Date:new Date(l),n._defaults.minDate=l,n._defaults.minDateTime=l):o?(o=0===o?new Date:new Date(o),n._defaults.maxDate=o,n._defaults.maxDateTime=o):u&&(n._defaults.onSelect=u)}return void 0===i?this._base_optionDatepicker.call($.datepicker,e,t):this._base_optionDatepicker.call($.datepicker,e,a||t,i)};var isEmptyObject=function(e){var t;for(t in e)if(e.hasOwnProperty(e))return!1;return!0},extendRemove=function(e,t){$.extend(e,t);for(var i in t)(null===t[i]||void 0===t[i])&&(e[i]=t[i]);return e},useAmpm=function(e){return-1!==e.indexOf("t")&&-1!==e.indexOf("h")},convert24to12=function(e){return e>12&&(e-=12),0==e&&(e=12),10>e&&(e="0"+e),String(e)},splitDateTime=function(e,t,i,a){try{var s=a&&a.separator?a.separator:$.timepicker._defaults.separator,n=a&&a.timeFormat?a.timeFormat:$.timepicker._defaults.timeFormat,r=n.split(s),l=r.length,o=t.split(s),u=o.length;if(u>1)return[o.splice(0,u-l).join(s),o.splice(0,l).join(s)]}catch(d){if($.datepicker.log("Could not split the date from the time. Please check the following datetimepicker options\nthrown error: "+d+"\ndateTimeString"+t+"\ndateFormat = "+e+"\nseparator = "+a.separator+"\ntimeFormat = "+a.timeFormat),d.indexOf(":")>=0){var m=t.length-(d.length-d.indexOf(":")-2);t.substring(m);return[$.trim(t.substring(0,m)),$.trim(t.substring(m))]}throw d}return[t,""]},parseDateTimeInternal=function(e,t,i,a,s){var n,r=splitDateTime(e,i,a,s);if(n=$.datepicker._base_parseDate(e,r[0],a),""!==r[1]){var l=r[1],o=$.datepicker.parseTime(t,l,s);if(null===o)throw"Wrong time format";return{date:n,timeObj:o}}return{date:n}},selectLocalTimeZone=function(e,t){if(e&&e.timezone_select){e._defaults.useLocalTimezone=!0;var i="undefined"!=typeof t?t:new Date,a=$.timepicker.timeZoneOffsetString(i);e._defaults.timezoneIso8601&&(a=a.substring(0,3)+":"+a.substring(3)),e.timezone_select.val(a)}};$.timepicker=new Timepicker,$.timepicker.timeZoneOffsetString=function(e){var t=-1*e.getTimezoneOffset(),i=t%60,a=(t-i)/60;return(t>=0?"+":"-")+("0"+(101*a).toString()).substr(-2)+("0"+(101*i).toString()).substr(-2)},$.timepicker.timeRange=function(e,t,i){return $.timepicker.handleRange("timepicker",e,t,i)},$.timepicker.dateTimeRange=function(e,t,i){$.timepicker.dateRange(e,t,i,"datetimepicker")},$.timepicker.dateRange=function(e,t,i,a){a=a||"datepicker",$.timepicker.handleRange(a,e,t,i)},$.timepicker.handleRange=function(e,t,i,a){function s(e,a,s){a.val()&&new Date(t.val())>new Date(i.val())&&a.val(s)}function n(t,i,a){if($(t).val()){var s=$(t)[e].call($(t),"getDate");s.getTime&&$(i)[e].call($(i),"option",a,s)}}return $.fn[e].call(t,$.extend({onClose:function(e,t){s(this,i,e)},onSelect:function(e){n(this,i,"minDate")}},a,a.start)),$.fn[e].call(i,$.extend({onClose:function(e,i){s(this,t,e)},onSelect:function(e){n(this,t,"maxDate");}},a,a.end)),"timepicker"!=e&&a.reformat&&$([t,i]).each(function(){var t=$(this)[e].call($(this),"option","dateFormat"),i=new Date($(this).val());$(this).val()&&i&&$(this).val($.datepicker.formatDate(t,i))}),s(t,i,t.val()),n(t,i,"minDate"),n(i,t,"maxDate"),$([t.get(0),i.get(0)])},$.timepicker.version="1.1.0"}}(jQuery);