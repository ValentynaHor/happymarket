var mDCal;
function jr(){
formDate.fromDate.value=mDCalDateFrom;
formDate.toDate.value=mDCalDateTo;
mDCal = new dhtmlxDblCalendarObject('dhtmlxDblCalendar', false, {isMonthEditable: true, isYearEditable: true});
mDCal.setYearsRange(2008, 2020);
mDCal.setDate(mDCalDateFrom,mDCalDateTo);
mDCal.leftCalendar.attachEvent("onClick",setDblLeftDate);
mDCal.rightCalendar.attachEvent("onClick",setDblRightDate);
mDCal.draw();
mDCal.hide();
};
function setDblLeftDate(date){
formDate.fromDate.value=mDCal.leftCalendar.getFormatedDate("%d.%m.%Y", date);
};
function setDblRightDate(date){
formDate.toDate.value=mDCal.leftCalendar.getFormatedDate("%d.%m.%Y", date);
};
function showHide(){
var obj=document.getElementById("dhtmlxDblCalendar");
if(obj.style.display=="none")obj.style.display="";
else obj.style.display="none";};
jr();