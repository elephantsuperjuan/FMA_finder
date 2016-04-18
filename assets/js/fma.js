
function findList(name,nodelist){
    //0 false;1 true;-1 new;
    for(var key in nodelist) {
        if(key==name){
            return nodelist[key];
        }
    };
    return 0;
}

//给定node_parent的编号，获取其子namelist
function getChildrenNamelist(parent){
    /* 输入参数 parent：n_0_1  pre:l_/r_
       输出参数 list:childrenlist的name列表        */
    var list = [];
    if(parent.name.substring(0,4)=="n_0_"){
        list.push(parent.id);
    }else{
        var children = parent.children;
        for (var i = 0; i < children.length; i++) {
            list = list.concat(getChildrenNamelist(children[i]));
        };
    }
    return list;
}

function cloneNode(node,flag){
    var new_node = new Object();
    new_node.children = undefined;
    new_node.depth = node.depth;
    new_node.matched = node.matched;
    new_node.name = node.name;
    new_node.value = node.value;
    new_node.r = node.r;
    new_node.x = node.x;
    new_node.y = node.y;
    if(flag==0){
        new_node.id = node.id;
        new_node.size = node.size;
        new_node.color = node.color;
    }
    return new_node;
}

function traverseNode_update(jsonnode,nodelist){
    var new_json=undefined;
    if(jsonnode.children){
        var children_tmp = jsonnode.children;
        var length = children_tmp.length;
        for (var i = 0; i < length; i++) {
            var new_node = traverseNode_update(children_tmp[i],nodelist);
            if(new_node!=undefined){
                if(new_json==undefined){
                    new_json = cloneNode(jsonnode,1);
                    new_json.children = [];
                }
                new_json.children.push(new_node);
            }
        }
    }
    else{
        if(findList(jsonnode.name,nodelist)==1){
            new_json = cloneNode(jsonnode,0);
        }else if(findList(jsonnode.name,nodelist)==-1){
            new_json = cloneNode(jsonnode,0);
            new_json.color='#eee';
        }
    }
    return new_json;
}

function traverseLink_update(jsonlink,nodelist){
    var new_json = [];
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
        if((sourceflag==1) || (targetflag==1)){
            new_json.push(jsonlink[i]);
        }
    };
    return new_json;
}
function filterJson(jsonall,nodelist){
    var nodes_tmp = jsonall.nodes;
    var links_tmp = jsonall.links;
    var sublinks_tmp = traverseLink_update(links_tmp,nodelist);

    var subnodes_tmp = traverseNode_update(nodes_tmp[0],nodelist);

    var jsonall_tmp = {};
    var subnodes_array = [];
    subnodes_array.push(subnodes_tmp);
    jsonall_tmp.nodes = subnodes_array;
    jsonall_tmp.links = sublinks_tmp;
    return jsonall_tmp;
}
//在原来基础上进行帅选GO
function traverseNode_updatebyGO(jsonnode,nodelist){
    if(jsonnode.children!=undefined){
        var children_tmp = jsonnode.children;
        var length = children_tmp.length;
        for (var i = 0; i < length; i++) {
            traverseNode_updatebyGO(children_tmp[i],nodelist);
        }
    }
    else{
        //无论如何都保留，只是不在范围之内的，要变为灰色
        if(findList(jsonnode.name,nodelist)!=1){
            jsonnode.color='#eee';
        }
    }
}

