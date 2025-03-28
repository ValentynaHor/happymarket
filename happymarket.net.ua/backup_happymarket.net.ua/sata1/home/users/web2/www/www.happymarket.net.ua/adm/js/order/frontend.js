<!--
var selectCategories = '';
function searchWare(warename,num) {
    var req = new JsHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            document.getElementById('result'+num).innerHTML = req.responseJS.resultSearch;
            //document.getElementById('debug').innerHTML = req.responseText;
        }
    }
    // Prepare request object (automatically choose GET or POST).
     req.open(null, 'order/backendSearchWares.php', true);
    // Send data to backend.
    req.send( { searchWareName: warename,  categories: selectCategories, numWare: num} );
  }

var lastWareName = new Array(); lastWareName[0] = '';
function selectWare(id, cat, num) {
    window.clearTimeout(timeHidden);
    var req2 = new JsHttpRequest();
    req2.onreadystatechange = function() {
        if (req2.readyState == 4) {
	    document.getElementById('ware'+num).innerHTML = req2.responseJS.resultSearch;
	    lastWareName[num] = req2.responseJS.resultWareName;
	    if(lastWareName[num+1] == undefined)
		{
		var newtr = document.createElement("TR");
		newtr.id = "ware"+(num+1);
		newtr.setAttribute('class', 'row1');
		newtr.style.textAlign = "center";
		document.getElementById('tableWares').insertBefore(newtr, null);
		newtr.innerHTML = req2.responseJS.resultNewWare;
		lastWareName[num+1] = '';
		}
        }
    }
	var orderCourse;
	//orderCourse = document.order1.order_orderCourse.value;
	if(lastWareName[num+1] == undefined) newware = 1; else newware = 0;
	// Prepare request object (automatically choose GET or POST).
	req2.open(null, 'order/backendSearchWares.php', true);
	 // Send data to backend.
	req2.send( { selectWareID: id,  category: cat, numWare: num, addNew:newware, cource:orderCourse} );
  }

function hiddenResult(this_obj,num) {this_timeobj = this_obj; timenum = num; timeHidden = window.setTimeout("document.getElementById('result'+timenum).innerHTML=''; this_timeobj.value = lastWareName[timenum];", 100); }
function checkCat(obj) { /*if(selectCategories == '') {alert('Не выбрана ни одна рубрика'); obj.blur(); popupVisible(111);}*/ }
//-->