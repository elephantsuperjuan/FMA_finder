<!DOCTYPE html>
<html lang="en">
    <head>
       <title>FMA-finder:Online visualization tool for network alignment analysis</title>
       <meta http-equiv="content-type" content="text/html; charset=utf-8" >
       <meta name="description" content="The FMA-finder tool provides both analysis and visualization of functional module alignments (FMAs)."> 
       <meta name="keyword" content="functional module alignment,visualization,network alignment" > 
       <meta name="author" content="Chaojuan Xiang(cjxiang@shu.edu.cn), Jiang Xie(jiangx@shu.edu.cn) from Shanghai University" >
       <meta name="revised" content="Chaojuan Xiang, 10/9/2015" >
       <meta name="generator" content="php codeigniter" >
       <meta name="robots" contect= "all"> 

        <link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" />
        <link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/keleyidock.css') ?>" />
        <link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/netCompare.css') ?>" />
        <link type="text/css" rel="Stylesheet" href="<?php echo base_url('assets/css/welcome.css') ?>" />
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.1.3.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/nav.js') ?>"></script>
        <style>
            .modal-lg{
                width:100%;
            }
        </style>

    </head>
<body>
    <header><a href="<?php echo site_url('')?>">FMA-finder</a></header>

<ul id="dock">
    <li id="menu" data-toggle="tooltip" data-placement="right" title="Click to open menu" > 
        <ul class="free">
            <li class="header">
                <a href="javascript:;" class="dock-keleyi-com" target="_self">Fixed</a>
                <a href="javascript:;" class="undock">Hide</a>Menu
            </li>
            <li id="searchNode">Search Node</li>
            <li id="filterNode">Filter Network</li>
            <li id="filterGO">Filter GO Network</li>
        </ul>
    </li>
</ul>

<div class="content" id="content">
    <div class="spinner" id="loading">
      <div class="rect1"></div>
      <div class="rect2"></div>
      <div class="rect3"></div>
      <div class="rect4"></div>
      <div class="rect5"></div>
      加载中
    </div>

    <div id="section1" style="height:100%;float:left;width:50%;position:relative;">
    <!-- <div id="location1" class="location" ></div> -->
    </div>
    <div id="section2" style="height:100%;float:left;width:50%;position:relative;">
    <!-- <div id="location2" class="location" ></div> -->
    </div>
</div>
<footer> <center>To ensure the display quality, use chrome browser and full-screen display.</center></footer>
    <textarea id="json1" cols="10" rows="10" style="display:none;"></textarea>
    <textarea id="json2" cols="10" rows="10" style="display:none;"></textarea>  
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
            <button type="button" class="btn btn-primary" id="searchNode_ok">Query</button>
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
            <input class="form-control" id="nodelist1_parent" placeholder="n_1_1"/><button id="nodelist1_btn">↓query</button>
            <textarea class="form-control" id="nodelist1" rows="5"></textarea>
          </div>
          <div class="form-group col-md-5">
            <label for="nodelist2" class="control-label">Node list in Network2:</label>
            <input class="form-control" id="nodelist2_parent" placeholder="n_1_1"/><button id="nodelist2_btn">↓query</button>
            <textarea class="form-control" id="nodelist2" rows="5"></textarea>
          </div>
          <div class="form-group col-md-10 col-md-offset-1">
            <em>In addition, you can filter the nodes with GO items.</em><br/>
            <label for="golist" class="control-label">GO list:</label>
            <textarea class="form-control" id="golist_sub" rows="5" placeholder="GO:0000000"></textarea>
          </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="filterNode_ok">Query</button>
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
        <!-- <button type="button" class="pull-right" style="margin-right:20px;" aria-label="Close"><a aria-hidden="true">Export file</a></button> -->
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

<div class="modal" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="infotitle">Matched infomation</h4>
      </div>
      <div class="modal-body row">
        <div class="form-group col-md-10 col-md-offset-1">
          <pre id="infotext">haha</pre>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<input id="jsonleft" value="<?php echo $net1_json ?>" type="hidden"/>
<input id="jsonright" value="<?php echo $net2_json ?>" type="hidden"/>


<input id="goleft" value="<?php echo $net1_gofile ?>" type="hidden"/>
<input id="goright" value="<?php echo $net2_gofile ?>" type="hidden"/>

 
<script type="text/javascript" src="<?php echo base_url('assets/d3/d3.js') ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/d3/json.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/subnetcompare-1119.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/netCompare-1119.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/fma-1119.js') ?>"></script>