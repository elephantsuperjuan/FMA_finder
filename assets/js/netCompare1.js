
var margin = 20,
    diameter = screen.width/2-5;

var view_left,view_right;
var node_left,node_right;
var circle_left,circle_right;
var lines_left,lines_right;
var svgViewer_left = document.getElementById("section1");
var svgViewer_right = document.getElementById("section2");
var location_left = document.getElementById("location1");
var location_right = document.getElementById("location2");

var color = d3.scale.linear()
    .domain([-1, 5])
    .range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
    .interpolate(d3.interpolateHcl);

var pack_left = d3.layout.pack()
    .padding(2)
    .size([diameter - margin, diameter - margin])
    .value(function(d) { return d.size; });

var pack_right = d3.layout.pack()
    .padding(2)
    .size([diameter - margin, diameter - margin])
    .value(function(d) { return d.size; })

var svg_left = d3.select("#section1").append("svg")
    .attr("id","svg_left")
    .attr("width", diameter)
    .attr("height", diameter)
    .append("g")
    .attr("id","svg_left_g")
    .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");
  
var svg_right = d3.select("#section2").append("svg")
    .attr("id","svg_right")
    .attr("width", diameter)
    .attr("height", diameter)
    .append("g")
    .attr("id","svg_right_g")
    .attr("transform", "translate(" + diameter / 2 + "," + diameter / 2 + ")");

var tooltip = d3.select("#content")
  .append("div")
  .style("position", "absolute")
  .style("z-index", "10")
  .style("visibility", "hidden")
  .text("a simple tooltip");

function ArrToJson(arr) {
        var length = arr.length;
        var json = {};
        for(var i=0;i<length;i++) {
             JSON.stringify(arr[i].toString());
        }
        return json;
    }

function recordPoint(d,flag){
  var v = view_left,v2 = view_right;
  var k = diameter / v[2]; 
  var k2 = diameter / v2[2]; 
  if(flag=="left"){
    if(d.matched!=-1){
      var node_tmp = svgViewer_left.ownerDocument.getElementById("l_"+d.name);
      var matchenode_tmp = svgViewer_right.ownerDocument.getElementById("r_n_0_"+d.matched);
      var match_d = matchenode_tmp.__data__;

      location_right.style.top = match_d.y-22+"px";
      location_right.style.left = match_d.x-6+diameter+88+"px";
    }
  }
  if(flag=="right"){
    if(d.matched!=-1){
      var node_tmp = svgViewer_right.ownerDocument.getElementById("r_"+d.name);
      var matchenode_tmp = svgViewer_left.ownerDocument.getElementById("l_n_0_"+d.matched);
      var match_d = matchenode_tmp.__data__;

      location_left.style.top = match_d.y-22+"px";
      location_left.style.left = match_d.x-6+"px";
    }
  }
}

function zoom(d,flag,rank) {
  var focus0 = focus; focus = d;

  var transition = d3.transition()
      .duration(d3.event.altKey ? 7500 : 750)
      .tween("zoom", function(d) {
        var i;
        if(flag=="left"){
          i = d3.interpolateZoom(view_left, [focus.x, focus.y, focus.r * 2 + margin]);
          return function(t) { zoomTo(i(t),"left"); };
        }
        else{
          i = d3.interpolateZoom(view_right, [focus.x, focus.y, focus.r * 2 + margin]);
          return function(t) { zoomTo(i(t),"right"); };
        }
      });

  transition.selectAll("text")
      .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
      .style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
      .each("start", function(d) { if (d.parent === focus) this.style.display = "inline"; })
      .each("end", function(d) { if (d.parent !== focus) this.style.display = "none"; });

  if(d.matched!=-1 && rank==1){
      var str_match = 'n_0_'+d.matched.toString();
      //alert(str_match);
      var match_node,flag_pos,node_pos,circle_pos;
      var svgViewer;
      if(flag=="right"){
        svgViewer = svgViewer_left;
        match_node = svgViewer.ownerDocument.getElementById("l_"+str_match).__data__;
        flag_pos = "left";
      }
      else{
        svgViewer = svgViewer_right;
        match_node = svgViewer.ownerDocument.getElementById("r_"+str_match).__data__;
        //match_node = d3.select("#section2").select("#"+str_match);
        flag_pos = "right";
      }
      console.log(match_node);
      console.log(d);
      zoom(match_node,flag_pos,2);
    }
}

