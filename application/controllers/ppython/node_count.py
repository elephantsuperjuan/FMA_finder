# -*- coding: utf-8 -*-
import php_python

#step 1(1):将单个网络的gene name 转化为数字
def network_num(file):
	#file = 'ce.txt'
	openfile = '../../../assets/download/src/'+file
	outfile = '../../../assets/download/num/namelist_'+file
	numfile = '../../../assets/download/num/num_'+file

	open_object = open(openfile,'r')
	num_object = open(outfile,'w')
	write_object = open(numfile,'w')

	nodeList = []

	lineId = 0
	for line in open_object:
		lineId = lineId + 1
		#if(lineId==1):
			#write_object.write('Node1\tNode2\n')
		#else:
		if(lineId!=1):
			strline = line.strip().split()
			node1 = strline[0].upper()
			node2 = strline[1].upper()
			if(node1 not in nodeList):
				nodeList.append(node1)
			node1_num = nodeList.index(node1)
			if(node2 not in nodeList):
				nodeList.append(node2)
			node2_num = nodeList.index(node2)

			write_object.write(str(node1_num)+' '+str(node2_num)+'\n')

	num_object.write('NO.\tName\n')
	for i in range(0,len(nodeList)):
		num_object.write(str(i)+'\t'+str(nodeList[i])+'\n')

	print('Edge number:'+str(lineId-1))
	print('Node number:'+str(len(nodeList)))

	return 'num_'+file


#step 1(2):将比对结果的gene name 转化为数字
def sif_num(net1,net2,sif):
	sif_object = open('../../../assets/download/src/'+sif)
	num_net1 = open('../../../assets/download/num/namelist_'+net1)
	num_net2 = open('../../../assets/download/num/namelist_'+net2)

	sif_num = open('../../../assets/download/num/num_'+sif,'w')

	net1_List = []
	net2_List = []

	lineId = 0
	for line in num_net1:
		if(lineId!=0):
		    strline = line.strip().split()
		    node = strline[1].upper()
		    net1_List.append(node)
		lineId = lineId + 1

	lineId = 0
	for line in num_net2:
		if(lineId!=0):
		    strline = line.strip().split()
		    node = strline[1].upper()
		    net2_List.append(node)
		lineId = lineId + 1

	lineId=0
	for line in sif_object:
	    if(lineId!=0):
	        strline = line.strip().split()
	        node1 = strline[0].upper()
	        node2 = strline[1].upper()
	        if(node1 in  net1_List):
	        	net1_index = net1_List.index(node1)
		        if(node2 in net2_List):
		        	net2_index = net2_List.index(node2)
		        	sif_num.write(str(net1_index)+'\t'+str(net2_index)+'\n')
	    else:
	    	sif_num.write('NET1_NODE\tNET2_NODE\n')
	    lineId = lineId + 1

	sif_num.close()
	sif_object.close()
	num_net2.close()
	num_net1.close()

	return 'num_'+sif


# network_num('ce.txt');
# network_num('dm.txt');
# sif_num('ce.txt','dm.txt','ce-dm.txt');