#coding:utf-8

import os
import sys
import json

class nodeElement:
	def __init__(self,id='',name='',go_item=[]):
		self.id = id
		self.name = name
		self.go_item = go_item
	def findByName(self,namestr=''):
		if(namestr==self.name):
			return True
		return False

def findGoNode(golist,namestr):
	#print("begin find "+name)
	for each in golist:
		if(each.findByName(namestr)):
			return each
		# else:
		# 	print(str(each.name)+" "+str(each.go_item))
	return False

def GofromMJ(golist_file,numlist_file,log_filename):
	golist_object = open(golist_file)
	golist = []
	name_tmp = ''
	for line in golist_object:
		line_arr = line.split()
		if(len(line_arr) != 0):
			name = line_arr[2]
			if(name==name_tmp):
				go_tmp = findGoNode(golist,name)
				if(go_tmp):
					go_tmp.go_item.append(line_arr[3])
					#print(str(go_tmp.name)+" "+str(go_tmp.go_item))
			else:
				go_node = nodeElement('',name,[line_arr[3]])
				name_tmp = name
				golist.append(go_node)
				#print("first "+str(go_node.name)+" "+str(go_node.go_item))

	golist_object.close()

	numlist_object = open(numlist_file)
	for line in numlist_object:
		line_arr = line.split();
		if(len(line_arr) ==2):
			namestr = line_arr[1]
			go_tmp = findGoNode(golist,namestr)
			if(go_tmp):
				go_tmp.id = line_arr[0]
			else:
				go_node = nodeElement(line_arr[0],namestr)
				golist.append(go_node)
	numlist_object.close()

	log_file = open(log_filename,'w');
	# encodedjson = json.dumps(golist)
	# log_file.write(encodedjson)
	log_file.write('{"nodes":[\n')
	lineId = 0
	for each in golist:
		if(each.id!=''):
			if(lineId==0):
				log_file.write('{"id":'+str(each.id)+',"name": "'+str(each.name)+'","go": "'+str(each.go_item)+'"}')
			else:
				log_file.write(',\n{"id":'+str(each.id)+',"name": "'+str(each.name)+'","go": "'+str(each.go_item)+'"}')
			lineId = lineId + 1
	log_file.write('\n]}')
	log_file.close()
	print("total line: "+str(lineId))

def GofromUniprot(golist_file,numlist_file,log_filename):
	golist_object = open(golist_file)
	golist = []
	lineId = 0
	for line in golist_object:
		if(lineId!=0):
			line_arr = line.split('\t')
			if(len(line_arr) != 0):
				'''
				一般情况下
				'''
				# name = line_arr[1].upper()
				'''
				JejuniGO.tab is different from others
				'''
				name_arr = line_arr[1].upper().split(' ')
				name = ''
				for name_tmp in name_arr:
					if(name_tmp[0:2]=='CJ'):
						name = name_tmp
				# print name
				
				if(name!=''):
					go_item = line_arr[3].replace(' ','').split(';')
					#print str(go_item)
					go_node = nodeElement('',name,go_item)
					golist.append(go_node)
				#else:
					#print lineId+1
					#print line
		lineId = lineId + 1

	golist_object.close()

	numlist_object = open(numlist_file)
	for line in numlist_object:
		line_arr = line.split();
		if(len(line_arr) ==2):
			namestr = line_arr[1]
			go_tmp = findGoNode(golist,namestr)
			if(go_tmp):
				go_tmp.id = line_arr[0]
			else:
				go_node = nodeElement(line_arr[0],namestr)
				golist.append(go_node)
	numlist_object.close()

	log_file = open(log_filename,'w');
	# encodedjson = json.dumps(golist)
	# log_file.write(encodedjson)
	log_file.write('{"nodes":[\n')
	lineId = 0
	for each in golist:
		if(each.id!=''):
			if(lineId==0):
				log_file.write('{"id":'+str(each.id)+',"name":"'+str(each.name)+'","go": '+str(each.go_item)+'}')
			else:
				log_file.write(',\n{"id":'+str(each.id)+',"name":"'+str(each.name)+'","go": '+str(each.go_item)+'}')
			lineId = lineId + 1
	log_file.write('\n]}')
	log_file.close()
	print("total line: "+str(lineId))