function zoomTo(v,flag) {
  var k = diameter / v[2]; 

  if(flag=="left"){
    view_left = v;
    var locations_left = svg_left.selectAll(".location");

    locations_left.attr("transform", function(d) { return "translate(" + (d.left - v[0]) * k + "," + (d.top - v[1]) * k + ")"; });
    node_left.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    lines_left.attr("transform", function(d) {
     return "scale(" + k + ")"+" translate(" + ((d.x1+d.x2)/2*0 - v[0]) * 1 + "," + ((d.y1+d.y2)/2*0 - v[1]) * 1 + ") "; 
    });
    circle_left.attr("r", function(d) { return d.r * k; });
  }
  else{
    view_right = v;
    node_right.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    lines_right.attr("transform", function(d) {
     return "scale(" + k + ")"+" translate(" + ((d.x1+d.x2)/2*0 - v[0]) * 1 + "," + ((d.y1+d.y2)/2*0 - v[1]) * 1 + ") "; 
    });
    circle_right.attr("r", function(d) { return d.r * k; });
  }
}

d3.json("./yeastnet.json", function(error, root) {
  if (error) return console.error(error);
  root_tmp = root;
  root = root.nodes[0];
  var focus = root,
      nodes = pack_left.nodes(root);
  
  circle_left = svg_left.selectAll("circle")
      .data(nodes)
      .enter().append("circle")
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
      .attr("id",function(d){return "l_"+d.name;})
      .attr("name",function(d){return d.name;})
      .attr("data_match",function(d){return d.matched;})
      .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
      .on("click", function(d) { //if (focus !== d)
        if(d.name.substring(0,4)=='n_0_'){
            location_left.style.top = (d.y-22)+"px";
            location_left.style.left = (d.x-6)+"px";
            recordPoint(d,"left");
            alert(d.matched);
            zoom(d,"left",1), d3.event.stopPropagation(); 
        }
        else{
          zoom(d,"left",1), d3.event.stopPropagation(); 
        }
       })
      .on("mouseover", function(d){
        location_left.style.top = (d.y-22)+"px";
        location_left.style.left = (d.x-6)+"px";
        recordPoint(d,"left");
        return tooltip.style("visibility", "visible").text(d.name);})
      .on("mousemove", function(d){return tooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
      .on("mouseout", function(){return tooltip.style("visibility", "hidden");});

  var text = svg_left.selectAll("text")
      .data(nodes)
      .enter().append("text")
      .attr("class", "label")
      .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
      .style("display", function(d) { return d.parent === root ? null : "none"; })
      .text(function(d) { return d.name; });

  var links_left = root_tmp.links;
  svg_left.selectAll("line")
    .data(links_left)
    .enter().append("line")
    .attr("class", "link")
    .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
      if(svgViewer_left.ownerDocument.getElementById("l_"+link.source)==undefined)
            return 0;
      var match_node1 = svgViewer_left.ownerDocument.getElementById("l_"+link.source).__data__;
      link.x1=match_node1.x;
      return match_node1.x;})
    .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(svgViewer_left.ownerDocument.getElementById("l_"+link.source)==undefined)
            return 0;
      var match_node1 = svgViewer_left.ownerDocument.getElementById("l_"+link.source).__data__;
       link.y1=match_node1.y;
      return match_node1.y;})
    .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(svgViewer_left.ownerDocument.getElementById("l_"+link.target)==undefined)
            return 0;
      var match_node1 = svgViewer_left.ownerDocument.getElementById("l_"+link.target).__data__;
       link.x2=match_node1.x;
      return match_node1.x;})
    .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(svgViewer_left.ownerDocument.getElementById("l_"+link.target)==undefined)
            return 0;
      var match_node1 = svgViewer_left.ownerDocument.getElementById("l_"+link.target).__data__;
      link.y2=match_node1.y;
      return match_node1.y;});
  

  node_left = svg_left.selectAll("circle,text");
 
  lines_left= svg_left.selectAll("line");
  d3.select("#content")
      .style("background", color(-1))
      .on("click", function() { zoom(root,"left",1); });

  zoomTo([root.x, root.y, root.r * 2 + margin],"left");

});

