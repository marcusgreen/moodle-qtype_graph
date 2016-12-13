
document.getElementById("id_refreshgraph").onclick=function(){ 
var el = document.getElementById('id_graphcode');
var scriptText = el.value;
var oldScript = document.getElementById('graphdisplay');
var newScript;
  if (oldScript) {
      oldScript.parentNode.removeChild(oldScript);
    }
var newScript = document.createElement('script');
newScript.id = 'gcode';
newScript.text = el.value;
RGraph.Reset(document.getElementById('cvs'));	
document.getElementById("container").appendChild(newScript);
}