function filterJsonbyGO(jsonall,nodelist){
    var nodes_tmp = jsonall.nodes,
        subnodes_tmp = nodes_tmp[0];

    var links_tmp = jsonall.links;
    traverseNode_updatebyGO(subnodes_tmp,nodelist);

    var jsonall_tmp = {};
    var subnodes_array = [];
    subnodes_array.push(subnodes_tmp);
    jsonall_tmp.nodes = subnodes_array;
    jsonall_tmp.links = links_tmp;
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

function filterGOSub(json_left,json_right,golist){

    var jsonsub_left={}, jsonsub_right={};
    var nodeArray1 = [],nodeArray2 = [];
    var nodelist1 = [] ,nodelist2 = [];

    var gofile_left = $('#goleft').attr("value");
    d3.json(gofile_left, function(error, root) {
        if (error) return console.error(error);
        else{
            var nodes = root.nodes;
            for (var i = 0; i < nodes.length; i++) {
                var gotarget = nodes[i].go;
                for (var j = 0; j < golist.length; j++) {
                    if(gotarget.indexOf(golist[j])!=-1){
                        nodelist1.push(nodes[i]); 
                        break;
                    }
                }
            }
            var namelist_left = netcompare.getNamelist("left");
            var id_left;
            for (var i = 0; i < nodelist1.length; i++) {
                id_left = namelist_left[nodelist1[i].name];
                nodeArray1[id_left]=1;
            };

            //console.log(nodeArray1);
            jsonsub_left = filterJsonbyGO(json_left,nodeArray1);

            if(!!jsonsub_left.nodes[0]){
                var subleft = new subnetcompare();
                subleft.setParam("subnetwork1","subl_","subleft","subcontent");
                subleft.renderSub(jsonsub_left);
            }else{
                alert("There is no nodes selected in left network!");
            }

            // jsonString(jsonsub_left,"left");
        }

    });

    var gofile_right = $('#goright').attr("value");
    d3.json(gofile_right, function(error, root) {
        if (error) return console.error(error);
        else{
            var nodes = root.nodes;
            for (var i = 0; i < nodes.length; i++) {
                var gotarget = nodes[i].go;
                for (var j = 0; j < golist.length; j++) {
                    if(gotarget.indexOf(golist[j])!=-1){
                        nodelist2.push(nodes[i]); 
                        break;
                    }
                }
            }

            var namelist_right = netcompare.getNamelist("right");
            var id_right;
            for (var i = 0; i < nodelist2.length; i++) {
                id_right = namelist_right[nodelist2[i].name];
                nodeArray2[id_right]=1;
            };

            //console.log(nodeArray2);
            jsonsub_right = filterJsonbyGO(json_right,nodeArray2);

            if(!!jsonsub_right.nodes[0]){
                var subright = new subnetcompare();
                subright.setParam("subnetwork2","subr_","subright","subcontent");
                subright.renderSub(jsonsub_right);
            }else{
                alert("There is no nodes selected in right network!");
            }

            // jsonString(jsonsub_right,"right");
        }

    });
}

window.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    var top_div = document.getElementsByTagName("header")[0];
    if( t >= 50 ) {
        top_div.style.display = "none";
    } else {
        top_div.style.display = "block";
    }
}

 $(document).ready(function () {
    // $('[data-toggle="tooltip"]').tooltip();
    $('#menu').tooltip('show');
    $('#menu').click(function(){
        $(this).tooltip('hide');
    });

    //模态框关闭时销毁前面的对象
    $('#filterNetworkModal').on('hidden.bs.modal', function (e){
      $('#subcontent').html('<div class="form-group col-md-6" id="subnetwork1"></div><div class="form-group col-md-6" id="subnetwork2"></div>');
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
                // var node_tmp = document.getElementsByName(name).item(filterNodePosition_left);
                var node_tmps = document.getElementsByName(name);
                var node_tmp;
                for (var i = node_tmps.length - 1; i >= 0; i--) {
                    var id_flag = node_tmps[i].id.substring(0,2);
                    if(id_flag=='l_'){
                        node_tmp = node_tmps[i];
                        break;
                    }
                };
                if(node_tmp==undefined){
                    alert("name not valid in left");
                    return false;
                }
                node_tmp = node_tmp.__data__;

                var alert_str = "";
                if(node_tmp.matched != -1){
                    var match_tmp = document.getElementById("r_n_0_"+node_tmp.matched);
                    var node_tmp_data = match_tmp.__data__;
                    alert_str = "\n Matching Node info. is \r Id: "+node_tmp_data.name+" Name: "+node_tmp_data.id+" Parent: "+node_tmp_data.parent.name;
                }
                
                alert("Node info. is \r Id: "+node_tmp.name+" Name: "+node_tmp.id+" Parent: "+node_tmp.parent.name+alert_str );
              
                var newDiv = document.createElement('div');
                newDiv.setAttribute("id", "location_l_" + name); 
                newDiv.setAttribute("class", "location"); 
                newDiv.style.top=(node_tmp.y-20)+"px";
                newDiv.style.left=(node_tmp.x-5)+"px";
                $('#content').append(newDiv);
                return true;
            } 
            else{
                var node_tmps = document.getElementsByName(name);
                var node_tmp;
                for (var i = node_tmps.length - 1; i >= 0; i--) {
                    var id_flag = node_tmps[i].id.substring(0,2);
                    if(id_flag=='r_'){
                        node_tmp = node_tmps[i];
                        break;
                    }
                };
                if(node_tmp==undefined){
                    alert("name not valid in left");
                    return false;
                }
                node_tmp = node_tmp.__data__;
                var alert_str = "";
                if(node_tmp.matched != -1){
                    var match_tmp = document.getElementById("l_n_0_"+node_tmp.matched);
                    var node_tmp_data = match_tmp.__data__;
                    alert_str = "\n Matching Node info. is \r Id: "+node_tmp_data.name+" Name: "+node_tmp_data.id+" Parent: "+node_tmp_data.parent.name;
                }
                
                alert("Node info. is \r Id: "+node_tmp.name+" Name: "+node_tmp.id+" Parent: "+node_tmp.parent.name+alert_str );
              

                var diameter = (screen.width/2<screen.height)?screen.width/2:screen.height;
                var newDiv = document.createElement('div');
                newDiv.setAttribute("id", "location_r_" + name); 
                newDiv.setAttribute("class", "location"); 
                newDiv.style.top=(node_tmp.y-20)+"px";
                newDiv.style.left=(node_tmp.x+screen.width/2-10-5)+"px";
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
    $('#nodelist1_btn').click(function(){
        var node_parent = $('#nodelist1_parent').val();
        var node_parent_tmp = document.getElementById("l_"+node_parent);
        if(!!node_parent_tmp){
            var list = getChildrenNamelist(node_parent_tmp.__data__);
            var str = list.join("\n");
            $('#nodelist1').val(str);
        }
    });
    $('#nodelist2_btn').click(function(){
        var node_parent = $('#nodelist2_parent').val();
        var node_parent_tmp = document.getElementById("r_"+node_parent);
        if(!!node_parent_tmp){
            var list = getChildrenNamelist(node_parent_tmp.__data__);
            var str = list.join("\n");
            $('#nodelist2').val(str);
        }
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
                // var node_tmp_left = document.getElementsByName(nodelist1[i]).item(filterNodePosition_left);
                var node_tmp_lefts = document.getElementsByName(nodelist1[i]);
                if(node_tmp_lefts==null){
                    alert(nodelist1[i]+"not in left network!");
                    return false;
                }
                node_tmp_left = node_tmp_lefts[0];
                
                // var node_tmp_left;
                // for (var i = node_tmp_lefts.length - 1; i >= 0; i--) {
                //     var id_flag = node_tmp_lefts[i].id.substring(0,2);
                //     if(id_flag=='l_'){
                //         node_tmp_left = node_tmp_lefts[i];
                //         break;
                //     }
                // };

                if(node_tmp_left.__data__.matched != -1){
                    nodelist1[i]=node_tmp_left.__data__.name;
                    nodelist2[i]="n_0_"+node_tmp_left.__data__.matched;
                }
            }
            else if(nodelist1[i]==''  || nodelist1[i]==undefined){
                //var node_tmp_right = document.getElementsByName(nodelist2[i]).item(filterNodePosition_right);
                var node_tmp_rights = document.getElementsByName(nodelist2[i]);
                if(node_tmp_rights==null){
                    alert(nodelist2[i]+"not in right network!");
                    return false;
                }
                if(node_tmp_rights.length==2){
                    node_tmp_right = node_tmp_rights[1];
                }else{
                    node_tmp_right = node_tmp_rights[0];
                }
                // var node_tmp_right;
                // for (var i = node_tmp_rights.length - 1; i >= 0; i--) {
                //     var id_flag = node_tmp_rights[i].id.substring(0,2);
                //     if(id_flag=='r_'){
                //         node_tmp_right = node_tmp_rights[i];
                //     }
                // };

                
                if(node_tmp_right.__data__.matched != -1){
                    nodelist1[i]="n_0_"+node_tmp_right.__data__.matched;
                    nodelist2[i]=node_tmp_right.__data__.name;
                }
            }
            else{
                // alert("both ok");
            }
            console.log(nodelist1[i]+" "+nodelist2[i]);
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
        var json_left = netcompare.getJSON("left");
        var json_right = netcompare.getJSON("right");

        jsonsub_left = filterJson(json_left,nodeArray1);
        jsonsub_right = filterJson(json_right,nodeArray2);
        
        //for golist
        var golist = $('#golist_sub').val().split('\n'); 
        if(golist.length==1 && golist[0]==''){
            var subleft = new subnetcompare();
            subleft.setParam("subnetwork1","subl_","subleft","subcontent");
            subleft.renderSub(jsonsub_left);

            var subright = new subnetcompare();
            subright.setParam("subnetwork2","subr_","subright","subcontent");
            subright.renderSub(jsonsub_right);
        }else{
            filterGOSub(jsonsub_left,jsonsub_right,golist);
        }
        console.log(nodelist1.length);
        console.log(nodelist2.length);

        // var mapinfo = {};
        var map_str = "Matched pairs in two network\nNode1\tNode2\n";
        for (var i = nodelist1.length - 1; i >= 0; i--) {
            var node_tmp1 = document.getElementById('l_'+nodelist1[i]);
            var node_tmp2 = document.getElementById('r_'+nodelist2[i]);
            if((!!node_tmp1)&&(!!node_tmp2)){
                map_str += node_tmp1.__data__.id+'\t'+node_tmp2.__data__.id+'\n';
                // mapinfo[node_tmp1.__data__.id] = node_tmp2.__data__.id;
            }
        };
        $('#infotext').html(map_str);
        $('#infoModal').modal('show');
        // console.log(map_str);
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

        var gofile_left = $('#goleft').attr("value");
        d3.json(gofile_left, function(error, root) {
            if (error) return console.error(error);
            else{
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
                var namelist_left = netcompare.getNamelist("left");
                var id_left;
                for (var i = 0; i < nodelist1.length; i++) {
                    id_left = namelist_left[nodelist1[i].name];
                    nodeArray1[id_left]=1;
                };

                var json_left = netcompare.getJSON("left");
                jsonsub_left = filterJson(json_left,nodeArray1);

                var subleft = new subnetcompare();
                subleft.setParam("subnetwork1","subl_","subleft","subcontent");
                subleft.renderSub(jsonsub_left);
            }

        });

        var gofile_right = $('#goright').attr("value");
        d3.json(gofile_right, function(error, root) {
            if (error) return console.error(error);
            else{
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
                var namelist_right = netcompare.getNamelist("right");
                var id_right;
                for (var i = 0; i < nodelist2.length; i++) {
                    id_right = namelist_right[nodelist2[i].name];
                    nodeArray2[id_right]=1;
                };

                var json_right = netcompare.getJSON("right");
                jsonsub_right = filterJson(json_right,nodeArray2);
                
                var subright = new subnetcompare();
                subright.setParam("subnetwork2","subr_","subright","subcontent");
                subright.renderSub(jsonsub_right);
            }

        });

        return false;
    });

 });