d3.json("./humannet-sm.json", function(error, root) {
  if (error) return console.error(error);
  root_tmp = root;
  root = root.nodes[0];
  var focus = root,
      nodes = pack_right.nodes(root);
  //var view;

  circle_right = svg_right.selectAll("circle")
      .data(nodes)
    .enter().append("circle")
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
      .attr("id",function(d){return "r_"+d.name;})
      .attr("name",function(d){return d.name;})
      .attr("data_match",function(d){return d.matched;})
      .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
      .on("click", function(d) { //if (focus !== d)
        if(d.name.substring(0,4)=='n_0_'){
            location_right.style.top = (d.y-22)+"px";
            location_right.style.left = (d.x-6)+diameter+88+"px";
            recordPoint(d,"right");
        }
        else{
          zoom(d,"right",1), d3.event.stopPropagation();
        }
      })
      .on("mouseover", function(d){
        location_right.style.top = (d.y-22)+"px";
        location_right.style.left = (d.x-6)+diameter+88+"px";
        recordPoint(d,"right");
        return tooltip.style("visibility", "visible").text(d.name);})
      .on("mousemove", function(d){return tooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
      .on("mouseout", function(){return tooltip.style("visibility", "hidden");});

  var text = svg_right.selectAll("text")
      .data(nodes)
    .enter().append("text")
      .attr("class", "label")
      .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
      .style("display", function(d) { return d.parent === root ? null : "none"; })
      .text(function(d) { return d.name; });

 
  var links_right = new Array();
  links_right = root_tmp.links;
  svg_right.selectAll("line")
  .data(links_right)
  .enter().append("line")
  .attr("class", "link")
  .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section2");
    if(svgViewer_right.ownerDocument.getElementById("r_"+link.source)==undefined)
          return 0;
    var match_node1 = svgViewer_right.ownerDocument.getElementById("r_"+link.source).__data__;
    link.x1=match_node1.x;
    return match_node1.x;})
  .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section2");
    if(svgViewer_right.ownerDocument.getElementById("r_"+link.source)==undefined)
          return 0;
    var match_node1 = svgViewer_right.ownerDocument.getElementById("r_"+link.source).__data__;
     link.y1=match_node1.y;
    return match_node1.y;})
  .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section2");
    if(svgViewer_right.ownerDocument.getElementById("r_"+link.target)==undefined)
          return 0;
    var match_node1 = svgViewer_right.ownerDocument.getElementById("r_"+link.target).__data__;
     link.x2=match_node1.x;
    return match_node1.x;})
  .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section2");
    if(svgViewer_right.ownerDocument.getElementById("r_"+link.target)==undefined)
          return 0;
    var match_node1 = svgViewer_right.ownerDocument.getElementById("r_"+link.target).__data__;
     link.y2=match_node1.y;
    return match_node1.y;});

 node_right = svg_right.selectAll("circle,text");
 
  lines_right= svg_right.selectAll("line");
  d3.select("#content")
      .style("background", color(-1))
      .on("click", function() { zoom(root,"right",1); });

  zoomTo([root.x, root.y, root.r * 2 + margin],"right");

});

d3.select(self.frameElement).style("height", diameter + "px");
