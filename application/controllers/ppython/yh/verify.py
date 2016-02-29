# -*- coding: utf-8 -*- 
import sys

def getInputList(inputfile):
	open_input = open(inputfile)
	inputList = []
	for line in open_input:
		inputList.append(line.strip())

	open_input.close()
	return inputList

def filterAlignmentByInputList(alignmentfile,inputList):
	open_alignment = open(alignmentfile)
	outputList = []
	lineId = 0
	for line in open_alignment:
		if(lineId!=0):
			strline = line.strip().split()
			node1 = strline[0]
			node2 = strline[1]
			if(node1 in inputList):
				outputList.append(node2)
		lineId = lineId + 1

	open_alignment.close()
	return outputList

def filterAlignmentByInputList_line(alignmentfile,inputList):
	open_alignment = open(alignmentfile)
	outputList = []
	lineId = 0
	for line in open_alignment:
		if(lineId!=0):
			strline = line.strip().split()
			node1 = strline[0]
			node2 = strline[1]
			if(node1 in inputList):
				outputList.append(line)
		lineId = lineId + 1

	open_alignment.close()
	return outputList

def filterOutputByDestList(outputList,destList):
	filterList = []
	for item in outputList:
		if(item in destList):
			filterList.append(item)
	return filterList

def filterAlignmentByFilterList_line(outputList_line,filterList):
	filterList_line = []
	lineId = 0
	for line in outputList_line:
		if(lineId!=0):
			strline = line.strip().split()
			node1 = strline[0]
			node2 = strline[1]
			if(node2 in filterList):
				filterList_line.append(line)
		lineId = lineId + 1

	return filterList_line

def verifyResult(verifyfile,outputList,outputList_line,filterList,filterList_line):
	open_verifyfile = open(verifyfile,'w')
	#输出结果文件
	open_verifyfile.write(str(len(outputList))+'\n')
	for item in outputList:
		open_verifyfile.write(item+'\n')

	open_verifyfile.write('*****filter by dest cluster******\n')
	open_verifyfile.write(str(len(filterList))+'\n')
	for item in filterList:
		open_verifyfile.write(item+'\n')

	open_verifyfile.write('*****原始匹配结果******\n')
	open_verifyfile.write(str(len(outputList_line))+'\n')
	for item in outputList_line:
		open_verifyfile.write(item)

	open_verifyfile.write('*****过滤后原始匹配结果******\n')
	open_verifyfile.write(str(len(filterList_line))+'\n')
	for item in filterList_line:
		open_verifyfile.write(item)

	open_verifyfile.close()

inputfile = 'verify/input-cluster.txt'
#alignmentfile = 'piswap-yh.txt'
alignmentfile = sys.argv[1]
destfile = 'verify/dest-cluster.txt'
verifyfile = 'verify/'+alignmentfile

#原始文件的输入文件
inputList = getInputList(inputfile)
#根据输入文件得到匹配结果的node2列表
outputList = filterAlignmentByInputList(alignmentfile,inputList)
#根据输入文件得到匹配结果的node1 node2(匹配列表)
outputList_line = filterAlignmentByInputList_line(alignmentfile,inputList)

#目标文件的输入文件
destList = getInputList(destfile)
#根据目标输入文件过滤node2列表
filterList = filterOutputByDestList(outputList,destList)
#根据过滤后的node2列表获取匹配结果的node1 node2(匹配列表)
filterList_line = filterAlignmentByFilterList_line(outputList_line,filterList)

#输出原始文件的node2列表、过滤后的node2列表、原始的匹配结果
verifyResult(verifyfile,outputList,outputList_line,filterList,filterList_line)