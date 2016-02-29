<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="JS代码,侧边菜单,拉出菜单,高级菜单,导航菜单,jquery菜单" />
<meta name="description" content="jQuery高级可停靠侧边栏" />
<title>FMAfinder</title><base target="_blank" />
<link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>" />
<link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/keleyidock.css') ?>" />
<link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/netCompare.css') ?>" />
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/nav.js') ?>"></script>
<style>
    .modal-lg{
        width:100%;
    }
</style>
</head>
<body>
<ul id="dock">
    <li id="links">
        <ul class="free">
            <li class="header">
                <a href="javascript:;" class="dock-keleyi-com" target="_self">固定</a>
                <a href="javascript:;" class="undock">隐藏</a>链接
            </li>
            <li id="searchNode">Search Node</li>
            <li id="filterNode">Filter Network</li>
            <li id="filterGO">Filter GO Network</li>
        </ul>
    </li>
</ul>

<div id="content" style="width:100%;height:100%;">
    <div id="location1" class="location" ></div>
    <div id="location2" class="location" ></div>
    <div id="section1" style="height:100%;float:left;width:50%;">
    </div>
    <div id="section2" style="height:100%;float:left;width:50%;">
    </div>
</div>
    <textarea id="json1" cols="10" rows="10" style="display:none;"></textarea>
    <textarea id="json2" cols="10" rows="10" style="display:none;"></textarea> 

    <input id="jsonleft" value="<?php echo $net1 ?>" type="hidden"/>
    <input id="jsonright" value="<?php echo $net2 ?>" type="hidden"/> 
    
<div style="text-align:center;clear:both;position:fixed;bottom:0px;left:20%;">
<p>Author:<a href="#" target="_blank">Choajuan Xiang</a>  Email:<a href="mailto:#">cjxiang@shu.edu.cn </a> Contact:<a href="mailto:#">jiangx@shu.edu.cn </a> </p>
<p>&copy; School of Computer Engineering and Science, Shanghai University. All rights reserved. 
Address: 99 Shangda Road, BaoShan District, Shanghai. Zip Code:200444.</p>
</div>
</body>
</html>

<div class="modal" id="searchNodeModal" tabindex="-1" role="dialog" aria-labelledby="searchNodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="searchNodeModalLabel">Search Node</h4>
      </div>
      <form id="searchNode_form" >
        <div class="modal-body">
          <div class="form-group">
            <label for="nodename" class="control-label">Node name:</label>
            <input type="text" class="form-control" id="nodename">
          </div>
          <div class="form-group">
            <label for="networkflag" class="control-label">Network:</label>
            <select class="form-control" id="networkflag">
              <option value="left">left</option>
              <option value="right">right</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="searchNode_ok">Send message</button>
        </div>
       </form>
    </div>
  </div>
</div>

<div class="modal" id="filterNodeModal" tabindex="-1" role="dialog" aria-labelledby="filterNodeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="filterNodeModalLabel">Filter Node</h4>
      </div>
      <form id="filterNode_form" >
        <div class="modal-body row">
          <div class="form-group col-md-5 col-md-offset-1">
            <label for="nodelist1" class="control-label">Node list in Network1:</label>
            <textarea class="form-control" id="nodelist1" rows="5"></textarea>
          </div>
          <div class="form-group col-md-5">
            <label for="nodelist2" class="control-label">Node list in Network2:</label>
            <textarea class="form-control" id="nodelist2" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="filterNode_ok">Send message</button>
        </div>
       </form>
    </div>
  </div>
</div>

<div class="modal" id="filterNetworkModal" tabindex="-1" role="dialog" aria-labelledby="filterNetworkModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="filterNetworkModalLabel">Filter Network</h4>
      </div>
      <form id="filterNetwork_form" >
        <div class="modal-body row" id="subcontent">
          <div class="form-group col-md-6" id="subnetwork1"></div>
          <div class="form-group col-md-6" id="subnetwork2"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
       </form>
    </div>
  </div>
</div>

<div class="modal" id="filterGOlistModal" tabindex="-1" role="dialog" aria-labelledby="filterGOlistModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="filterNodeModalLabel">Filter Node</h4>
      </div>
      <form id="filterGOlist_form" >
        <div class="modal-body row">
          <div class="form-group col-md-10 col-md-offset-1">
            <label for="golist" class="control-label">GO list:</label>
            <textarea class="form-control" id="golist" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="filterGOlist_ok">Send message</button>
        </div>
       </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/d3/d3.js') ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/d3/json.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/netCompare-0506.js') ?>"></script>
