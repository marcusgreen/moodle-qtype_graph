document.getElementById("id_refreshgraph").onclick = function () {
    var graphcode = document.getElementById('id_graphcode');
    var scriptText = graphcode.value;
    var oldScript = document.getElementById('graphdisplay');
    if (oldScript) {
        oldScript.parentNode.removeChild(oldScript);
    }
    var newScript = document.createElement('script');
    newScript.id = 'gcode';
    graphtype=document.getElementById("id_graphtypes");
    newScript.text ="var graph= new RGraph."+graphtype.value+"({id:'cvs',"+ graphcode.value;
    RGraph.Reset(document.getElementById('cvs'));
    document.getElementById("container").appendChild(newScript);
    RGraph.Redraw();
}

    
document.getElementById("id_graphtypes").onchange= function(){
   // el=document.getElementById("id_graphtypes");
   // var graphcodestart ="var obj= new RGraph."+el.value+"({id:'cvs',";    
   // document.body.innerHTML = document.body.innerHTML.replace("/*graphcodestart*/",graphcodestart);
}
