# FMA_finder
##Online visualization tool for  network alignment analysis

Functional module alignments (FMAs) are pairs of subnetworks that share similar functions, which are biologically meaningful.
The FMA-finder tool visualizes large-scale network alignments between different species and provides both analysis and visualization of FMAs.

##Platform

Windows/PHP/Apache

##Usage

* Move project to php's DocumentRoot, such as (D:/Apache/htdocs/www) 
* Visit http://localhost/FMA_finder

### step 1: Visualization
```javascript
 //netcompare-1119.js
 d3.json(file_left, function(error, root){……});
 d3.json(file_right, function(error, root){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/visualization.png)

### step 2: Node Alignment
```javascript
 //fma-1119.js
 $('#searchNode_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/node_alignment.png)

### step 3: Module alignment
```javascript
 //fma-1119.js
 $('#filterNode_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/module_alignment.png)

### step 4: Functional module alignment
```javascript
 //fma-1119.js
 $('#filterNode_ok').click(function(){……});
 $('#filterGOlist_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/fma.png)

##Related

* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [D3.js](https://github.com/mbostock/d3)
* Jquery
* Python
* [ppython](https://github.com/elephantsuperjuan/ppython)

##Author and Contact
This work was partially supported by Center for Bioinformatics at Shanghai University. 
For more information, please contact jiangx@shu.edu.cn (Jiang Xie) and cjxiang@shu.edu.cn (Chaojuan Xiang)

* Email:(cjxiang@shu.edu.cn)
* github: [@elephantsuperjuan](http://github.com/elephantsuperjuan)