<script type="text/javascript">

function findList(name,nodelist){
    //0 false;1 true;-1 new;
    for(var key in nodelist) {
        if(key==name){
            return nodelist[key];
        }
    };
    return 0;
}

//栈列表 stacklist,用于深度遍历树时记录搜索记录
//栈顶序号,用作栈顶指针
var stackList = [];
var stackList_head = -1;

function traverseNode(jsonnode,nodelist){
    if(jsonnode.children){
        var children_tmp = jsonnode.children;
        var length = children_tmp.length;
        for (var i = 0; i < length; i++) {
            stackList.push(children_tmp[i]);
            if(children_tmp[i].children){
                traverseNode(children_tmp[i],nodelist);
            }
            else{
                if(findList(children_tmp[i].name,nodelist)==0){
                    // delete children_tmp[i];
                    children_tmp.splice(i,1);
                    i--;
                    length--;
                }
                else{
                    if(nodelist[children_tmp[i].name]==-1){
                        children_tmp[i].color='#eee';
                    }
                }
            }
        }
        if(jsonnode.children.length==0){
            jsonnode.children=undefined;
        }
    }
    else{
        if(findList(jsonnode,nodelist)==0){
            jsonnode = undefined;
        }
    }
}

function traverseLink(jsonlink,nodelist){
    var length = jsonlink.length;
    for (var i = 0; i < length; i++) {
        var sourceflag = findList(jsonlink[i].source,nodelist);
        var targetflag = findList(jsonlink[i].target,nodelist);
        if(sourceflag==1){
            if(findList(jsonlink[i].target,nodelist)==0)
                nodelist[jsonlink[i].target]=-1;
        }
        else if(targetflag==1){
            if(findList(jsonlink[i].source,nodelist)==0)
                nodelist[jsonlink[i].source]=-1;
        }
        else if((sourceflag==0) || (targetflag==0)){
            // delete jsonlink[i];
            jsonlink.splice(i,1);
            i--;
            length--;
        }
    };
    return jsonlink;
}

function filterJson(jsonall,nodelist){
    var nodes_tmp = jsonall.nodes;
    var links_tmp = jsonall.links;
    var sublinks_tmp = traverseLink(links_tmp,nodelist);
    var subnodes_tmp = nodes_tmp[0];
    //遍历之前把栈清空,并将根节点入栈
    stackList = [];
    stackList.push(subnodes_tmp);
    stackList_head = 0;

    traverseNode(subnodes_tmp,nodelist);
    var jsonall_tmp = {};
    var subnodes_array = [];
    subnodes_array.push(subnodes_tmp);
    jsonall_tmp.nodes = subnodes_array;
    jsonall_tmp.links = sublinks_tmp;
    return jsonall_tmp;
}

function findNodebyGO(golist,gotarget){
    for (var i = 0; i < gotarget.length; i++) {
        for (var j = 0; j < golist.length; j++) {
            if(gotarget[i] == golist[j]){
                return true;
            }
        };
    };
    return false;
}
var json1_text = document.getElementById('json1');
var json2_text = document.getElementById('json2');
function nodeString(nodes_object,flag,isfirst){
    var isfirst = arguments[2] ? arguments[2] : false;
    var str;
    var json_text;
    var str_head='';
    if(!isfirst)
        str_head = ',';

    if(flag=="left"){
        json_text = json1_text;
    }
    else{
        json_text = json2_text;
    }
    if(!nodes_object.hasOwnProperty('children')){
        str = str_head+'{"name":"'+nodes_object.name+'","id":"'+nodes_object.id+'","size": 3812,"matched":"'+nodes_object.matched+'","color":"'+nodes_object.color+'"}';
        json_text.innerText = json_text.value + str;
    }else if(nodes_object.children==undefined){
        str = str_head+'{"name":"'+nodes_object.name+'","matched":"-1",\n"children":[]}';
        json_text.innerText = json_text.value + str;
    }else if(nodes_object.children.length>0){
        str = str_head+'{"name":"'+nodes_object.name+'","matched":"-1",\n"children":[';
        json_text.innerText = json_text.value + str;
        var children_tmp = nodes_object.children;
        for (var i = 0; i < children_tmp.length; i++) {
            if(i==0)
                nodeString(children_tmp[i],flag,true);
            else
                nodeString(children_tmp[i],flag);
            // document.getElementById('json1').innerText = document.getElementById('json1').value + str;
        };
        str =']}';
        json_text.innerText = json_text.value + str;
    }
    else if(nodes_object.children.length==0){
        str = str_head+'{"name":"'+nodes_object.name+'","matched":"-1",\n"children":[]}';
        json_text.innerText = json_text.value + str;
    }
}
function linkString(links_object,str){
    for (var i = 0; i < links_object.length; i++) {
        if(i==0)
            str += '{"name":"'+links_object[i].name+'","source":"'+links_object[i].source+'","target":"'+links_object[i].target+'"}';
        else
            str += ',{"name":"'+links_object[i].name+'","source":"'+links_object[i].source+'","target":"'+links_object[i].target+'"}';
    };
    return str;
}
function jsonString(m_json,flag){
    var nodes = m_json.nodes;
    var links = m_json.links;
    var json_text;
    if(flag=="left"){
        json_text = json1_text;
    }
    else{
        json_text = json2_text;
    }
    var nodes_str = '{"nodes":[';
    json_text.innerText = json_text.value + nodes_str;
    nodeString(nodes[0],flag,true);
    nodes_str = '],';
    json_text.innerText = json_text.value + nodes_str;
    var links_str = '"links":[';
    links_str = linkString(links,links_str);
    links_str += ']}';
    json_text.innerText = json_text.value + links_str;
    // return nodes_str+links_str;
}

