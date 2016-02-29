var netcompare =(function(){

var allWidth = screen.width/2,
     allHeight = screen.height;

// var allWidth = $(window).width()/2,
//     allHeight = $(window).height();

var width = (allWidth<allHeight)?allWidth:allHeight;
    console.group(width);
    console.log(allWidth);
    console.log(allHeight);
    console.groupEnd();
var margin = 20,
    diameter = width,
    margintop = 50;

var view_left,view_right;
var node_left,node_right;
var circle_left,circle_right;
var lines_left,lines_right;
var svgViewer_left = document.getElementById("section1");
var svgViewer_right = document.getElementById("section2");
var location_left = document.getElementById("location1");
var location_right = document.getElementById("location2");

// "./data/subyeast.json"  "./yeastnet.json" ./json/ex0419/yeastnet.json "./json/piswap-yeastnet-sub.json";
//var file_left = "../assets/json/hga-yeastnet.json";
var file_left = $('#jsonleft').attr("value");
//alert(file_left);
//"./data/subhuman.json"  "./humannet.json" ./json/ex0419/humannet-bak.json  "./json/piswap-humannet-sub.json";
//var file_right = "../assets/json/hga-humannet.json";
var file_right = $('#jsonright').attr("value");
//alert(file_right);


//json数据类型
var json_left,json_right;

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

var extend=function(o,n,override){ for(var p in n)if(n.hasOwnProperty(p) && (!o.hasOwnProperty(p) || override))o[p]=n[p]; };
function getNamelist(jsonnode){
    var namelist=new Object();
    if(jsonnode.children!=undefined){
        var children_tmp = jsonnode.children;
        var length = children_tmp.length;
        for (var i = 0; i < length; i++) {
            var new_namelist = getNamelist(children_tmp[i]);
            extend(namelist,new_namelist);
        }
    }
    else{
      namelist[jsonnode.id] = jsonnode.name;
    }
  return namelist;
}

//涉及到另一个图，暂时不考虑
function recordPoint(d,flag){
  var v = view_left,v2 = view_right;
  var k = diameter / v[2]; 
  var k2 = diameter / v2[2]; 
  if(flag=="left"){
    if(d.matched!=-1){
      var node_tmp = svgViewer_left.ownerDocument.getElementById("l_"+d.name);
      var matchenode_tmp = svgViewer_right.ownerDocument.getElementById("r_n_0_"+d.matched);
      var match_d = matchenode_tmp.__data__;
      var location = document.getElementById('location2');
      location.style.top = (match_d.y-margin/2)+"px";
      location.style.left = (match_d.x+diameter-margin/2)+"px";
    }
  }
  if(flag=="right"){
    if(d.matched!=-1){
      var node_tmp = svgViewer_right.ownerDocument.getElementById("r_"+d.name);
      var matchenode_tmp = svgViewer_left.ownerDocument.getElementById("l_n_0_"+d.matched);
      var match_d = matchenode_tmp.__data__;
      var location = document.getElementById('location1');
      location.style.top = (match_d.y-margin/2)+"px";
      location.style.left = (match_d.x-margin/2)+"px";
    }
  }
}


function zoom(d,flag,rank) {
  var focus0 = focus; focus = d;

  var transition = d3.transition()
      .duration(750)
      .tween("zoom", function(d) {
        var i;
        if(flag=="left"){
          i = d3.interpolateZoom(view_left, [focus.x, focus.y, focus.r * 2 + margin]);
          return function(t) { zoomTo(i(t),"left"); };
        }
        else if(flag=="right"){
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
      else if(flag=="left"){
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

var zoomTo = function(v,flag) {
  var k;
  if(flag=="left"){
    k = diameter / v[2]; 
    view_left = v;
  
    node_left.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    lines_left.attr("transform", function(d) {
     return "scale(" + k + ")"+" translate(" + ((d.x1+d.x2)/2*0 - v[0]) * 1 + "," + ((d.y1+d.y2)/2*0 - v[1]) * 1 + ") "; 
    });
    circle_left.attr("r", function(d) { return d.r * k; });


    var locations_left = $(".location[id^='loc_l']");
    locations_left.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    
  }
  else if(flag=="right"){

    k = diameter / v[2]; 
    view_right = v;

    node_right.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    lines_right.attr("transform", function(d) {
     return "scale(" + k + ")"+" translate(" + ((d.x1+d.x2)/2*0 - v[0]) * 1 + "," + ((d.y1+d.y2)/2*0 - v[1]) * 1 + ") "; 
    });
    circle_right.attr("r", function(d) { return d.r * k; });

    var locations_left = $(".location[id^='loc_r']");
    locations_left.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
    
  }

}

var left_root,right_root;
d3.json(file_left, function(error, root) {
  if (error) return console.error(error);
  root_tmp = root;
  root = root.nodes[0];
  var focus = root,
      nodes = pack_left.nodes(root);

  json_left = root_tmp;

  // var parent_left = new subnetcompare();
  //     parent_left.setParam("section1","l_","left","content");
  //     parent_left.renderSub(json_left);

  circle_left = svg_left.selectAll("circle")
      .data(nodes)
      .enter().append("circle")
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
      .attr("id",function(d){return "l_"+d.name;})
      .attr("name",function(d){return d.id;})
      .attr("data_match",function(d){return d.matched;})
      .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
      //.on("click", function(d) { //if (focus !== d)
      //   if(d.name.substring(2,6)=='n_0_'){
      //       // location_left.style.top = (d.y-22)+"px";
      //       // location_left.style.left = (d.x-6)+"px";
      //       // recordPoint(d,"left");
      //       alert(d.matched);
      //       // zoom(d,"left",1), d3.event.stopPropagation(); 
      //   }
      //   else{
      //     zoom(d,"left",1), d3.event.stopPropagation(); 
      //   }
      // })
      .on("mouseover", function(d){
        // location_left.style.top = (d.y-22)+"px";
        // location_left.style.left = (d.x-6)+"px";
        // recordPoint(d,"left");

        if(d.name.substring(2,6)=='n_0_'){
          alert(d.name);
        }

        return tooltip.style("visibility", "visible").text(d.name);
      })
      .on("mousemove", function(d){return tooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
      .on("mouseout", function(){return tooltip.style("visibility", "hidden");});

  var text = svg_left.selectAll("text")
      .data(nodes)
      .enter().append("text")
      .attr("class", "label")
      .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
      .style("display", function(d) { return d.parent === root ? null : "none"; })
      .text(function(d) { return d.id; });

  var links_left = root_tmp.links;
  svg_left.selectAll("line")
    .data(links_left)
    .enter().append("line")
    .attr("class", "link")
    .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
      if(document.getElementById("l_"+link.source)==undefined)
            return 0;
      var match_node1 = document.getElementById("l_"+link.source).__data__;
      link.x1=match_node1.x;
      return match_node1.x;})
    .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(document.getElementById("l_"+link.source)==undefined)
            return 0;
      var match_node1 = document.getElementById("l_"+link.source).__data__;
       link.y1=match_node1.y;
      return match_node1.y;})
    .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(document.getElementById("l_"+link.target)==undefined)
            return 0;
      var match_node1 = document.getElementById("l_"+link.target).__data__;
       link.x2=match_node1.x;
      return match_node1.x;})
    .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
      if(document.getElementById("l_"+link.target)==undefined)
            return 0;
      var match_node1 = document.getElementById("l_"+link.target).__data__;
      link.y2=match_node1.y;
      return match_node1.y;});
  

  node_left = svg_left.selectAll("circle,text");
 
  lines_left= svg_left.selectAll("line");
  d3.select("#content")
      .style("background", color(-1))
      .on("click", function() { zoom(root,"left",1); });


  left_root = root;
  zoomTo([root.x, root.y, root.r * 2 + margin],"left");

});

d3.json(file_right, function(error, root) {
  if (error) return console.error(error);
  root_tmp = root;
  root = root.nodes[0];
  var focus = root,
      nodes = pack_right.nodes(root);
  //var view;

  json_right = root_tmp;
  circle_right = svg_right.selectAll("circle")
      .data(nodes)
    .enter().append("circle")
      .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
      .attr("id",function(d){return "r_"+d.name;})
      .attr("name",function(d){return d.id;})
      .attr("data_match",function(d){return d.matched;})
      .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
      //.on("click", function(d) { //if (focus !== d)
      //  alert(d.name);
      //   if(d.name.substring(2,6)=='n_0_'){
      //       // location_right.style.top = (d.y-22)+"px";
      //       // location_right.style.left = (d.x-6)+diameter+88+"px";
      //       // recordPoint(d,"right");
      //       alert(d.matched);
      //       // zoom(d,"left",1), d3.event.stopPropagation(); 
      //   }
      //   else{
      //     zoom(d,"right",1), d3.event.stopPropagation();
      //   }
      //})
      .on("mouseover", function(d){
        return tooltip.style("visibility", "visible").text(d.name);
      })
      .on("mousemove", function(d){return tooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
      .on("mouseout", function(){return tooltip.style("visibility", "hidden");});

  var text = svg_right.selectAll("text")
      .data(nodes)
    .enter().append("text")
      .attr("class", "label")
      .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
      .style("display", function(d) { return d.parent === root ? null : "none"; })
      .text(function(d) { return d.id; });

 
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


  right_root = root;
  zoomTo([root.x, root.y, root.r * 2 + margin],"right");

  $('#loading').hide();

});



d3.select(self.frameElement).style("height", diameter + "px");


 return {
      //给fma.js提供获取json的方法
      getJSON: function(flag){
        if(flag=="left"){
          return json_left;
        }else{
          return json_right;
        }
      },
      getColor: function(){
        return color;
      },
      zoom,
      zoomTo,
      getNamelist: function(flag){
        var namelist = {};
        var node_tmp;
        if(flag=="left"){
          node_tmp = json_left.nodes;
          namelist = getNamelist(node_tmp[0]);
        }else{
          node_tmp = json_right.nodes;
          namelist = getNamelist(node_tmp[0]);
        }
        return namelist;
      }

  };

})();
