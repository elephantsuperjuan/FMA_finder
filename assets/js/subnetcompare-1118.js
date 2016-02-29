var subnetcompare = function(){

  var width = (screen.width/2<screen.height)?screen.width/2:screen.height;
      width = width-100;
  var submargin = 5,
      subdiameter = width-5;

  var view;

  var div_id = "",
      pre_flag = "",
      flag = "",
      content_id = "",
      self = this;

  var subpack,subsvg,subtooltip;
  var subnode,subline,subcircle;

  var color = d3.scale.linear()
              .domain([-1, 5])
              .range(["hsl(152,80%,80%)", "hsl(228,30%,40%)"])
              .interpolate(d3.interpolateHcl);

  var setParam =  function(m_div_id,m_pre_flag,m_flag,m_content_id){
    self.div_id = m_div_id;
    self.pre_flag = m_pre_flag;
    self.flag = m_flag;
    self.content_id = m_content_id;

    self.subpack = d3.layout.pack()
              .padding(2)
              .size([subdiameter - submargin, subdiameter - submargin])
              .value(function(d) { return d.size; }),

    self.subsvg = d3.select("#"+m_div_id).append("svg")
              .attr("id","svg"+m_flag)
              .attr("width", subdiameter)
              .attr("height", subdiameter)
              .append("g")
              .attr("id","svg_"+m_flag+"_g")
              .attr("transform", "translate(" + subdiameter / 2 + "," + subdiameter / 2 + ")"),

    self.subtooltip = d3.select("#"+self.content_id)
              .append("div")
              .attr("id","tooltip"+m_flag)
              .style("position", "absolute")
              .style("z-index", "10")
              .style("visibility", "hidden")
              .text("a simple tooltip");

  };

  var renderSub = function(json){
        //sub svg
        var sub_root = json.nodes[0],
            sub_focus = sub_root,
            sub_nodes = self.subpack.nodes(sub_root);

        self.subcircle = self.subsvg.selectAll("circle")
          .data(sub_nodes)
          .enter().append("circle")
          .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })      
          .attr("id",function(d){return self.pre_flag+d.name;})
          .attr("name",function(d){return d.id;})
          .attr("data_match",function(d){return d.matched;})
          .style("fill", function(d) { return d.children ? color(d.depth) : d.color; })
          .on("click", function(d) { //if (focus !== d)
            alert(d.matched);
            zoom(d), d3.event.stopPropagation(); 
           })
          .on("mouseover", function(d){
            return self.subtooltip.style("visibility", "visible").text(d.name);
          })
          .on("mousemove", function(d){return self.subtooltip.style("top", (event.pageY-15)+"px").style("left",(event.pageX+15)+"px").text(d.name);})
          .on("mouseout", function(){return self.subtooltip.style("visibility", "hidden");});

        var subtext = self.subsvg.selectAll("text")
          .data(sub_nodes)
          .enter().append("text")
          .attr("class", "label")
          .style("fill-opacity", function(d) { return d.parent === sub_root ? 1 : 0; })
          .style("display", function(d) { return d.parent === sub_root ? null : "none"; })
          .text(function(d) { return d.id; });

        var sublinks = json.links;
        self.subsvg.selectAll("line")
            .data(sublinks)
            .enter().append("line")
            .attr("class", "link")
            .attr("x1",  function(link){//var svgViewer1 = document.getElementById("section1");
              var node_tmp = document.getElementById(self.pre_flag+link.source);
              if(node_tmp==undefined)
                    return 0;
              link.x1=node_tmp.__data__.x;
              return link.x1;})
            .attr("y1",   function(link){//var svgViewer1 = document.getElementById("section1");
              var node_tmp = document.getElementById(self.pre_flag+link.source);
              if(node_tmp==undefined)
                    return 0;
              link.y1=node_tmp.__data__.y;
              return link.y1;})
            .attr("x2",   function(link){//var svgViewer1 = document.getElementById("section1");
              var node_tmp = document.getElementById(self.pre_flag+link.target);
              if(node_tmp==undefined)
                    return 0;
              link.x2=node_tmp.__data__.x;
              return link.x2;})
            .attr("y2",   function(link){//var svgViewer1 = document.getElementById("section1");
              var node_tmp = document.getElementById(self.pre_flag+link.target);
              if(node_tmp==undefined)
                    return 0;
              link.y2=node_tmp.__data__.y;
              return link.y2;});

        self.subnode = self.subsvg.selectAll("circle,text");

        self.subline = self.subsvg.selectAll("line");
        d3.select("#"+self.content_id)
           .style("background", color(-1))
            .on("click", function() { zoom(sub_root); });

        zoomTo([sub_root.x, sub_root.y, sub_root.r * 2 + submargin]);

    };

    var zoom = function(d) {
      var focus0 = focus; focus = d;

      var transition = d3.transition()
          .duration(750)
          .tween("zoom", function(d) {
            var i;
            i = d3.interpolateZoom(self.view, [focus.x, focus.y, focus.r * 2 + submargin]);
            return function(t) { zoomTo(i(t)); };
          });

      transition.selectAll("text")
          .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
          .style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
          .each("start", function(d) { if (d.parent === focus) this.style.display = "inline"; })
          .each("end", function(d) { if (d.parent !== focus) this.style.display = "none"; });
    }

    var zoomTo = function(v) {
      var k = subdiameter / v[2]; 
    
      self.subnode.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
      self.subline.attr("transform", function(d) {
       return "scale(" + k + ")"+" translate(" + ((d.x1+d.x2)/2*0 - v[0]) * 1 + "," + ((d.y1+d.y2)/2*0 - v[1]) * 1 + ") "; 
      });
      self.subcircle.attr("r", function(d) { return d.r * k; });

      self.view = v;
    }


    return {
      renderSub,
      setParam
    };

}