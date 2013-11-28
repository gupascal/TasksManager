function addEvent(elem, event, action)
{
	if (elem.addEventListener)
		elem.addEventListener(event, action, false);
	else
		elem.attachEvent('on'.event, action);
}

function getTarget(e)
{
	e.preventDefault();	// On bloque l'action par défaut de cet élément
	
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;
		
	return targ;
}