function filterNodePosition_left(value){
    var id_flag = value.id.substring(0,2);
    if(id_flag=='l_')
        return true;
    else
        return false;
}
function filterNodePosition_right(value){
    var id_flag = value.id.substring(0,2);
    if(id_flag=='r_')
        return true;
    else
        return false;
}

 $(document).ready(function () {

    $('#filterNetworkModal').on('hidden.bs.modal', function (e){
        subview_left=subview_right=subnode_left=subnode_right=subcircle_left=subcircle_right=sublines_left=sublines_right=null;
    });

    $('#searchNode').click(function(){
        $('#searchNodeModal').modal('show');
    });
    $('#searchNode_form').submit(function(){return false;});
    $('#searchNode_ok').click(function(){
        $('#searchNodeModal').modal('hide');
        var name = $('#nodename').val();
        var networkflag = $('#networkflag').val();
        if(name!=""){
            if(networkflag=='left'){
                var node_tmp = svgViewer_left.ownerDocument.getElementsByName(name).item(filterNodePosition_left).__data__;
                if(node_tmp==undefined){
                    alert("name not valid in left");
                    return false;
                }
                var newDiv = document.createElement('div');
                newDiv.setAttribute("id", "location_left" + name); 
                newDiv.setAttribute("class", "location"); 
                newDiv.style.top=(node_tmp.y-22)+"px";
                newDiv.style.left=(node_tmp.x-6)+"px";
                // var attrArray=new Array();
                // attrArray["top"]=(node_tmp.y-22)+"px";
                // attrArray["left"]=(node_tmp.x-6)+"px";
                // newDiv.datum(attrArray);
                $('#content').append(newDiv);
                return true;
            } 
            else{
                var node_tmp = svgViewer_right.ownerDocument.getElementsByName(name).item(filterNodePosition_right).__data__;
                if(node_tmp==undefined){
                    alert("name not valid in left");
                    return false;
                }
                var newDiv = document.createElement('div');
                newDiv.setAttribute("id", "location_right" + name); 
                newDiv.setAttribute("class", "location"); 
                newDiv.style.top=node_tmp.y-22+"px";
                newDiv.style.left=node_tmp.x-6+diameter+88+"px";
                // var attrArray=new Array();
                // attrArray["top"]=node_tmp.y-22+"px";
                // attrArray["left"]=node_tmp.x-6+diameter+88+"px";
                // newDiv.datum(attrArray);
                $('#content').append(newDiv);
                return true;
            }
        }
        else{
            alert("name not valid");
        }
        // recordPoint(name,networkflag);
        return false;
    });
        
    
    $('#filterNode').click(function(){
        $('#filterNodeModal').modal('show');
    });
    $('#filterNode_form').submit(function(){return false;});
    $('#filterNode_ok').click(function(){
        $('#filterNodeModal').modal('hide');
        var nodelist1 = $('#nodelist1').val().split('\n');
        var nodelist2 = $('#nodelist2').val().split('\n'); 
        if(nodelist1.length==0&&nodelist2.length==0){
            alert("These two nodelists should not be both empty!");
            return false;
        }else if(nodelist1.length==0){
            alert("left network is empty!");
            for(var i=0;i<nodelist2.length;i++){
                nodelist1[i]='';
            }
        }else if(nodelist2.length==0){
            alert("right network is empty!");
            for(var i=0;i<nodelist1.length;i++){
                nodelist2[i]='';
            }
        }else{
            alert("list ok");
        }
        var listlength = (nodelist1.length>nodelist2.length)?nodelist1.length:nodelist2.length;
        for (var i = 0,k=0; k <listlength; i++,k++) {
            if((nodelist1[i]=='' || nodelist1[i]==undefined)&& (nodelist2[i]=='' ||nodelist2[i]==undefined)){
               nodelist1.splice(i,1);
               nodelist2.splice(i,1);
               i=i-1;
            }
            else if(nodelist2[i]=='' || nodelist2[i]==undefined){
                var node_tmp_left = svgViewer_left.ownerDocument.getElementsByName(nodelist1[i]).item(filterNodePosition_left);
                if(node_tmp_left==null){
                    alert(nodelist1[i]+"not in left network!");
                    return false;
                }
                else{
                    nodelist1[i]=node_tmp_left.__data__.name;
                    nodelist2[i]="n_0_"+node_tmp_left.__data__.matched;
                }
            }
            else if(nodelist1[i]==''  || nodelist1[i]==undefined){
                var node_tmp_right = svgViewer_right.ownerDocument.getElementsByName(nodelist2[i]).item(filterNodePosition_right);
                if(node_tmp_right==null){
                    alert(nodelist2[i]+"not in right network!");
                    return false;
                }
                else{
                    nodelist1[i]="n_0_"+node_tmp_right.__data__.matched;
                    nodelist2[i]=node_tmp_right.__data__.name;
                }
            }
            else{
                // alert("both ok");
            }
            // console.log(nodelist1[i]+" "+nodelist2[i]);
        };


        $('#filterNetworkModal').modal('show');
        json1_text.innerText="";
        json2_text.innerText="";

        var jsonsub_left={}, jsonsub_right={};
        var nodeArray1 = {},nodeArray2 = {};
        for (var i = 0; i < nodelist1.length; i++) {
            nodeArray1[nodelist1[i]]=1;
        };
        for (var i = 0; i < nodelist2.length; i++) {
            nodeArray2[nodelist2[i]]=1;
        };
        jsonsub_left = filterJson(json_left,nodeArray1);
        jsonsub_right = filterJson(json_right,nodeArray2);
        
        jsonString(jsonsub_left,"left");
        jsonString(jsonsub_right,"right");
        var subpack_left = d3.layout.pack()
            .padding(2)
            .size([subdiameter - submargin, subdiameter - submargin])
            .value(function(d) { return d.size; });

        var subpack_right = d3.layout.pack()
            .padding(2)
            .size([subdiameter - submargin, subdiameter - submargin])
            .value(function(d) { return d.size; });


        var svg_tmp1 = document.getElementById("subnetwork1");
        if(svg_tmp1.hasChildNodes()){
            svg_tmp1.firstChild.remove();
        }
        var svg_tmp2 = document.getElementById("subnetwork2");
        if(svg_tmp2.hasChildNodes()){
            svg_tmp2.firstChild.remove();
        }
        // $('#subnetwork1').innerHTML = jsonString(jsonsub_left);
        // $('#subnetwork2').innerHTML = jsonString(jsonsub_right);
        var subsvg_left = d3.select("#subnetwork1").append("svg")
                .attr("id","subsvg_left")
                .attr("width", subdiameter)
                .attr("height", subdiameter)
                .append("g")
                .attr("id","subsvg_left_g")
                .attr("transform", "translate(" + subdiameter / 2 + "," + subdiameter / 2 + ")");
        
        var subsvg_right = d3.select("#subnetwork2").append("svg")
                .attr("id","subsvg_right")
                .attr("width", subdiameter)
                .attr("height", subdiameter)
                .append("g")
                .attr("id","subsvg_right_g")
                .attr("transform", "translate(" + subdiameter / 2 + "," + subdiameter / 2 + ")");
        
        var subtooltip = d3.select("#subcontent")
                .append("div")
                .attr("id","subtooltip")
                .style("position", "absolute")
                .style("z-index", "10")
                .style("visibility", "hidden")
                .text("a simple tooltip");

        var subleft_root = jsonsub_left.nodes[0];
        var subleft_focus = subleft_root,
            subleft_nodes = subpack_left.nodes(subleft_root);
        subcircle_left = subsvg_left.selectAll("circle")
          .data(subleft_nodes)
          .enter().append("circle")
          .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
          .attr("id",function(d){return "subl_"+d.name;})
          .attr("name",function(d){return d.id;})
          .attr("data_match",function(d){return d.matched;})
          .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
          .on("click", function(d) { //if (focus !== d)
            alert(d.matched);
            zoom(d,"subleft",1), d3.event.stopPropagation(); 
           })
          .on("mouseover", function(d){
            return subtooltip.style("visibility", "visible").text(d.name);
          })
          .on("mousemove", function(d){return subtooltip.style("top", (event.pageY-15)+"px").style("left",(event.pageX+15)+"px").text(d.name);})
          .on("mouseout", function(){return subtooltip.style("visibility", "hidden");});

        var subtext = subsvg_left.selectAll("text")
          .data(subleft_nodes)
          .enter().append("text")
          .attr("class", "label")
          .style("fill-opacity", function(d) { return d.parent === subleft_root ? 1 : 0; })
          .style("display", function(d) { return d.parent === subleft_root ? null : "none"; })
          .text(function(d) { return d.id; });

        var sublinks_left = jsonsub_left.links;
        subsvg_left.selectAll("line")
            .data(sublinks_left)
            .enter().append("line")
            .attr("class", "link")
            .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source).__data__;
              link.x1=match_node1.x;
              return match_node1.x;})
            .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source).__data__;
               link.y1=match_node1.y;
              return match_node1.y;})
            .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target).__data__;
               link.x2=match_node1.x;
              return match_node1.x;})
            .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target).__data__;
              link.y2=match_node1.y;
              return match_node1.y;});

        subnode_left = subsvg_left.selectAll("circle,text");

        sublines_left= subsvg_left.selectAll("line");
        d3.select("#subcontent")
           .style("background", color(-1))
            .on("click", function() { zoom(subleft_root,"subleft",1); });

        zoomTo([subleft_root.x, subleft_root.y, subleft_root.r * 2 + submargin],"subleft");


        //subright svg
        var subright_root = jsonsub_right.nodes[0];
        var subright_focus = subright_root,
            subright_nodes = subpack_right.nodes(subright_root);
        subcircle_right = subsvg_right.selectAll("circle")
          .data(subright_nodes)
          .enter().append("circle")
          .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
          .attr("id",function(d){return "subr_"+d.name;})
          .attr("name",function(d){return d.id;})
          .attr("data_match",function(d){return d.matched;})
          .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
          .on("click", function(d) { //if (focus !== d)
            alert(d.matched);
            zoom(d,"subright",1), d3.event.stopPropagation(); 
           })
          .on("mouseover", function(d){
            return subtooltip.style("visibility", "visible").text(d.name);
          })
          .on("mousemove", function(d){return subtooltip.style("top", (event.pageY-15)+"px").style("left",(event.pageX+15)+"px").text(d.name);})
          .on("mouseout", function(){return subtooltip.style("visibility", "hidden");});

        var subtext = subsvg_right.selectAll("text")
          .data(subright_nodes)
          .enter().append("text")
          .attr("class", "label")
          .style("fill-opacity", function(d) { return d.parent === subright_root ? 1 : 0; })
          .style("display", function(d) { return d.parent === subright_root ? null : "none"; })
          .text(function(d) { return d.id; });

        var sublinks_right = jsonsub_right.links;
        subsvg_right.selectAll("line")
            .data(sublinks_right)
            .enter().append("line")
            .attr("class", "link")
            .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source).__data__;
              link.x1=match_node1.x;
              return match_node1.x;})
            .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source).__data__;
               link.y1=match_node1.y;
              return match_node1.y;})
            .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target).__data__;
               link.x2=match_node1.x;
              return match_node1.x;})
            .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
              if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target)==undefined)
                    return 0;
              var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target).__data__;
              link.y2=match_node1.y;
              return match_node1.y;});

        subnode_right = subsvg_right.selectAll("circle,text");

        sublines_right= subsvg_right.selectAll("line");
        d3.select("#subcontent")
           .style("background", color(-1))
            .on("click", function() { zoom(subright_root,"subright",1); });

        zoomTo([subright_root.x, subright_root.y, subright_root.r * 2 + submargin],"subright");



        return false;
    });


    $('#filterGO').click(function(){
        $('#filterGOlistModal').modal('show');
    });
    $('#filterGOlist_form').submit(function(){return false;});
    $('#filterGOlist_ok').click(function(){
        $('#filterGOlistModal').modal('hide');
        var golist = $('#golist').val().split('\n'); 
        if(golist.length==0){
            alert("GO list should not be empty!");
            return false;
        }

        $('#filterNetworkModal').modal('show');

        var jsonsub_left={}, jsonsub_right={};
        var nodeArray1 = {},nodeArray2 = {};
        var nodelist1 = [] ,nodelist2 = [];

        d3.json('./assets/data/yeastGolist.json', function(error, root) {
            if (error) return console.error(error);
            var nodes = root.nodes;
            console.log(nodes);
            for (var i = 0; i < nodes.length; i++) {
                var gotarget = nodes[i].go;
                for (var j = 0; j < golist.length; j++) {
                    if(gotarget.indexOf(golist[j])!=-1){
                        nodelist1.push(nodes[i]); 
                        break;
                    }
                }
            }
            for (var i = 0; i < nodelist1.length; i++) {
                nodeArray1["n_0_"+nodelist1[i].id]=1;
            };
            jsonsub_left = filterJson(json_left,nodeArray1);

            var subpack_left = d3.layout.pack()
                .padding(2)
                .size([subdiameter - submargin, subdiameter - submargin])
                .value(function(d) { return d.size; });

            // var svg_tmp = document.getElementById("subnetwork1");
            // if(svg_tmp.childNodes[0]){
            //     svg_tmp.remove(svg_tmp.childNodes[0]);
            // }
            var svg_tmp = document.getElementById("subnetwork1");
            if(svg_tmp.hasChildNodes()){
                svg_tmp.firstChild.remove();
            }
            
            var subsvg_left = d3.select("#subnetwork1").append("svg")
                .attr("id","subsvg_left")
                .attr("width", subdiameter)
                .attr("height", subdiameter)
                .append("g")
                .attr("id","subsvg_left_g")
                .attr("transform", "translate(" + subdiameter / 2 + "," + subdiameter / 2 + ")");
            
            var subleft_root = jsonsub_left.nodes[0];
            var subleft_focus = subleft_root,
                subleft_nodes = subpack_left.nodes(subleft_root);
            subcircle_left = subsvg_left.selectAll("circle")
              .data(subleft_nodes)
              .enter().append("circle")
              .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
              .attr("id",function(d){return "subl_"+d.name;})
              .attr("name",function(d){return d.id;})
              .attr("data_match",function(d){return d.matched;})
              .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
              .on("click", function(d) { //if (focus !== d)
                alert(d.matched);
                zoom(d,"subleft",1), d3.event.stopPropagation(); 
               })
              .on("mouseover", function(d){
                return subtooltip.style("visibility", "visible").text(d.name);
              })
              .on("mousemove", function(d){return subtooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
              .on("mouseout", function(){return subtooltip.style("visibility", "hidden");});

            var subtext_left = subsvg_left.selectAll("text")
              .data(subleft_nodes)
              .enter().append("text")
              .attr("class", "label")
              .style("fill-opacity", function(d) { return d.parent === subleft_root ? 1 : 0; })
              .style("display", function(d) { return d.parent === subleft_root ? null : "none"; })
              .text(function(d) { return d.id; });

            var sublinks_left = jsonsub_left.links;
            subsvg_left.selectAll("line")
                .data(sublinks_left)
                .enter().append("line")
                .attr("class", "link")
                .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source).__data__;
                  link.x1=match_node1.x;
                  return match_node1.x;})
                .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.source).__data__;
                   link.y1=match_node1.y;
                  return match_node1.y;})
                .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target).__data__;
                   link.x2=match_node1.x;
                  return match_node1.x;})
                .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_left.ownerDocument.getElementById("subl_"+link.target).__data__;
                  link.y2=match_node1.y;
                  return match_node1.y;});

            subnode_left = subsvg_left.selectAll("circle,text");

            sublines_left= subsvg_left.selectAll("line");
            d3.select("#subcontent")
               .style("background", color(-1))
                .on("click", function() { zoom(subleft_root,"subleft",1); });

            zoomTo([subleft_root.x, subleft_root.y, subleft_root.r * 2 + submargin],"subleft");

        });


        // nodelist1 = filterNodeByGO(golist,'./data/yeastGolist.json');
        // nodelist2 = filterNodeByGO(golist,'./data/humanGOlist.json');

        d3.json('./assets/data/humanGolist.json', function(error, root) {
            if (error) return console.error(error);
            var nodes = root.nodes;
            console.log(nodes);
            for (var i = 0; i < nodes.length; i++) {
                var gotarget = nodes[i].go;
                for (var j = 0; j < golist.length; j++) {
                    if(gotarget.indexOf(golist[j])!=-1){
                        nodelist2.push(nodes[i]); 
                        break;
                    }
                }
            }
            for (var i = 0; i < nodelist2.length; i++) {
                nodeArray2["n_0_"+nodelist2[i].id]=1;
            };
            jsonsub_right = filterJson(json_right,nodeArray2);
            var subpack_right = d3.layout.pack()
                .padding(2)
                .size([subdiameter - submargin, subdiameter - submargin])
                .value(function(d) { return d.size; });

            // var svg_tmp = document.getElementById("subnetwork2");
            // if(svg_tmp.childNodes[0]){
            //     svg_tmp.remove(svg_tmp.childNodes[0]);
            // }
            var svg_tmp = document.getElementById("subnetwork2");
            if(svg_tmp.hasChildNodes()){
                svg_tmp.firstChild.remove();
            }
            var subsvg_right = d3.select("#subnetwork2").append("svg")
                    .attr("id","subsvg_right")
                    .attr("width", subdiameter)
                    .attr("height", subdiameter)
                    .append("g")
                    .attr("id","subsvg_right_g")
                    .attr("transform", "translate(" + subdiameter / 2 + "," + subdiameter / 2 + ")");
            
            //subright svg
            var subright_root = jsonsub_right.nodes[0];
            var subright_focus = subright_root,
                subright_nodes = subpack_right.nodes(subright_root);
            subcircle_right = subsvg_right.selectAll("circle")
              .data(subright_nodes)
              .enter().append("circle")
              .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
              .attr("id",function(d){return "subr_"+d.name;})
              .attr("name",function(d){return d.id;})
              .attr("data_match",function(d){return d.matched;})
              .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
              .on("click", function(d) { //if (focus !== d)
                alert(d.matched);
                zoom(d,"subright",1), d3.event.stopPropagation(); 
               })
              .on("mouseover", function(d){
                return subtooltip.style("visibility", "visible").text(d.name);
              })
              .on("mousemove", function(d){return subtooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px").text(d.name);})
              .on("mouseout", function(){return subtooltip.style("visibility", "hidden");});

            var subtext_right = subsvg_right.selectAll("text")
              .data(subright_nodes)
              .enter().append("text")
              .attr("class", "label")
              .style("fill-opacity", function(d) { return d.parent === subright_root ? 1 : 0; })
              .style("display", function(d) { return d.parent === subright_root ? null : "none"; })
              .text(function(d) { return d.id; });

            var sublinks_right = jsonsub_right.links;
            subsvg_right.selectAll("line")
                .data(sublinks_right)
                .enter().append("line")
                .attr("class", "link")
                .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source).__data__;
                  link.x1=match_node1.x;
                  return match_node1.x;})
                .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.source).__data__;
                   link.y1=match_node1.y;
                  return match_node1.y;})
                .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target).__data__;
                   link.x2=match_node1.x;
                  return match_node1.x;})
                .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
                  if(subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target)==undefined)
                        return 0;
                  var match_node1 = subsvgViewer_right.ownerDocument.getElementById("subr_"+link.target).__data__;
                  link.y2=match_node1.y;
                  return match_node1.y;});

            subnode_right = subsvg_right.selectAll("circle,text");

            sublines_right= subsvg_right.selectAll("line");
            d3.select("#subcontent")
               .style("background", color(-1))
                .on("click", function() { zoom(subright_root,"subright",1); });

            zoomTo([subright_root.x, subright_root.y, subright_root.r * 2 + submargin],"subright");

        });

        
 
        var subtooltip = d3.select("#subcontent")
                .append("div")
                .attr("id","subtooltip")
                .style("position", "absolute")
                .style("z-index", "10")
                .style("visibility", "hidden")
                .text("a simple tooltip");

        return false;
    });

 });
</script>