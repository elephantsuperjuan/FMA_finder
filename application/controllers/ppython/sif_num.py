# -*- coding: utf-8 -*-
import php_python

#step 1(2):将比对结果的gene name 转化为数字
sif_object = open('yh/isorank-yh.txt')
num_human = open('num_HumanNet.txt')
num_yeast = open('num_YeastNet.txt')

sif_num = open('yh/sif_num/isorank-yh.txt','w')

human_List = []
yeast_List = []

for line in num_human:
    strline = line.strip().split()
    node = strline[1]
    human_List.append(node)

for line in num_yeast:
    strline = line.strip().split()
    node = strline[1]
    yeast_List.append(node)

lineId=0
for line in sif_object:
    if(lineId!=0):
        strline = line.strip().split()
        node1 = strline[0].upper()
        node2 = strline[1].upper()
        yeast_index = yeast_List.index(node1)
        human_index = human_List.index(node2)
        sif_num.write(str(yeast_index)+' '+str(human_index)+'\n')
    lineId = lineId +1

sif_num.close()
sif_object.close()
num_human.close()
num_yeast.close()

