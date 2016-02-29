# -*- coding: utf-8 -*- 
from py2neo import neo4j, cypher, node, rel
import datetime
import time
import sys

graph_db = neo4j.GraphDatabaseService("http://localhost:7474/db/data")
#print(graph_db.neo4j_version)

relationType = []
node = graph_db.get_or_create_index(neo4j.Node, "Node")

# graph_db.clear()
# graph_db.refresh()

#输入参数：HUMAN num_HumanNet.txt log.txt
#注意第一个参数是大写，否则会强制转为大写
#输入文件格式为
#ID NAME
SPECIES = sys.argv[1].upper()
INPUTFILE = sys.argv[2]
OUTPUTFILE = sys.argv[3]
file_object = open(INPUTFILE)
write_object = open(OUTPUTFILE, 'a')
write_object.write(datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")+' '+' '.join(sys.argv)+'\n')

number = 0
lineID = 0
nodeID = 0
start = datetime.datetime.now()
start_time = datetime.datetime.now()

for line in file_object:
    strline = line.strip().split()
    lineID = lineID+1

    if (lineID == 1):
        for type in strline:
            relationType.append('type')
            print(type)
    else:
        source = strline[0].upper()
        target = strline[1].upper()
        # queryStr = "MATCH n WHERE n.SPECIES= '"+SPECIES+"' AND n.ID = '"+source+"' RETURN n"
        # sourceNode = neo4j.CypherQuery(graph_db,queryStr).execute()
        # queryStr = "MATCH n WHERE n.SPECIES= '"+SPECIES+"' AND n.ID = '"+target+"' RETURN n"
        # targetNode = neo4j.CypherQuery(graph_db,queryStr).execute()

        queryStr = "MATCH n ,m WHERE n.SPECIES= '"+SPECIES+"' AND n.ID = '"+source+"' AND m.SPECIES='"+SPECIES+"' AND m.ID='"+target+"' CREATE (m)-[:connected]->(n) CREATE (n)-[:connected]->(m)"
        #print(queryStr)
        conn = neo4j.CypherQuery(graph_db,queryStr).execute()
        # print(sourceNode[0])
        # if not sourceNode:
        #     print('ERROR with '+strline[0])
        # if not targetNode:
        #     print('ERROR with '+strline[1])
        # #neighborhood._get_or_create("neighborhood",value2,(sourceNode,"conn",targetNode))
        # edge = graph_db.create(rel(sourceNode[0], "", targetNode[0]))

    pass
end = datetime.datetime.now()
write_object.write(str(nodeID)+' '+(end-start).seconds.__str__()+' s \n')
print(nodeID)
file_object.close()
write_object.close()