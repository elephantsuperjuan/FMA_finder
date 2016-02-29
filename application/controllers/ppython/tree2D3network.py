# -*- coding: utf-8 -*-
import php_python
import random

matchInfo = []
yeast_nameInfo = {}
human_nameInfo = {}

class treeElement:
    def __init__(self,node=0,children=[], level=0,match=-1,color="",name=""):
        self.node = node
        self.children = children
        self.level = level
        self.match = match
        self.color = color
        self.name = name

def find_in_tree(tree,node,level):
    try:
        id = -1
        for v in range(0,len(tree)):
            if(node==tree[v].node and level==tree[v].level):
                id=v
                break
    except:
        print "find_in_tree() Exception!"
    #print(str(tree[v].node)+" "+str(tree[v].level))
    return id

def dsf_display(tree,spaceStr,write_object_json,flag):
    sizeStr = ""
    matchStr = ""
    colorStr = ""
    nameStr = ""
    first_flag = 0
    for i in range(0,len(tree)):
        if(tree[i].children == []):
                #控制输出大网不匹配的节点
            sizeStr=',\"size\": 3812'
            matchStr=',\"matched\":\"'+str(tree[i].match)+'\"'
            colorStr=',\"color\":\"'+str(tree[i].color)+'\"'
            nameStr=',\"id\":\"'+str(tree[i].name)+'\"'
            #if(flag==2):
            #    print(tree[i].match)
            if(first_flag==0):
                # if(flag!=2 or tree[i].match!=-1):
                write_object_json.write('\n'+spaceStr+'{"name\":\"'+'n_'+str(tree[i].level)+'_'+str(tree[i].node)+'\"'+nameStr+sizeStr+matchStr+colorStr+'}')
                first_flag = 1
            else:
                # if(flag!=2 or tree[i].match!=-1):
                write_object_json.write(',\n'+spaceStr+'{"name\":\"'+'n_'+str(tree[i].level)+'_'+str(tree[i].node)+'\"'+nameStr+sizeStr+matchStr+colorStr+'}')
        else:
            if(first_flag==0):
                write_object_json.write('\n'+spaceStr+'{"name\":\"'+'n_'+str(tree[i].level)+'_'+str(tree[i].node)+'\"'+',\"matched\":\"-1\",\n'+spaceStr+' \"children\":[')
                first_flag = 1
            else:
                write_object_json.write(',\n'+spaceStr+'{"name\":\"'+'n_'+str(tree[i].level)+'_'+str(tree[i].node)+'\"'+',\"matched\":\"-1\",\n'+spaceStr+' \"children\":[')
            dsf_display(tree[i].children,spaceStr+' ',write_object_json,flag)
            write_object_json.write('\n'+spaceStr+' ]\n'+spaceStr+'}')
    spaceStr = spaceStr + '  '

class matchElement:
    def __init__(self,node1=0,node2=0,color="#eee"):
        self.node1 = node1
        self.node2 = node2
        self.color = color

def dic_getByNode(matchMap,value,flag):
    for i in range(0,len(matchMap)):
        if(flag == 1):
            if(matchMap[i].node1 == value):
                return i
        else:
            if(matchMap[i].node2 == value):
                return i
    return -1

def rgb2hex(rgbcolor):
    r, g, b = rgbcolor
    return (r << 16) + (g << 8) + b

