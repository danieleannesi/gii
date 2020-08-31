var _oDrag = null
var _x,_y,_dx,_dy
var TARGET_CLASS='popup_title';

function _mdown(e) {
	if (!e) var e = window.event;
	_oDrag = (e.target) ? e.target : e.srcElement
	if (_oDrag.className==TARGET_CLASS){
		_pause_event(e);
		_oDrag=_oDrag.parentElement;
		_x = e.clientX;
		_y = e.clientY;
		_dx = _x - parseInt(_oDrag.style.left);
		_dy = _y - parseInt(_oDrag.style.top);
		document.addEventListener("mousemove",_mdrag_on);
		document.addEventListener("mouseup",_mdrag_off);
	}
}

function _mdrag_on(e) {
	if (!e) var e = window.event;
	_pause_event(e);
	_oDrag.style.left = parseInt(e.clientX - _dx)+'px';
	_oDrag.style.top =parseInt(e.clientY - _dy)+'px';
}

function _mdrag_off(e) {
	document.removeEventListener("mousemove",_mdrag_on);
	document.removeEventListener("mouseup",_mdrag_off);
}

function _pause_event(e){
    if(e.stopPropagation) e.stopPropagation();
    if(e.preventDefault) e.preventDefault();
    e.cancelBubble=true;
    e.returnValue=false;
    return false;
}
