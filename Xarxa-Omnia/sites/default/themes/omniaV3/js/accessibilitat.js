<!-- funcions dels botons d'accessibilitat -->

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}



<!-- Funcions Augmentar i disminuir text de la web -->

function zoomText(Accion,Elemento){
//inicializacion de variables y parámetros
var obj=document.getElementById(Elemento);
var max = 200 //tamaño máximo del fontSize
var min = 70 //tamaño mínimo del fontSize
if (obj.style.fontSize==""){
obj.style.fontSize="100%";
}
actual=parseInt(obj.style.fontSize); //valor actual del tamaño del texto
incremento=10;// el valor del incremento o decremento en el tamaño

//accion sobre el texto
if( Accion=="reestablecer" ){
obj.style.fontSize="100%"
}
if( Accion=="aumentar" && ((actual+incremento) <= max )){
valor=actual+incremento;
obj.style.fontSize=valor+"%"
}
if( Accion=="disminuir" && ((actual+incremento) >= min )){
valor=actual-incremento;
obj.style.fontSize=valor+"%"
}
}