def filterGolist(golist_file,numlist_file,log_filename,namelist_file):
	golist_object = open(golist_file)
	golist = []
	lineId = 0
	for line in golist_object:
		if(lineId!=0):
			line_arr = line.split('\t')
			if(len(line_arr) != 0):
				name = line_arr[1].upper()
				#print name
				if(name!=''):
					go_item = line_arr[3].replace(' ', '').split(';')
					#print str(go_item)
					go_node = nodeElement('',name,go_item)
					golist.append(go_node)
				else:
					print lineId+1
					print line
		lineId = lineId + 1
	golist_object.close()

	numlist_object = open(numlist_file)
	for line in numlist_object:
		line_arr = line.split();
		if(len(line_arr) ==2):
			namestr = line_arr[1]
			go_tmp = findGoNode(golist,namestr)
			if(go_tmp):
				go_tmp.id = line_arr[0]
			else:
				go_node = nodeElement(line_arr[0],namestr)
				golist.append(go_node)
	numlist_object.close()

	namelist = []
	namelist_object = open(namelist_file)
	lineId = lineId+1
	for line in namelist_object:
		line = line.strip()
		if(lineId!=0):
			if(len(line) != 0):
				name = line[4:]
				#print name
				if(name!=''):
					namelist.append(name)
				else:
					print lineId+1
					print line
		lineId = lineId + 1
	namelist_object.close()

	log_file = open(log_filename,'w');
	# encodedjson = json.dumps(golist)
	# log_file.write(encodedjson)
	log_file.write('{"nodes":[\n')
	lineId = 0
	filtergo_list = []
	for each in golist:
		if(each.id!='' and (each.id in namelist)):
			filtergo_list.append(each.go_item)
			if(lineId==0):
				log_file.write('{"id":'+str(each.id)+',"name":"'+str(each.name)+'","go": '+str(each.go_item)+'}')
			else:
				log_file.write(',\n{"id":'+str(each.id)+',"name":"'+str(each.name)+'","go": '+str(each.go_item)+'}')
			lineId = lineId + 1
	log_file.write('\n]}')

	filtergo_dict = {}
	for filtergo in filtergo_list:
		for item in filtergo:
			if filtergo_dict.has_key(item):
				filtergo_dict[item] = filtergo_dict[item] + 1
			else:
				filtergo_dict[item] = 1

	for (k,v) in filtergo_dict.items():
		log_file.write(str(k)+" "+str(v)+"\n")

	log_file.close()
	print("total line: "+str(lineId))


# if __name__ == '__main__':
# 	if not (len(sys.argv)==4 or len(sys.argv)==5):
# 		print("Usage: ./GOlist.py num_yeastNet.txt yeastGO.tab test.json")
# 		print("Usage: ./GOlist.py num_yeastNet.txt yeastGO.tab test.json filter_yeastlist.txt")
# 		exit(1)

# 	if (len(sys.argv)==4):
# 		numlist_file =sys.argv[1]
# 		golist_file = sys.argv[2]
# 		log_filename = sys.argv[3]

# 		GofromUniprot(golist_file,numlist_file,log_filename)
# 		#GofromMJ(golist_file,numlist_file,log_filename)
		
# 	if (len(sys.argv)==5):
# 		numlist_file =sys.argv[1]
# 		golist_file = sys.argv[2]
# 		log_filename = sys.argv[3]
# 		namelist_file = sys.argv[4]

# 		filterGolist(golist_file,numlist_file,log_filename,namelist_file)

# GofromUniprot('EcoliGO.tab','namelist_EcoliNet.txt','EcoliGO.json')
GofromUniprot('JejuniGO.tab','namelist_JejuniNet.txt','JejuniGO.json')
