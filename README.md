# FMA_finder
##Online visualization tool for  network alignment analysis

Functional module alignments (FMAs) are pairs of subnetworks that share similar functions, which are biologically meaningful.
The FMA-finder tool visualizes large-scale network alignments between different species and provides both analysis and visualization of FMAs.

` Online website`：[http://biocenter.shu.edu.cn/FMA_finder/](http://biocenter.shu.edu.cn/FMA_finder/)

##Platform

Windows/PHP/Apache

##Usage

* Move project to php's DocumentRoot, such as (D:/Apache/htdocs/www) 
* Visit http://localhost/FMA_finder

### step 1: Visualization
```javascript
 //netcompare.js (render netowrk on screen)
 //render left network by json file
 d3.json(file_left, function(error, root){……});
 //render right network by json file
 d3.json(file_right, function(error, root){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/visualization.png)

### step 2: Node Alignment
```javascript
 //fma.js (find FMA step by step)
 // submit form of Search Node
 $('#searchNode_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/node_alignment.png)

### step 3: Module alignment
```javascript
 //fma.js (find FMA step by step)
 //submit form of Filter Network 
 $('#filterNode_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/module_alignment.png)

### step 4: Functional module alignment
```javascript
 //fma.js (find FMA step by step)
 //submit form of Filter Network and GO list is not null
 $('#filterNode_ok').click(function(){……});
```
![image](https://github.com/elephantsuperjuan/FMA_finder/blob/master/about/fma.png)

##Related

* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [D3.js](https://github.com/mbostock/d3)
* Jquery
* Python
* [ppython](https://github.com/elephantsuperjuan/ppython)
* [Center for Bioinformatics, Shanghai University](http://biocenter.shu.edu.cn/software/)

## Acknowledgement
This work was partially supported by Center for Bioinformatics at Shanghai University. 

## Author and Contact
* Email: Jiang Xie (jiangx@shu.edu.cn) and Chaojuan Xiang (cjxiang@shu.edu.cn)
* github: [@elephantsuperjuan](http://github.com/elephantsuperjuan)