def tree_construct(treeList,matchInfo,open_net,open_tree,write_object_json,networktag):
    upper_nodeList = []
    level = 0

    lineId = 0
    nodesdict={}
    # for idx in range(1,20):
    #     nodesdict[idx]=1
    for line in open_tree:
        # if lineId>100:
        #    break
        lineId = lineId + 1
        strline = line.strip().split()
        node1 = int(strline[0])
        node2 = int(strline[1])
        nodesdict[node1]=1
        nodesdict[node2]=1
        if(0==node1):
            upper_nodeList = []
            level = level+1
        if(node2 not in upper_nodeList):
            treeNode_tmp = treeElement(node2,[],level)
            treeList.append(treeNode_tmp)
            upper_nodeList.append(node2)
        index_treeNode_upper = find_in_tree(treeList,node2,level)
        treeNode_upper = treeList[index_treeNode_upper]
        #write_object_json.write("children:"+str(treeNode_upper.children)+'\n')
        if(1 == level):
            matchNode_idx = dic_getByNode(matchInfo,node1,networktag)
            name = ""
            if(networktag==1):
                name = yeast_nameInfo[node1]
            else:
                name = human_nameInfo[node1]
            #print(matchNode_idx)
            if(matchNode_idx != -1):
                if(networktag==1):
                    treeNode_tmp = treeElement(node1,[],0,matchInfo[matchNode_idx].node2,matchInfo[matchNode_idx].color,name)
                else:
                    treeNode_tmp = treeElement(node1,[],0,matchInfo[matchNode_idx].node1,matchInfo[matchNode_idx].color,name)
            else:
                treeNode_tmp = treeElement(node1,[],0,-1,'#eee',name)
            #write_object_json.write("before append children:")
            #dsf_display(treeList)
            treeNode_upper.children.append(treeNode_tmp)
            #write_object_json.write("after append children:")
            #dsf_display(treeList)
        else:
            #print(str(treeNode_upper.node))
            index_treeNode_down = find_in_tree(treeList,node1,level-1)
            treeNode_down = treeList[index_treeNode_down]
            treeNode_upper.children.append(treeNode_down)
            #dsf_display(treeList)
            del treeList[index_treeNode_down]
            #dsf_display(treeList)

    write_object_json.write("{\n\"nodes\":[\n{\"name\":\"root_0\",\"matched\":\"-1\",\n\"children\":[")
    print(networktag)
    dsf_display(treeList,'',write_object_json,networktag)
    write_object_json.write("]\n}\n],\n\"links\":[")
    lineId = 0
    for line in open_net:
        strline = line.strip().split()
        node1 = int(strline[0])
        node2 = int(strline[1])
        if not nodesdict.has_key(node1):
            continue
        if not nodesdict.has_key(node2):
            continue
        if(2 == networktag):
        #As for the line in target network(such as HumanNet), if the two nodes of this line are matched, we show it especially.
            matchNode_idx1 = dic_getByNode(matchInfo,node1,networktag)
            matchNode_idx2 = dic_getByNode(matchInfo,node2,networktag)
            # treeNode_idx1 = find_in_tree(human_treeList,node1,0)
            # treeNode_idx2 = find_in_tree(human_treeList,node2,0)
            #print(matchNode_idx1)
            # and (human_treeList[treeNode_idx1].match != -1) and (human_treeList[treeNode_idx2].match != -1)
            if((matchNode_idx1 != -1) and (matchNode_idx2 != -1)):
                lineId = lineId + 1
                if(lineId==1):
                    write_object_json.write('\n{\"name\":\"'+str(lineId)+'\",\"source\":\"n_0_'+str(node1)+'\",\"target\":\"n_0_'+str(node2)+'\"}')
                else:
                    write_object_json.write(',\n{\"name\":\"'+str(lineId)+'\",\"source\":\"n_0_'+str(node1)+'\",\"target\":\"n_0_'+str(node2)+'\"}')
        else:
            lineId = lineId + 1        
            if(lineId==1):
                write_object_json.write('\n{\"name\":\"'+str(lineId)+'\",\"source\":\"n_0_'+str(node1)+'\",\"target\":\"n_0_'+str(node2)+'\"}')
            else:
                write_object_json.write(',\n{\"name\":\"'+str(lineId)+'\",\"source\":\"n_0_'+str(node1)+'\",\"target\":\"n_0_'+str(node2)+'\"}')
    write_object_json.write(" \n]\n}")
    write_object_json.close()


#step 3:生成json文件-主函数
def network_json(_net1,_net2,_mapping):
    # open_object_map = open('yh/sif_num/hga-yh.txt')
    # yeast_net = open('net/out_YeastNet.txt')
    # yeast_tree = open('tree/yeast.tree')
    # yeast_json = open('json/hga-yeastnet.json','w')
    # human_net = open('net/out_HumanNet.txt')
    # human_tree = open('tree/human.tree')
    # human_json = open('json/hga-humannet.json','w')

    _pos1 = _net1.rfind(".")
    _net1_filename = _net1[:_pos1]
    _pos2 = _net2.rfind(".")
    _net2_filename = _net2[:_pos2]

    open_object_map = open('../../../assets/download/num/num_'+_mapping)
    yeast_net = open('../../../assets/download/num/num_'+_net1)
    yeast_tree = open('../../../assets/download/num/'+_net1_filename+'.tree')
    yeast_json = open('../../../assets/download/num/'+_net1_filename+'.json','w')
    human_net = open('../../../assets/download/num/num_'+_net2)
    human_tree = open('../../../assets/download/num/'+_net2_filename+'.tree')
    human_json = open('../../../assets/download/num/'+_net2_filename+'.json','w')

    yeast_name = open('../../../assets/download/num/namelist_'+_net1)
    human_name = open('../../../assets/download/num/namelist_'+_net2)


    yeast_treeList = []
    human_treeList = []
    global matchInfo,yeast_nameInfo,human_nameInfo
    matchInfo = []
    yeast_nameInfo = {}
    human_nameInfo = {}

    '''read from sif_num.txt of match info'''
    lineId = 0
    for line in open_object_map:
        if(lineId!=0):
            strline = line.strip().split()
            node1 = int(strline[0])
            node2 = int(strline[1])
            color = '#'+hex(rgb2hex((random.randint(50,230),random.randint(50,230),random.randint(50,230))))[2:]
            matchInfo.append(matchElement(node1,node2,color))
        lineId = lineId + 1

    open_object_map.close()

    print('mapping over')

    '''read from num_*Net.txt of name info'''
    lineId = 0
    for line in yeast_name:
        if(lineId!=0):
            strline = line.strip().split()
            num = int(strline[0])
            name = strline[1].strip()
            yeast_nameInfo[num]=name
        lineId = lineId + 1
    yeast_name.close()

    print('net1 over')
    
    '''read from num_*Net.txt of name info'''
    lineId = 0
    for line in human_name:
        if(lineId!=0):
            strline = line.strip().split()
            num = int(strline[0])
            name = strline[1].strip()
            human_nameInfo[num]=name
        lineId = lineId + 1
    human_name.close()

    print('net2 over')

    tree_construct(yeast_treeList,matchInfo,yeast_net,yeast_tree,yeast_json,1)
    tree_construct(human_treeList,matchInfo,human_net,human_tree,human_json,2)

    print("end")

    return 0

#network_json('ce2.txt','dm2.txt','ce-dm.txt')
