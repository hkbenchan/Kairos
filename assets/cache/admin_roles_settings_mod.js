eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(9($){2 q=9(a){2 b=a.w;2 d=b.8;2 e=[];6(2 i=0;i<d;i++){2 f=b[i].Z;2 g=f.8;6(2 j=0;j<g;j++){2 c=f[j];2 h=c.12||1;2 n=c.10||1;2 o=-1;3(!e[i]){e[i]=[]}2 m=e[i];z(m[++o]){}c.E=o;6(2 k=i;k<i+h;k++){3(!e[k]){e[k]=[]}2 p=e[k];6(2 l=o;l<o+n;l++){p[l]=1}}}}};2 u=9(a){2 v=0,i,k,r=(a.Y)?a.Y.w:0;3(r){6(i=0;i<r.8;i++){r[i].T=v++}}6(k=0;k<a.H.8;k++){r=a.H[k].w;3(r){6(i=0;i<r.8;i++){r[i].T=v++}}}r=(a.W)?a.W.w:0;3(r){6(i=0;i<r.8;i++){r[i].T=v++}}};$.U.1D=9(m){2 n=$.1A({1o:5,1n:5,1r:5,1i:B,1g:5,1f:B,1e:5,1d:B,1c:5,1b:B,1a:5,19:[],17:B,16:5,15:B,K:\'1s\',J:\'\',I:\'\',G:\'\'},m);1q V.1E(9(){2 d=[],A=[],4=V,r,13=0,L=[-1,-1];3(!4.H||!4.H.8){1q}2 f=9(a,b){2 c,X,S,N,7,s;6(S=0;S<a.8;S++,13++){X=a[S];6(N=0;N<X.Z.8;N++){c=X.Z[N];3((b==\'R\'&&n.1g)||(b==\'Q\'&&n.1f)||(b==\'P\'&&n.1i)){s=c.12;z(--s>=0){A[13+s].1p(c)}}3((b==\'R\'&&n.1c)||(b==\'P\'&&n.1d)||(b==\'Q\'&&n.1b)){s=c.10;z(--s>=0){7=c.E+s;3($.1C(7+1,n.19)>-1){1B}3(!d[7]){d[7]=[]}d[7].1p(c)}}3((b==\'R\'&&n.1n)||(b==\'P\'&&n.1o)||(b==\'Q\'&&n.1r)){c.C=5}}}};2 g=9(e){2 p=e.11;z(p!=V&&p.C!==5){p=p.D}3(p.C===5){l(p,5)}};2 j=9(e){2 p=e.11;z(p!=V&&p.C!==5){p=p.D}3(p.C===5){l(p,B)}};2 k=9(e){2 t=e.11;z(t&&t!=4&&!t.C)t=t.D;3(t.C&&n.G!=\'\'){2 x=t.E,y=t.D.T,s=\'\';$(\'1m.\'+n.G+\', 1l.\'+n.G,4).1k(n.G);3(x!=L[0]||y!=L[1]){3(n.K!=\'\'){s+=\',.\'+n.K}3(n.J!=\'\'){s+=\',.\'+n.J}3(n.I!=\'\'){s+=\',.\'+n.I}3(s!=\'\'){$(\'1m, 1l\',4).1z(s.1y(1)).18(n.G)}L=[x,y]}1h{L=[-1,-1]}}};2 l=9(a,b){3(b){$.U.M=$.U.18}1h{$.U.M=$.U.1k}2 h=d[a.E]||[],F=[],i=0,7,O;3(n.J!=\'\'){z(n.1a&&++i<a.10&&d[a.E+i]){h=h.14(d[a.E+i])}$(h).M(n.J)}3(n.K!=\'\'){7=a.D.T;3(A[7]){F=F.14(A[7])}i=0;z(n.1e&&++i<a.12){3(A[7+i]){F=F.14(A[7+i])}}$(F).M(n.K)}3(n.I!=\'\'){O=a.D.D.1x.1w();3((O==\'R\'&&n.16)||(O==\'P\'&&n.17)||(O==\'Q\'&&n.15)){$(a).M(n.I)}}};q(4);u(4);6(r=0;r<4.w.8;r++){A[r]=[]}3(4.Y){f(4.Y.w,\'P\')}6(r=0;r<4.H.8;r++){f(4.H[r].w,\'R\')}3(4.W){f(4.W.w,\'Q\')}$(V).1j(\'1v\',g).1j(\'1u\',j).1t(k)})}})(1F);',62,104,'||var|if|tbl|true|for|rI|length|function|||||||||||||||||||||||rows|||while|rowIndex|false|thover|parentNode|realIndex|rH|clickClass|tBodies|cellClass|colClass|rowClass|lastClick|tableHoverHover|cI|nn|THEAD|TFOOT|TBODY|rowI|realRIndex|fn|this|tFoot|row|tHead|cells|colSpan|target|rowSpan|rCnt|concat|footCells|bodyCells|headCells|addClass|ignoreCols|spanCols|footCols|bodyCols|headCols|spanRows|footRows|bodyRows|else|headRows|bind|removeClass|th|td|allowBody|allowHead|push|return|allowFoot|hover|click|mouseout|mouseover|toUpperCase|nodeName|substring|filter|extend|break|inArray|tableHover|each|jQuery'.split('|'),0,{}));
$('#permission_table').tableHover({colClass: 'hover', ignoreCols: [1]}); 


$('#permission_table input:checkbox').change(function() {
	$('#permission_table_result').removeClass();
	$('#permission_table_result').addClass('alert');
	$('#permission_table_result').addClass('alert-info');
	var val = $(this).attr('value');
	var what = $(this).is(':checked');
	var r_name = $(this).closest('td').attr('title');
	var p_name = $(this).closest('tr').attr('title');
	$.post(window.g_url +"/",
			{ "role_perm": val, "action": what }, function(data) {
				var newtext = data.replace(/g_permission/i, '"'+p_name+'"');
				newtext = newtext.replace(/g_role/i, '"'+r_name+'" role');
				if (newtext.search(':') >= 1) {
					$('#permission_table_result').removeClass('alert-info');
					$('#permission_table_result').addClass('alert-warning');
				} else {
					$('#permission_table_result').removeClass('alert-info');
					$('#permission_table_result').addClass('alert-success');
				}
				$('#permission_table_result').text(newtext);
			});
});

// Horizontal Check-all
$('.matrix-title a').click(function(){
	var rows 		= $(this).parents('tr');
	var checked 	= false;
	var found		= false;
	var checkbox	= false;
	
	for (i=0; i < rows.length; i++)
	{
	
		checkbox = $(rows[i]).find(":checkbox");
		
		if(!found && checkbox.length > 0){
			found=true;
			checked = $(checkbox).attr('checked');
		}
		if(checked) {
			checkbox.removeAttr('checked');
		}
		else
		{
			checkbox.attr('checked','checked');
		}
	}
	
	return false;
});

//--------------------------------------------------------------------

// Vertical Check All
$('.matrix th a').click(function(){
	var rows 		= $(this).parents('table').find('tbody tr');;
	var checked 	= false;
	var found		= false;
	var checkbox	= false;
	var columnIndex	= $(this).parent('th').attr('cellIndex');
			
	for (i=0; i < rows.length; i++)
	{
		checkbox = $(rows[i]).find('td:eq('+(columnIndex)+')').find(":checkbox");
		
		if(!found && checkbox.length > 0){
			found=true;
			checked = $(checkbox).attr('checked');
		}
		if(checked) {
			checkbox.removeAttr('checked');
		}
		else
		{
			checkbox.attr('checked','checked');
		}
	}
	
	return false;
});

//--------------------------------------------------------------------
	

